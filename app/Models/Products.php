<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'model', 'price', 'stock', 'mark', 'id_users'];
    protected $primaryKey = 'id_products';
    protected $foreignKey = 'id_categories';


    public function pruducts()
    {
        return $this->belongsTo(Category::class, 'id_categories');
    }
}