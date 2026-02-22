<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserBookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::orderBy('id', 'desc');

        // Pre-fill search from home page search bar
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        $books = $query->paginate(12)->withQueryString();

        return view('layout.user.books.index', compact('books'));
    }

    public function download($id)
    {
        $book = Book::findOrFail($id);

        if (!$book->file || !Storage::disk(config('filesystems.default'))->exists($book->file)) {
            return back()->with('error', 'No PDF file available for this book.');
        }

        return Storage::disk(config('filesystems.default'))->download($book->file, $book->title . '.pdf');
    }
}
