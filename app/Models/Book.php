<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = ['title', 'author', 'description', 'image','category_id','status'];


    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
