<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'purchase_id',
        'asset_code',

        'category_id',
        'supplier_id',

        'particular_items',

        'purchase_date',
        'invoice_no',

        'serial_number',
        'brand_name',

        'qty',
        'unit_price',
        'total_price',

        'warranty',

        'received_by',

        'remarks',

        'status',

        'created_by',
        'updated_by',
    ];


    protected $casts = [
        'purchase_date' => 'date',
        'qty' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];


    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function attachments()
    {
        return $this->hasMany(AssetAttachment::class);
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function activeAssignment()
    {
        return $this->hasOne(AssetAssignment::class)
            ->where('status', 'assigned')
            ->latest();
    }
}
