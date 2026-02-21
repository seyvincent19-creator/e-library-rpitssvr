<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['student', 'lecturer'])
            ->orderBy('id', 'desc')
            ->get();

        $visitorsToday  = Attendance::whereDate('attendance_date', today())->count();
        $insideNow      = Attendance::whereDate('attendance_date', today())
            ->whereNull('exit_time')->count();
        $totalThisMonth = Attendance::whereMonth('attendance_date', now()->month)
            ->whereYear('attendance_date', now()->year)->count();

        return view('layout.admin.content.attendance.index', compact(
            'attendances', 'visitorsToday', 'insideNow', 'totalThisMonth'
        ));
    }

    public function create()
    {
        $students  = Student::orderBy('full_name')->get();
        $lecturers = Lecturer::orderBy('full_name')->get();

        return view('layout.admin.content.attendance.create', compact('students', 'lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_type' => 'required|in:student,lecturer',
            'student_id'   => 'required_if:visitor_type,student|nullable|exists:students,id',
            'lecturer_id'  => 'required_if:visitor_type,lecturer|nullable|exists:lecturers,id',
            'exit_time'    => 'nullable|date_format:H:i',
            'purpose'      => 'required|in:reading,use_pc,assignment,other',
        ]);

        Attendance::create([
            'student_id'      => $request->visitor_type === 'student'  ? $request->student_id  : null,
            'lecturer_id'     => $request->visitor_type === 'lecturer' ? $request->lecturer_id : null,
            'entry_time'      => now()->format('H:i:s'),
            'exit_time'       => $request->exit_time ? $request->exit_time . ':00' : null,
            'purpose'         => $request->purpose,
            'attendance_date' => now()->toDateString(),
        ]);

        return redirect()->route('attendance.create')->with('success', 'Attendance recorded successfully.');
    }

    public function show($id)
    {
        $att = Attendance::with(['student.degree', 'lecturer'])->findOrFail($id);

        $visitorType = $att->student ? 'Student' : ($att->lecturer ? 'Lecturer' : '-');
        $visitorCode = $att->student?->studentcode_formatted
                    ?? $att->lecturer?->lecturercode_formatted
                    ?? '-';
        $visitorName = $att->student?->fullname_formatted
                    ?? $att->lecturer?->fullname_formatted
                    ?? '-';
        $phone       = $att->student?->phone_formatted
                    ?? $att->lecturer?->phone_formatted
                    ?? '-';

        return response()->json([
            'visitor_type' => $visitorType,
            'visitor_code' => $visitorCode,
            'visitor_name' => $visitorName,
            'phone'        => $phone,
            'entry_time'   => substr($att->entry_time, 0, 5),
            'exit_time'    => $att->exit_time ? substr($att->exit_time, 0, 5) : '-',
            'purpose'      => ucwords(str_replace('_', ' ', $att->purpose)),
            'date'         => $att->attendance_date,
        ]);
    }

    public function edit($id)
    {
        $attendance = Attendance::with(['student', 'lecturer'])->findOrFail($id);
        return view('layout.admin.content.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'exit_time' => 'nullable|date_format:H:i',
            'purpose'   => 'required|in:reading,use_pc,assignment,other',
        ]);

        $attendance->exit_time = $request->exit_time ? $request->exit_time . ':00' : null;
        $attendance->purpose   = $request->purpose;
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Attendance record deleted successfully.');
    }
}
