<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{
    protected $fillable = [
        'asset_id',
        'department_id',
        'assigned_to',
        'assigned_date',
        'returned_date',
        'status',
        'remarks',
        'assigned_by',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'returned_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
