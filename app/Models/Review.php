<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //

    protected $fillable = [
        'book_id',
        'user_id',
        'review',
        'rating',
        'status',
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
