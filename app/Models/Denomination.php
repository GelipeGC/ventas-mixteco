<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;

    protected $fillable = ['type','value','image'];

    public function getImageAttribute($image)
    {
        if ($image == null) {
            return 'noimg.png';
        }
        if (file_exists('storage/denominations/'. $image)) {
            return $image;
        }

        return 'noimg.png';
    }
}
