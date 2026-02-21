<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Book;
use App\Models\BorrowBook;
use App\Models\ReturnBook;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticController extends Controller
{
    public function index()
    {
        $now = now();

        // ── Summary Cards ────────────────────────────────────────────────────────
        $totalBooks       = Book::sum('quantity');
        $totalMembers     = User::where('role', 'user')->count();
        $borrowsThisMonth = BorrowBook::whereMonth('borrow_date', $now->month)
            ->whereYear('borrow_date', $now->year)->count();
        $returnsThisMonth = ReturnBook::whereMonth('return_date', $now->month)
            ->whereYear('return_date', $now->year)->count();

        // ── Donut: Books by Language ─────────────────────────────────────────────
        $bookLanguages = Book::selectRaw('language, COUNT(*) as count')
            ->whereNotNull('language')
            ->groupBy('language')
            ->get()
            ->map(fn($r) => ['name' => ucfirst($r->language), 'y' => (int) $r->count]);
        $totalBooksCount = Book::count();

        // ── Purpose Cards: Attendance this month ─────────────────────────────────
        $purposeThisMonth = Attendance::selectRaw('purpose, COUNT(*) as count')
            ->whereMonth('attendance_date', $now->month)
            ->whereYear('attendance_date', $now->year)
            ->groupBy('purpose')
            ->pluck('count', 'purpose');

        // ── Column Chart: Books by Category & Language ───────────────────────────
        $categories = Book::whereNotNull('category')
            ->distinct()->orderBy('category')->pluck('category')->toArray();

        $langGroups = Book::whereNotNull('category')
            ->selectRaw('category, language, COUNT(*) as count')
            ->groupBy('category', 'language')
            ->get()
            ->groupBy('language');

        $chartSeries = [];
        foreach ($langGroups as $lang => $rows) {
            $byCategory = $rows->pluck('count', 'category');
            $chartSeries[] = [
                'name' => ucfirst($lang),
                'data' => array_map(fn($cat) => (int) ($byCategory[$cat] ?? 0), $categories),
            ];
        }

        // ── Top Borrowed Books Table ──────────────────────────────────────────────
        $topBooks = BorrowBook::select('book_id', DB::raw('COUNT(*) as borrow_count'))
            ->with('book')
            ->groupBy('book_id')
            ->orderByDesc('borrow_count')
            ->limit(10)
            ->get();

        // ── Pie: Student Gender Breakdown ────────────────────────────────────────
        $genderData = Student::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get()
            ->map(fn($g) => ['name' => ucfirst($g->gender), 'y' => (int) $g->count]);

        // ── Spline: Attendance this week (Mon–Sun) ───────────────────────────────
        $weekStart    = $now->copy()->startOfWeek(Carbon::MONDAY);
        $weekLabels   = [];
        $studentWeek  = [];
        $lecturerWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $date           = $weekStart->copy()->addDays($i);
            $weekLabels[]   = $date->format('D');
            $studentWeek[]  = Attendance::whereDate('attendance_date', $date->toDateString())
                ->whereNotNull('student_id')->count();
            $lecturerWeek[] = Attendance::whereDate('attendance_date', $date->toDateString())
                ->whereNotNull('lecturer_id')->count();
        }

        return view('layout.admin.content.analytic.index', compact(
            'totalBooks', 'totalMembers', 'borrowsThisMonth', 'returnsThisMonth',
            'bookLanguages', 'totalBooksCount',
            'purposeThisMonth',
            'categories', 'chartSeries',
            'topBooks',
            'genderData',
            'weekLabels', 'studentWeek', 'lecturerWeek'
        ));
    }
}
