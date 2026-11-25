<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAttachment extends Model
{
    protected $fillable = ['asset_id', 'attachment_type', 'original_file_name', 'stored_file_name', 'file_path', 'mime_type', 'original_size', 'compressed_size', 'created_by'];
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
