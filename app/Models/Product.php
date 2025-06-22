<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    // Mass assignable fields
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'picture',
    ];

    // Casts
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor untuk URL gambar
    public function getPictureUrlAttribute()
    {
        if ($this->picture) {
            return asset('storage/' . $this->picture);
        }
        return null;
    }

    // Accessor untuk thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        if ($this->picture) {
            return asset('storage/' . $this->picture);
        }
        return null;
    }
}
