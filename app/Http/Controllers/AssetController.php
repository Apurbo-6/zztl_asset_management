<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\AssetAttachment;
use App\Support\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index(Request $r)
    {
        $q = Asset::with(['category', 'supplier']);
        if ($r->filled('q')) $q->where(function ($x) use ($r) {
            $v = $r->q;
            $x->where('particular_items', 'like', "%$v%")->orWhere('invoice_no', 'like', "%$v%")->orWhere('serial_number', 'like', "%$v%")->orWhere('brand_name', 'like', "%$v%");
        });
        if ($r->filled('category_id')) $q->where('category_id', $r->category_id);
        if ($r->filled('supplier_id')) $q->where('supplier_id', $r->supplier_id);
        if ($r->filled('year')) $q->whereYear('purchase_date', $r->year);
        if ($r->filled('start_date')) $q->whereDate('purchase_date', '>=', $r->start_date);
        if ($r->filled('end_date')) $q->whereDate('purchase_date', '<=', $r->end_date);
        $filtered = (clone $q);
        $summary = ['records' => (clone $filtered)->count(), 'quantity' => (clone $filtered)->sum('qty'), 'amount' => (clone $filtered)->sum('total_price')];
        $assets = $q->latest('purchase_date')->latest('id')->paginate(20)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();
        $years = Asset::selectRaw('YEAR(purchase_date) as year')->distinct()->orderByDesc('year')->pluck('year');
        return view('assets.index', compact('assets', 'categories', 'suppliers', 'years', 'summary'));
    }
    public function create()
    {
        return view('assets.form', ['asset' => new Asset, 'categories' => Category::where('is_active', true)->orderBy('name')->get(), 'suppliers' => Supplier::where('is_active', true)->orderBy('name')->get()]);
    }
    public function store(Request $r)
    {
        $data = $this->validated($r);
        $data['created_by'] = $r->user()->id;
        $asset = Asset::create($data);
        $this->saveFiles($r, $asset);
        Activity::record('created', 'assets', 'Created purchase record #' . $asset->id, [], $asset->only(['particular_items', 'category_id', 'supplier_id', 'purchase_date', 'invoice_no', 'qty', 'unit_price', 'total_price']));
        return redirect()->route('assets.show', $asset)->with('success', 'Purchase record created.');
    }
    public function show(Asset $asset)
    {
        $asset->load(['category', 'supplier', 'attachments', 'creator']);
        return view('assets.show', compact('asset'));
    }
    public function edit(Asset $asset)
    {
        return view('assets.form', ['asset' => $asset->load('attachments'), 'categories' => Category::where('is_active', true)->orderBy('name')->get(), 'suppliers' => Supplier::where('is_active', true)->orderBy('name')->get()]);
    }
    public function update(Request $r, Asset $asset)
    {
        $old = $asset->only(['particular_items', 'category_id', 'supplier_id', 'purchase_date', 'invoice_no', 'serial_number', 'brand_name', 'qty', 'unit_price', 'total_price', 'warranty', 'received_by', 'remarks']);
        $data = $this->validated($r);
        $data['updated_by'] = $r->user()->id;
        $asset->update($data);
        $this->saveFiles($r, $asset);
        Activity::record('updated', 'assets', 'Updated purchase record #' . $asset->id, $old, $asset->fresh()->only(array_keys($old)));
        return redirect()->route('assets.show', $asset)->with('success', 'Purchase record updated.');
    }
    public function destroy(Asset $asset)
    {
        $old = $asset->only(['particular_items', 'invoice_no', 'total_price']);
        $asset->delete();
        Activity::record('deleted', 'assets', 'Moved purchase record #' . $asset->id . ' to trash', $old, []);
        return redirect()->route('assets.index')->with('success', 'Purchase record moved to trash.');
    }
    private function validated(Request $r): array
    {
        return $r->validate(['category_id' => 'required|exists:categories,id', 'supplier_id' => 'nullable|exists:suppliers,id', 'particular_items' => 'required|string|max:255', 'purchase_date' => 'required|date', 'invoice_no' => 'nullable|string|max:100', 'serial_number' => 'nullable|string|max:255', 'brand_name' => 'nullable|string|max:150', 'qty' => 'required|numeric|min:0.01', 'unit_price' => 'required|numeric|min:0', 'total_price' => 'required|numeric|min:0', 'warranty' => 'nullable|string|max:100', 'received_by' => 'nullable|string|max:150', 'remarks' => 'nullable|string', 'invoice_files' => 'nullable|array|max:5', 'invoice_files.*' => 'file|mimes:pdf,jpg,jpeg,png,webp|max:5120', 'item_images' => 'nullable|array|max:5', 'item_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240']);
    }
    private function saveFiles(Request $r, Asset $asset): void
    {
        foreach (['invoice_files' => 'invoice', 'item_images' => 'item_image'] as $field => $type) {
            foreach ($r->file($field, []) as $file) {
                $original = $file->getClientOriginalName();
                $mime = $file->getMimeType();
                $size = $file->getSize();
                $name = Str::uuid() . '.' . $file->extension();
                $path = $file->storeAs('assets/' . $asset->id, $name, 'private');
                // Images are resized/compressed to WebP when GD supports it; PDF invoices remain unchanged.
                if (str_starts_with((string)$mime, 'image/') && extension_loaded('gd') && function_exists('imagewebp')) {
                    $img = @imagecreatefromstring(file_get_contents($file->getRealPath()));
                    if ($img) {
                        $w = imagesx($img);
                        $h = imagesy($img);
                        $max = 1800;
                        $scale = min(1, $max / max($w, $h));
                        $nw = max(1, (int)($w * $scale));
                        $nh = max(1, (int)($h * $scale));
                        $canvas = imagecreatetruecolor($nw, $nh);
                        imagecopyresampled($canvas, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);
                        $webp = storage_path('app/private/assets/' . $asset->id . '/' . Str::uuid() . '.webp');
                        imagewebp($canvas, $webp, 78);
                        imagedestroy($img);
                        imagedestroy($canvas);
                        if (is_file($webp)) {
                            Storage::disk('private')->delete($path);
                            $path = 'assets/' . $asset->id . '/' . basename($webp);
                            $name = basename($webp);
                            $mime = 'image/webp';
                        }
                    }
                }
                AssetAttachment::create(['asset_id' => $asset->id, 'attachment_type' => $type, 'original_file_name' => $original, 'stored_file_name' => $name, 'file_path' => $path, 'mime_type' => $mime, 'original_size' => $size, 'compressed_size' => Storage::disk('private')->size($path), 'created_by' => $r->user()->id]);
            }
        }
    }
}
