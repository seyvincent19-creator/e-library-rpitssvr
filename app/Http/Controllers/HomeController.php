<?php

namespace App\Http\Controllers;

use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        // Featured: random selection up to 10 books
        $featuredBooks = Book::inRandomOrder()->take(10)->get();

        // New: latest 6 books added
        $newBooks = Book::latest()->take(6)->get();

        $totalBooks = Book::count();

        return view('welcome', compact('featuredBooks', 'newBooks', 'totalBooks'));
    }
}
