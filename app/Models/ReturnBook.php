<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    protected $fillable = [
        'borrow_book_id',
        'return_date',
        'status',
        'fine',
    ];

    public function borrowBook(){
        return $this->belongsTo(BorrowBook::class);
    }
}
