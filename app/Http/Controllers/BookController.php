<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->get();
        $booksToday = Book::whereDate('created_at', now()->toDateString())->count();
        $totalBooks = $books->count();

        return view('layout.admin.content.manage_book.index', compact(
            'books',
            'booksToday',
            'totalBooks'
        ));
    }

    public function create()
    {
        return view('layout.admin.content.manage_book.create');
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('books', 'public');

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('books/pdf', 'public');
        }

        Book::create($data);

        return redirect()->route('manage_book.create')->with('success', 'Book created successfully.');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return response()->json([
            'title'          => $book->title,
            'subject'        => $book->subject,
            'category'       => \Illuminate\Support\Str::title($book->category),
            'author'         => $book->author,
            'pages'          => $book->pages,
            'language'       => ucfirst($book->language),
            'published_date' => $book->published_date,
            'quantity'       => $book->quantity,
            'location'       => strtoupper($book->location),
            'image_url'      => $book->image_url,
            'file_url'       => $book->file_url,
        ]);
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('layout.admin.content.manage_book.edit', compact('book'));
    }

    public function update(BookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($book->image);
            $data['image'] = $request->file('image')->store('books', 'public');
        } else {
            unset($data['image']);
        }

        if ($request->hasFile('file')) {
            if ($book->file) {
                Storage::disk('public')->delete($book->file);
            }
            $data['file'] = $request->file('file')->store('books/pdf', 'public');
        } else {
            unset($data['file']);
        }

        $book->fill($data)->save();

        return redirect()->route('manage_book.index')->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        if ($book->file) {
            Storage::disk('public')->delete($book->file);
        }
        $book->delete();

        return redirect()->back()->with('success', 'Book deleted successfully.');
    }

    public function download($id)
    {
        $book = Book::findOrFail($id);

        if (!$book->file || !Storage::disk('public')->exists($book->file)) {
            return back()->with('error', 'No PDF file available for this book.');
        }

        return Storage::disk('public')->download($book->file, $book->title . '.pdf');
    }
}
