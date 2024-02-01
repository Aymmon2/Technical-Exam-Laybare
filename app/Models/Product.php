<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $primaryKey = 'product_id';
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }

}
