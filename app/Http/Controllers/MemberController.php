<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::with(['student', 'lecturer'])
            ->withCount([
                'borrowBooks as active_borrows' => fn($q) => $q->whereDoesntHave('returnBook'),
                'borrowBooks as total_borrows',
            ])
            ->where('role', 'user')
            ->orderBy('id', 'desc')
            ->get();

        $membersToday  = User::where('role', 'user')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $activeMembers = User::where('role', 'user')
            ->whereHas('borrowBooks', fn($q) => $q->whereDoesntHave('returnBook'))
            ->count();

        $totalMembers = $members->count();

        return view('layout.admin.content.member.index', compact(
            'members', 'membersToday', 'activeMembers', 'totalMembers'
        ));
    }

    public function show($id)
    {
        $member = User::with(['student.degree', 'lecturer'])
            ->withCount([
                'borrowBooks as active_borrows' => fn($q) => $q->whereDoesntHave('returnBook'),
                'borrowBooks as total_borrows',
            ])
            ->where('role', 'user')
            ->findOrFail($id);

        $profileType = $member->student ? 'Student' : ($member->lecturer ? 'Lecturer' : '-');
        $profileCode = $member->student?->studentcode_formatted
                    ?? $member->lecturer?->lecturercode_formatted
                    ?? '-';
        $profileName = $member->student?->fullname_formatted
                    ?? $member->lecturer?->fullname_formatted
                    ?? '-';
        $phone       = $member->student?->phone_formatted
                    ?? $member->lecturer?->phone_formatted
                    ?? '-';

        return response()->json([
            'code_member'    => $member->code_member,
            'name'           => $member->name_formatted,
            'email'          => $member->email,
            'profile_type'   => $profileType,
            'profile_code'   => $profileCode,
            'profile_name'   => $profileName,
            'phone'          => $phone,
            'active_borrows' => $member->active_borrows,
            'total_borrows'  => $member->total_borrows,
        ]);
    }

    public function create()
    {
        $students  = Student::whereDoesntHave('user')->orderBy('full_name')->get();
        $lecturers = Lecturer::whereDoesntHave('user')->orderBy('full_name')->get();

        return view('layout.admin.content.member.create', compact('students', 'lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|confirmed|min:8',
            'student_id'  => 'nullable|exists:students,id|unique:users,student_id',
            'lecturer_id' => 'nullable|exists:lecturers,id|unique:users,lecturer_id',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'user',
            'student_id'  => $request->student_id  ?: null,
            'lecturer_id' => $request->lecturer_id ?: null,
        ]);

        return redirect()->route('member.create')->with('success', 'Member created successfully.');
    }

    public function edit($id)
    {
        $member = User::where('role', 'user')->findOrFail($id);

        $students = Student::whereDoesntHave('user')
            ->orWhere('id', $member->student_id)
            ->orderBy('full_name')
            ->get();

        $lecturers = Lecturer::whereDoesntHave('user')
            ->orWhere('id', $member->lecturer_id)
            ->orderBy('full_name')
            ->get();

        return view('layout.admin.content.member.edit', compact('member', 'students', 'lecturers'));
    }

    public function update(Request $request, $id)
    {
        $member = User::where('role', 'user')->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password'    => 'nullable|confirmed|min:8',
            'student_id'  => ['nullable', 'exists:students,id', Rule::unique('users', 'student_id')->ignore($id)],
            'lecturer_id' => ['nullable', 'exists:lecturers,id', Rule::unique('users', 'lecturer_id')->ignore($id)],
        ]);

        $member->name        = $request->name;
        $member->email       = $request->email;
        $member->student_id  = $request->student_id  ?: null;
        $member->lecturer_id = $request->lecturer_id ?: null;

        if ($request->filled('password')) {
            $member->password = Hash::make($request->password);
        }

        $member->save();

        return redirect()->route('member.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id)
    {
        User::where('role', 'user')->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Member deleted successfully.');
    }
}
