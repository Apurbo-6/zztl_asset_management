<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Purchase List
     */
    public function index(Request $request)
    {
        $purchases = Purchase::with(['supplier', 'assets'])
            ->when($request->q, function ($query, $q) {
                $query->where('invoice_no', 'like', "%{$q}%")
                    ->orWhereHas('supplier', function ($supplier) use ($q) {
                        $supplier->where('name', 'like', "%{$q}%");
                    });
            })
            ->latest('purchase_date')
            ->paginate(15)
            ->withQueryString();

        return view('purchases.index', compact('purchases'));
    }


    /**
     * Create Purchase
     */
    public function create()
    {
        $suppliers = Supplier::where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'purchases.create',
            compact('suppliers', 'categories')
        );
    }


    /**
     * Store Purchase + Multiple Assets
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'invoice_no' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['required', 'date'],
            'shipping_charge' => ['nullable', 'numeric', 'min:0'],
            'extra_charge' => ['nullable', 'numeric', 'min:0'],
            'extra_charge_description' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'invoice_files' => ['nullable', 'array', 'max:10'],
            'invoice_files.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:20480'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.category_id' => [
                'required',
                'exists:categories,id'
            ],

            'items.*.particular_items' => [
                'required',
                'string',
                'max:255'
            ],

            'items.*.brand_name' => [
                'nullable',
                'string',
                'max:150'
            ],

            'items.*.serial_number' => [
                'nullable',
                'string',
                'max:255'
            ],

            'items.*.qty' => [
                'required',
                'numeric',
                'min:0.01'
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'items.*.warranty' => [
                'nullable',
                'string',
                'max:100'
            ],

            'items.*.remarks' => [
                'nullable',
                'string'
            ],
        ]);

        foreach ($validated['items'] as $index => $item) {
            if (Category::whereKey($item['category_id'])->value('serial_required')) {
                if (empty($item['serial_number'])) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "items.{$index}.serial_number" => 'A serial number is required for this category.',
                    ]);
                }
                if ((float) $item['qty'] !== 1.0) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "items.{$index}.qty" => 'Use one individually tracked asset per line so each serial number has its own asset ID.',
                    ]);
                }
            }
        }

        $purchase = DB::transaction(function () use ($validated, $request) {

            /*
            |--------------------------------------------------------------------------
            | Create Purchase / Invoice
            |--------------------------------------------------------------------------
            */

            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'] ?? null,
                'invoice_no' => $validated['invoice_no'] ?? null,
                'purchase_date' => substr($validated['purchase_date'], 0, 10),
                'purchased_at' => $validated['purchase_date'],
                'shipping_charge' => $validated['shipping_charge'] ?? 0,
                'extra_charge' => $validated['extra_charge'] ?? 0,
                'extra_charge_description' => $validated['extra_charge_description'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Individual Assets
            |--------------------------------------------------------------------------
            */

            foreach ($validated['items'] as $item) {

                $qty = (float) $item['qty'];
                $unitPrice = (float) $item['unit_price'];

                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | Each row is an individual asset.
                |
                | Example:
                |
                | 5 Laptops
                |
                | → You should add 5 rows
                | → Each row can have its own Serial Number
                |
                */

                $asset = Asset::create([
                    'purchase_id' => $purchase->id,

                    'category_id' => $item['category_id'],

                    'supplier_id' => $validated['supplier_id'] ?? null,

                    'particular_items' => $item['particular_items'],

                    'purchase_date' => substr($validated['purchase_date'], 0, 10),

                    'invoice_no' => $validated['invoice_no'] ?? null,

                    'serial_number' => $item['serial_number'] ?? null,

                    'brand_name' => $item['brand_name'] ?? null,

                    'qty' => $qty,

                    'unit_price' => $unitPrice,

                    'total_price' => $qty * $unitPrice,

                    'warranty' => $item['warranty'] ?? null,

                    'remarks' => $item['remarks'] ?? null,

                    'status' => 'available',

                    'created_by' => Auth::id(),

                    'updated_by' => Auth::id(),
                ]);

                $categoryCode = strtoupper(Category::whereKey($item['category_id'])->value('code') ?: 'CAT');
                $asset->update(['asset_code' => 'ZZTL-' . $categoryCode . '-' . str_pad((string) $asset->id, 7, '0', STR_PAD_LEFT)]);
            }

            foreach ($request->file('invoice_files', []) as $file) {
                $original = $file->getClientOriginalName();
                $mime = $file->getMimeType();
                $originalSize = $file->getSize();
                $extension = strtolower($file->getClientOriginalExtension());
                $storedName = Str::uuid() . '.' . $extension;
                $path = $file->storeAs('purchases/' . $purchase->id, $storedName, 'private');

                // Re-encode image scans as optimized WebP when GD is available. PDFs are stored as uploaded.
                if (str_starts_with((string) $mime, 'image/') && extension_loaded('gd') && function_exists('imagewebp')) {
                    $image = @imagecreatefromstring(file_get_contents($file->getRealPath()));
                    if ($image) {
                        $width = imagesx($image);
                        $height = imagesy($image);
                        $scale = min(1, 2400 / max($width, $height));
                        $canvas = imagecreatetruecolor(max(1, (int) ($width * $scale)), max(1, (int) ($height * $scale)));
                        imagecopyresampled($canvas, $image, 0, 0, 0, 0, imagesx($canvas), imagesy($canvas), $width, $height);
                        $webpName = Str::uuid() . '.webp';
                        $webpPath = storage_path('app/private/purchases/' . $purchase->id . '/' . $webpName);
                        if (imagewebp($canvas, $webpPath, 78)) {
                            Storage::disk('private')->delete($path);
                            $path = 'purchases/' . $purchase->id . '/' . $webpName;
                            $storedName = $webpName;
                            $mime = 'image/webp';
                        }
                        imagedestroy($image);
                        imagedestroy($canvas);
                    }
                }

                $purchase->attachments()->create([
                    'original_file_name' => $original,
                    'stored_file_name' => $storedName,
                    'file_path' => $path,
                    'mime_type' => $mime,
                    'original_size' => $originalSize,
                    'compressed_size' => Storage::disk('private')->size($path),
                    'created_by' => Auth::id(),
                ]);
            }

            return $purchase;
        });


        return redirect()
            ->route('purchases.index')
            ->with(
                'success',
                'Purchase and assets created successfully.'
            );
    }


    /**
     * Purchase Details
     */
    public function show(Purchase $purchase)
    {
        $purchase->load([
            'supplier',
            'attachments',
            'assets.category',
            'assets.activeAssignment.department'
        ]);

        return view(
            'purchases.show',
            compact('purchase')
        );
    }




    /**
     * Edit Purchase
     */
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $purchase->load('assets');

        return view(
            'purchases.edit',
            compact(
                'purchase',
                'suppliers',
                'categories'
            )
        );
    }


    /**
     * Update Purchase
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'invoice_no' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['required', 'date'],
            'shipping_charge' => ['nullable', 'numeric', 'min:0'],
            'extra_charge' => ['nullable', 'numeric', 'min:0'],
            'extra_charge_description' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
        ]);

        $purchase->update([
            'supplier_id' => $validated['supplier_id'] ?? null,
            'invoice_no' => $validated['invoice_no'] ?? null,
            'purchase_date' => substr($validated['purchase_date'], 0, 10),
            'purchased_at' => $validated['purchase_date'],
            'shipping_charge' => $validated['shipping_charge'] ?? 0,
            'extra_charge' => $validated['extra_charge'] ?? 0,
            'extra_charge_description' => $validated['extra_charge_description'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with('success', 'Purchase updated successfully.');
    }


    /**
     * Delete Purchase
     */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {

            $purchase->assets()->delete();

            $purchase->delete();
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}
