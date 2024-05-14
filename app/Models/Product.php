<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    public function getCategory()
//    {
//       return Category::find($this->category_id);
////        dd($category);
//    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
//    use HasFactory;
}
