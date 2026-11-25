<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Asset;
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
            'remarks' => ['nullable', 'string'],

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
                'min:1'
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

        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Create Purchase / Invoice
            |--------------------------------------------------------------------------
            */

            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'] ?? null,
                'invoice_no' => $validated['invoice_no'] ?? null,
                'purchase_date' => $validated['purchase_date'],
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

                Asset::create([
                    'purchase_id' => $purchase->id,

                    'category_id' => $item['category_id'],

                    'supplier_id' => $validated['supplier_id'] ?? null,

                    'particular_items' => $item['particular_items'],

                    'purchase_date' => $validated['purchase_date'],

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
            }
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
            'remarks' => ['nullable', 'string'],
        ]);

        $purchase->update([
            'supplier_id' => $validated['supplier_id'] ?? null,
            'invoice_no' => $validated['invoice_no'] ?? null,
            'purchase_date' => $validated['purchase_date'],
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
