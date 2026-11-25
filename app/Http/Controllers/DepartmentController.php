<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Department List
     */
    public function index(Request $request)
    {
        $departments = Department::query()
            ->when($request->q, function ($query, $q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('departments.index', compact('departments'));
    }


    /**
     * Create Department Page
     */
    public function create()
    {
        return view('departments.create');
    }


    /**
     * Store Department
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                'unique:departments,name'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],
        ]);

        Department::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created successfully.');
    }


    /**
     * Edit Department Page
     */
    public function edit(Department $department)
    {
        return view(
            'departments.edit',
            compact('department')
        );
    }


    /**
     * Update Department
     */
    public function update(
        Request $request,
        Department $department
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                'unique:departments,name,' . $department->id
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],
        ]);

        $department->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }


    /**
     * Delete Department
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
