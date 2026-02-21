<?php

namespace App\Http\Controllers;

use App\Models\BorrowBook;
use App\Models\ReturnBook;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = ReturnBook::with(['borrowBook.user', 'borrowBook.book'])
            ->orderBy('id', 'desc')
            ->get();

        $returnsToday = ReturnBook::whereDate('created_at', now()->toDateString())->count();
        $overdueCount = BorrowBook::where('due_date', '<', now()->toDateString())
            ->whereDoesntHave('returnBook')
            ->count();
        $totalReturns = $returns->count();

        return view('layout.admin.content.return_book.index', compact(
            'returns',
            'returnsToday',
            'overdueCount',
            'totalReturns'
        ));
    }

    public function create()
    {
        // Only show borrow records that have not been returned yet
        $borrows = BorrowBook::with(['user', 'book'])
            ->whereDoesntHave('returnBook')
            ->orderBy('id', 'desc')
            ->get();

        return view('layout.admin.content.return_book.create', compact('borrows'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrow_book_id' => 'required|exists:borrow_books,id',
            'return_date'    => 'required|date',
            'status'         => 'required|in:borrowed,returned,overdue,other',
            'fine'           => 'required|numeric|min:0',
        ]);

        // Prevent duplicate return records
        if (ReturnBook::where('borrow_book_id', $request->borrow_book_id)->exists()) {
            return back()->withInput()->withErrors([
                'borrow_book_id' => 'This borrow record has already been returned.',
            ]);
        }

        ReturnBook::create($request->only(['borrow_book_id', 'return_date', 'status', 'fine']));

        // Restore book quantity — the book is back on the shelf
        $borrow = BorrowBook::with('book')->find($request->borrow_book_id);
        $borrow->book?->increment('quantity');

        return redirect()->route('return_book.create')->with('success', 'Book returned successfully.');
    }

    public function show($id)
    {
        $return = ReturnBook::with(['borrowBook.user', 'borrowBook.book'])->findOrFail($id);

        $statusBadge = match($return->status) {
            'returned' => 'success',
            'overdue'  => 'danger',
            'borrowed' => 'primary',
            default    => 'secondary',
        };

        return response()->json([
            'code_member'  => $return->borrowBook?->user?->code_member,
            'user_name'    => $return->borrowBook?->user?->name_formatted,
            'book_title'   => $return->borrowBook?->book?->title,
            'borrow_date'  => $return->borrowBook?->borrow_date,
            'due_date'     => $return->borrowBook?->due_date,
            'return_date'  => $return->return_date,
            'status_label' => ucfirst($return->status),
            'status_badge' => $statusBadge,
            'fine'         => number_format($return->fine, 2),
        ]);
    }

    public function edit($id)
    {
        $return = ReturnBook::with(['borrowBook.user', 'borrowBook.book'])->findOrFail($id);
        return view('layout.admin.content.return_book.edit', compact('return'));
    }

    public function update(Request $request, $id)
    {
        $return = ReturnBook::findOrFail($id);

        $request->validate([
            'return_date' => 'required|date',
            'status'      => 'required|in:borrowed,returned,overdue,other',
            'fine'        => 'required|numeric|min:0',
        ]);

        $return->return_date = $request->return_date;
        $return->status      = $request->status;
        $return->fine        = $request->fine;
        $return->save();

        return redirect()->route('return_book.index')->with('success', 'Return record updated successfully.');
    }

    public function destroy($id)
    {
        $return = ReturnBook::with('borrowBook.book')->findOrFail($id);

        // Reverse: book goes back to "borrowed" state, decrement quantity
        $return->borrowBook?->book?->decrement('quantity');

        $return->delete();

        return redirect()->back()->with('success', 'Return record deleted successfully.');
    }
}
