<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequest;
use App\Models\Book;
use App\Models\BorrowBook;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = BorrowBook::with(['user', 'book'])->orderBy('id', 'desc')->get();
        $borrowsToday = BorrowBook::whereDate('created_at', now()->toDateString())->count();
        $overdueCount = BorrowBook::where('due_date', '<', now()->toDateString())
            ->whereDoesntHave('returnBook')
            ->count();
        $totalBorrows = $borrows->count();

        return view('layout.admin.content.borrow_book.index', compact(
            'borrows',
            'borrowsToday',
            'overdueCount',
            'totalBorrows'
        ));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $books = Book::where('quantity', '>', 0)->orderBy('title')->get();

        return view('layout.admin.content.borrow_book.create', compact('users', 'books'));
    }

    public function store(BorrowRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->quantity < 1) {
            return back()->withInput()->withErrors([
                'book_id' => 'This book is currently out of stock.',
            ]);
        }

        BorrowBook::create($request->validated());
        $book->decrement('quantity');

        return redirect()->route('borrow_book.create')->with('success', 'Book issued successfully.');
    }

    public function show($id)
    {
        $borrow = BorrowBook::with(['user', 'book'])->findOrFail($id);

        $isReturned = $borrow->returnBook !== null;

        return response()->json([
            'code_member' => $borrow->user?->code_member,
            'user_name'   => $borrow->user?->name_formatted,
            'book_title'  => $borrow->book?->title,
            'subject'     => $borrow->book?->subject,
            'author'      => $borrow->book?->author,
            'borrow_date' => $borrow->borrow_date,
            'due_date'    => $borrow->due_date,
            'is_returned' => $isReturned,
            'is_overdue'  => !$isReturned && $borrow->due_date < now()->toDateString(),
        ]);
    }

    public function edit($id)
    {
        $borrow = BorrowBook::with(['user', 'book'])->findOrFail($id);
        return view('layout.admin.content.borrow_book.edit', compact('borrow'));
    }

    public function update(Request $request, $id)
    {
        $borrow = BorrowBook::findOrFail($id);

        $request->validate([
            'borrow_date' => 'required|date',
            'due_date'    => 'required|date|after:borrow_date',
        ], [
            'due_date.after' => 'Due date must be after the borrow date.',
        ]);

        $borrow->borrow_date = $request->borrow_date;
        $borrow->due_date    = $request->due_date;
        $borrow->save();

        return redirect()->route('borrow_book.index')->with('success', 'Borrow record updated successfully.');
    }

    public function destroy($id)
    {
        $borrow = BorrowBook::with('book')->findOrFail($id);

        // Restore quantity only if the book has not been returned yet
        if (!$borrow->returnBook) {
            $borrow->book?->increment('quantity');
        }

        $borrow->delete();

        return redirect()->back()->with('success', 'Borrow record deleted successfully.');
    }
}
