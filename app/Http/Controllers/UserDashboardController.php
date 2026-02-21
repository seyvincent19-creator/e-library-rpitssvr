<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load([
            'student.degree',
            'lecturer',
            'borrowBooks.book',
            'borrowBooks.returnBook',
        ]);

        $borrows = $user->borrowBooks;

        // Active = no returnBook record OR status is 'borrowed' or 'overdue'
        $activeBorrows = $borrows->filter(
            fn($b) => !$b->returnBook || in_array($b->returnBook->status, ['borrowed', 'overdue'])
        );

        $returnedCount = $borrows->filter(
            fn($b) => $b->returnBook && $b->returnBook->status === 'returned'
        )->count();

        $overdueCount = $borrows->filter(
            fn($b) => $b->returnBook && $b->returnBook->status === 'overdue'
        )->count();

        $totalFine = $borrows->sum(
            fn($b) => $b->returnBook ? (float) $b->returnBook->fine : 0
        );

        $totalBooks = Book::count();
        $pdfBooks   = Book::whereNotNull('file')->count();

        // 4 newest books for the quick browse strip
        $newBooks = Book::latest()->take(4)->get();

        return view('layout.user.dashboard', compact(
            'user',
            'borrows',
            'activeBorrows',
            'returnedCount',
            'overdueCount',
            'totalFine',
            'totalBooks',
            'pdfBooks',
            'newBooks',
        ));
    }
}
