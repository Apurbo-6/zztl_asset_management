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
        'purchased_at',
        'shipping_charge',
        'extra_charge',
        'extra_charge_description',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchased_at' => 'datetime',
        'shipping_charge' => 'decimal:2',
        'extra_charge' => 'decimal:2',
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

    public function attachments()
    {
        return $this->hasMany(PurchaseAttachment::class);
    }

    public function getItemsTotalAttribute(): float
    {
        return $this->relationLoaded('assets')
            ? (float) $this->assets->sum('total_price')
            : (float) $this->assets()->sum('total_price');
    }

    public function getGrandTotalAttribute(): float
    {
        return $this->items_total + (float) $this->shipping_charge + (float) $this->extra_charge;
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
