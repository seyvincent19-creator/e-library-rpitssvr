<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Degree;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('degree')->orderBy('id', 'desc')->get();
        $studentsToday = Student::whereDate('created_at', now()->toDateString())->count();
        $totalStudents = $students->count();

        return view('layout.admin.content.student.index', compact(
            'students',
            'studentsToday',
            'totalStudents'
        ));
    }

    public function create()
    {
        return view('layout.admin.content.student.create');
    }

    public function store(StudentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students', 'public');
        }

        Student::create($data);

        return redirect()->route('student.create')->with('success', 'Student created successfully.');
    }

    public function show($id)
    {
        $student = Student::with('degree')->findOrFail($id);

        return response()->json([
            'studentcode_formatted' => $student->studentcode_formatted,
            'fullname_formatted'    => $student->fullname_formatted,
            'gender'                => ucfirst($student->gender),
            'date_of_birth'         => $student->date_of_birth,
            'phone_formatted'       => $student->phone_formatted,
            'enroll_year'           => $student->enroll_year,
            'address_formatted'     => $student->address_formatted,
            'status_formatted'      => $student->status_formatted,
            'image_url'             => $student->image_url,
            'degree_level'          => $student->degree ? ucfirst($student->degree->degree_level) : '-',
            'majors_formatted'      => $student->degree ? $student->degree->majors_formatted : '-',
            'study_time'            => $student->degree ? Str::title($student->degree->study_time) : '-',
        ]);
    }

    public function edit($id)
    {
        $student = Student::with('degree')->findOrFail($id);
        return view('layout.admin.content.student.edit', compact('student'));
    }

    public function update(StudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $data['image'] = $request->file('image')->store('students', 'public');
        } else {
            unset($data['image']);
        }

        $student->fill($data)->save();

        return redirect()->route('student.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully.');
    }

    // ─── Public Registration & AJAX ─────────────────────────────────────────────

    public function registration_student()
    {
        $degrees = Degree::select('degree_level')
            ->distinct()
            ->orderByRaw("degree_level COLLATE utf8mb4_unicode_ci ASC")
            ->get();

        return view('layout.user.registration.student.index', compact('degrees'));
    }

    public function store_registration(Request $request)
    {
        $validated = $request->validate([
            'student_code'  => ['required', 'string', 'max:50', Rule::unique('students', 'student_code')],
            'full_name'     => 'required|string|max:100',
            'gender'        => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'phone'         => ['required', 'string', 'max:50', Rule::unique('students', 'phone')],
            'enroll_year'   => 'required|digits:4|integer|min:2000|max:' . now()->year,
            'degree_id'     => 'required|exists:degrees,id',
            'address'       => 'required|string|max:255',
            'image'         => 'nullable|image|max:2048',
        ]);

        $validated['status'] = 'active';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('students', 'public');
        }

        $student = Student::create($validated);

        session([
            'registration_type' => 'student',
            'student_id'        => $student->id,
        ]);

        return redirect()->route('register');
    }

    public function getMajor($degree)
    {
        return Degree::where('degree_level', $degree)
            ->select('majors')
            ->distinct()
            ->orderByRaw("majors COLLATE utf8mb4_unicode_ci ASC")
            ->get();
    }

    public function getStudyTime($degree, $majors)
    {
        return Degree::where('degree_level', $degree)
            ->where('majors', $majors)
            ->select('study_time')
            ->distinct()
            ->orderByRaw("study_time COLLATE utf8mb4_unicode_ci ASC")
            ->get();
    }

    public function getDegreeId($degree, $majors, $study_time)
    {
        return Degree::where('degree_level', $degree)
            ->where('majors', $majors)
            ->where('study_time', $study_time)
            ->select('id')
            ->firstOrFail();
    }
}
