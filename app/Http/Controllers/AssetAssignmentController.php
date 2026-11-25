<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Department;
use App\Models\AssetAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetAssignmentController extends Controller
{
    /**
     * Assignment List
     */
    public function index(Request $request)
    {
        $assignments = AssetAssignment::with([
            'asset',
            'department',
            'assignedBy'
        ])
            ->when($request->q, function ($query, $q) {

                $query->where('assigned_to', 'like', "%{$q}%")

                    ->orWhereHas('asset', function ($asset) use ($q) {
                        $asset->where(
                            'particular_items',
                            'like',
                            "%{$q}%"
                        )
                            ->orWhere(
                                'serial_number',
                                'like',
                                "%{$q}%"
                            )
                            ->orWhere(
                                'invoice_no',
                                'like',
                                "%{$q}%"
                            );
                    })

                    ->orWhereHas(
                        'department',
                        function ($department) use ($q) {
                            $department->where(
                                'name',
                                'like',
                                "%{$q}%"
                            );
                        }
                    );
            })
            ->latest('assigned_date')
            ->paginate(15)
            ->withQueryString();

        return view(
            'asset-assignments.index',
            compact('assignments')
        );
    }


    /**
     * Create Assignment Page
     */
    public function create(Request $request)
    {
        $assets = Asset::where('status', 'available')
            ->orderBy('particular_items')
            ->get();

        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'asset-assignments.create',
            compact(
                'assets',
                'departments'
            )
        );
    }


    /**
     * Assign Asset
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => [
                'required',
                'exists:assets,id'
            ],

            'department_id' => [
                'nullable',
                'exists:departments,id'
            ],

            'assigned_to' => [
                'nullable',
                'string',
                'max:150'
            ],

            'assigned_date' => [
                'required',
                'date'
            ],

            'remarks' => [
                'nullable',
                'string'
            ],
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Lock Asset
            |--------------------------------------------------------------------------
            */

            $asset = Asset::lockForUpdate()
                ->findOrFail($validated['asset_id']);


            /*
            |--------------------------------------------------------------------------
            | Prevent Double Assignment
            |--------------------------------------------------------------------------
            */

            if ($asset->status !== 'available') {

                abort(
                    422,
                    'This asset is not available for assignment.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Create Assignment
            |--------------------------------------------------------------------------
            */

            AssetAssignment::create([
                'asset_id' => $asset->id,

                'department_id' =>
                $validated['department_id'] ?? null,

                'assigned_to' =>
                $validated['assigned_to'] ?? null,

                'assigned_date' =>
                $validated['assigned_date'],

                'status' => 'assigned',

                'remarks' =>
                $validated['remarks'] ?? null,

                'assigned_by' => Auth::id(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Update Asset Status
            |--------------------------------------------------------------------------
            */

            $asset->update([
                'status' => 'assigned',
            ]);
        });


        return redirect()
            ->route('asset-assignments.index')
            ->with(
                'success',
                'Asset assigned successfully.'
            );
    }


    /**
     * Edit Assignment
     */
    public function edit(
        AssetAssignment $assetAssignment
    ) {
        $departments = Department::where(
            'is_active',
            true
        )
            ->orderBy('name')
            ->get();

        return view(
            'asset-assignments.edit',
            compact(
                'assetAssignment',
                'departments'
            )
        );
    }


    /**
     * Update Assignment
     */
    public function update(
        Request $request,
        AssetAssignment $assetAssignment
    ) {
        $validated = $request->validate([

            'department_id' => [
                'nullable',
                'exists:departments,id'
            ],

            'assigned_to' => [
                'nullable',
                'string',
                'max:150'
            ],

            'assigned_date' => [
                'required',
                'date'
            ],

            'remarks' => [
                'nullable',
                'string'
            ],

        ]);

        $assetAssignment->update([
            'department_id' =>
            $validated['department_id'] ?? null,

            'assigned_to' =>
            $validated['assigned_to'] ?? null,

            'assigned_date' =>
            $validated['assigned_date'],

            'remarks' =>
            $validated['remarks'] ?? null,
        ]);

        return redirect()
            ->route('asset-assignments.index')
            ->with(
                'success',
                'Asset assignment updated successfully.'
            );
    }


    /**
     * Return Asset
     */
    public function returnAsset(
        Request $request,
        AssetAssignment $assetAssignment
    ) {
        if ($assetAssignment->status === 'returned') {

            return back()->with(
                'success',
                'This asset has already been returned.'
            );
        }


        DB::transaction(function () use ($assetAssignment, $request) {

            $assetAssignment->update([
                'returned_date' => now()->toDateString(),
                'status' => 'returned',
            ]);


            $assetAssignment->asset->update([
                'status' => 'available',
            ]);
        });


        return redirect()
            ->route('asset-assignments.index')
            ->with(
                'success',
                'Asset returned and marked as available.'
            );
    }
}
