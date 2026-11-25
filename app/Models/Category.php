<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'code', 'unit', 'serial_required', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'serial_required' => 'boolean'];
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
