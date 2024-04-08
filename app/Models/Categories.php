<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['title', 'id_users'];
    protected $primaryKey = 'id_categories';

    public function products()
    {
        return $this->hasMany(Products::class, 'id_categories');
    }
}