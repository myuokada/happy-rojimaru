<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    #(ADMIN SIDE) Get all posts related to a category
    public function categoryPost() {
        return $this->hasMany(CategoryPost::class);
    }
}
