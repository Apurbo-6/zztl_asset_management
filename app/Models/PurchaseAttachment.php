<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseAttachment extends Model
{
    protected $fillable = [
        'purchase_id', 'original_file_name', 'stored_file_name', 'file_path',
        'mime_type', 'original_size', 'compressed_size', 'created_by',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
