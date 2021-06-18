<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','barcode','cost','price','stock','image','alerts','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getImageAttribute($image)
    {
        if ($image == null) {
            return 'noimg.png';
        }
        if (file_exists('storage/products/'. $image)) {
            return $image;
        }

        return 'noimg.png';
    }
}
