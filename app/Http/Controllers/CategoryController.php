<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\Activity;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('assets')->orderBy('name')->paginate(25);
        return view('categories.index', compact('categories'));
    }
    public function create()
    {
        return view('categories.form', ['category' => new Category]);
    }
    public function store(Request $r)
    {
        $d = $r->validate([
            'name' => 'required|string|max:150|unique:categories,name',
            'code' => 'required|string|max:20|alpha_dash|unique:categories,code',
            'unit' => 'required|string|max:50',
            'serial_required' => 'nullable|boolean',
        ]);
        $d['code'] = strtoupper($d['code']);
        $c = Category::create($d + ['serial_required' => false, 'is_active' => $r->boolean('is_active', true)]);
        Activity::record('created', 'categories', 'Created category ' . $c->name, [], $c->toArray());
        return redirect()->route('categories.index')->with('success', 'Category created.');
    }
    public function edit(Category $category)
    {
        return view('categories.form', compact('category'));
    }
    public function update(Request $r, Category $category)
    {
        $old = $category->toArray();
        $d = $r->validate([
            'name' => 'required|string|max:150|unique:categories,name,' . $category->id,
            'code' => 'required|string|max:20|alpha_dash|unique:categories,code,' . $category->id,
            'unit' => 'required|string|max:50',
            'serial_required' => 'nullable|boolean',
        ]);
        $d['code'] = strtoupper($d['code']);
        $category->update($d + ['serial_required' => false, 'is_active' => $r->boolean('is_active')]);
        Activity::record('updated', 'categories', 'Updated category ' . $category->name, $old, $category->toArray());
        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }
    public function destroy(Category $category)
    {
        if ($category->assets()->exists()) return back()->withErrors(['category' => 'This category is used by purchase records. Deactivate it instead.']);
        $category->delete();
        Activity::record('deleted', 'categories', 'Deleted category ' . $category->name);
        return back()->with('success', 'Category deleted.');
    }
}
