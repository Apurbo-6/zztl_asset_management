<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'invoice_no',
        'purchase_date',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // One Purchase/Invoice can contain many individual assets
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
