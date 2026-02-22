<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'subject',
        'category',
        'author',
        'pages',
        'language',
        'published_date',
        'quantity',
        'location',
        'image',
        'file',
    ];

    public function borrowBooks()
    {
        return $this->hasMany(BorrowBook::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/images/default-book.svg');
    }

    public function getFileUrlAttribute()
    {
        return $this->file ? asset('storage/' . $this->file) : null;
    }
}
