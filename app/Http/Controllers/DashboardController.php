<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowBook;
use App\Models\ReturnBook;
use App\Models\User;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Summary Cards ─────────────────────────────────────────────────────────
        $totalBooks    = Book::sum('quantity');
        $totalMembers  = User::where('role', 'user')->count();
        $activeMembers = User::where('role', 'user')
            ->whereHas('borrowBooks', fn($q) => $q->whereDoesntHave('returnBook'))
            ->count();
        $checkedOut   = BorrowBook::whereDoesntHave('returnBook')->count();
        $overdueCount = BorrowBook::where('due_date', '<', now()->toDateString())
            ->whereDoesntHave('returnBook')
            ->count();

        // Progress bar percentages (capped at 100)
        $booksProgress  = $totalBooks > 0
            ? min(100, round($checkedOut / $totalBooks * 100)) . '%'
            : '0%';
        $memberProgress = $totalMembers > 0
            ? min(100, round($activeMembers / $totalMembers * 100)) . '%'
            : '0%';
        $overdueProgress = $checkedOut > 0
            ? min(100, round($overdueCount / $checkedOut * 100)) . '%'
            : '0%';

        // ── Activity Feed (borrows + returns + new members, sorted newest first) ──
        $activities = collect();

        BorrowBook::with(['user', 'book'])->latest()->limit(4)->get()
            ->each(function ($b) use (&$activities) {
                $activities->push([
                    'icon'  => 'book_3',
                    'class' => 'icon-book',
                    'title' => 'Book Borrowed',
                    'desc'  => '"' . Str::limit($b->book?->title, 35, '…') . '"',
                    'sub'   => 'By ' . ($b->user?->name_formatted ?? '-') . ' — Due: ' . $b->due_date,
                    'time'  => $b->created_at,
                ]);
            });

        ReturnBook::with(['borrowBook.user', 'borrowBook.book'])->latest()->limit(4)->get()
            ->each(function ($r) use (&$activities) {
                $fine = $r->fine > 0 ? ' — Fine: $' . number_format($r->fine, 2) : '';
                $activities->push([
                    'icon'  => 'rotate_auto',
                    'class' => 'icon-out',
                    'title' => 'Book Returned',
                    'desc'  => '"' . Str::limit($r->borrowBook?->book?->title, 35, '…') . '"',
                    'sub'   => 'By ' . ($r->borrowBook?->user?->name_formatted ?? '-') . $fine,
                    'time'  => $r->created_at,
                ]);
            });

        User::where('role', 'user')->latest()->limit(3)->get()
            ->each(function ($u) use (&$activities) {
                $activities->push([
                    'icon'  => 'person_add',
                    'class' => 'icon-member',
                    'title' => 'New Member Registered',
                    'desc'  => $u->name_formatted . ' (' . $u->code_member . ')',
                    'sub'   => 'Joined the library',
                    'time'  => $u->created_at,
                ]);
            });

        $activities = $activities->sortByDesc('time')->take(8)->values();

        // ── Bar Chart: User registrations last 7 days ─────────────────────────────
        $weekData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date       = now()->subDays($i);
            $weekData[] = [
                'name' => $date->format('D, d M'),
                'y'    => (int) User::whereDate('created_at', $date->toDateString())->count(),
            ];
        }

        return view('layout.admin.content.dashboard.index', compact(
            'totalBooks', 'totalMembers', 'activeMembers',
            'checkedOut', 'overdueCount',
            'booksProgress', 'memberProgress', 'overdueProgress',
            'activities',
            'weekData'
        ));
    }
}
