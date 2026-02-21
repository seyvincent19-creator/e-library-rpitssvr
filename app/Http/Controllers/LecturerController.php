<?php

namespace App\Http\Controllers;

use App\Http\Requests\LecturerRequest;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::orderBy('id', 'desc')->get();
        $lecturersToday = Lecturer::whereDate('created_at', now()->toDateString())->count();
        $totalLecturers = $lecturers->count();

        return view('layout.admin.content.lecturer.index', compact(
            'lecturers',
            'lecturersToday',
            'totalLecturers'
        ));
    }

    public function create()
    {
        return view('layout.admin.content.lecturer.create');
    }

    public function store(LecturerRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('lecturers', 'public');
        }

        Lecturer::create($data);

        return redirect()->route('lecturer.create')->with('success', 'Lecturer created successfully.');
    }

    public function show($id)
    {
        $lecturer = Lecturer::findOrFail($id);

        return response()->json([
            'lecturercode_formatted' => $lecturer->lecturercode_formatted,
            'fullname_formatted'     => $lecturer->fullname_formatted,
            'gender'                 => ucfirst($lecturer->gender),
            'date_of_birth'          => $lecturer->date_of_birth,
            'phone_formatted'        => $lecturer->phone_formatted,
            'enroll_year'            => $lecturer->enroll_year,
            'department'             => $lecturer->department,
            'address_formatted'      => $lecturer->address_formatted,
            'status_formatted'       => $lecturer->status_formatted,
            'image_url'              => $lecturer->image_url,
        ]);
    }

    public function edit($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        return view('layout.admin.content.lecturer.edit', compact('lecturer'));
    }

    public function update(LecturerRequest $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($lecturer->image) {
                Storage::disk('public')->delete($lecturer->image);
            }
            $data['image'] = $request->file('image')->store('lecturers', 'public');
        } else {
            unset($data['image']);
        }

        $lecturer->fill($data)->save();

        return redirect()->route('lecturer.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);

        if ($lecturer->image) {
            Storage::disk('public')->delete($lecturer->image);
        }

        $lecturer->delete();

        return redirect()->back()->with('success', 'Lecturer deleted successfully.');
    }

    public function registration_lecturer()
    {
        return view('layout.user.registration.lecturer.index');
    }

    public function store_registration(Request $request)
    {
        $validated = $request->validate([
            'lecturer_code' => ['required', 'string', 'max:50', Rule::unique('lecturers', 'lecturer_code')],
            'full_name'     => 'required|string|max:100',
            'gender'        => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'phone'         => ['required', 'string', 'max:50', Rule::unique('lecturers', 'phone')],
            'enroll_year'   => 'required|digits:4|integer|min:1990|max:' . now()->year,
            'department'    => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'image'         => 'nullable|image|max:2048',
        ]);

        $validated['status'] = 'active';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('lecturers', 'public');
        }

        $lecturer = Lecturer::create($validated);

        session([
            'registration_type' => 'lecturer',
            'lecturer_id'       => $lecturer->id,
        ]);

        return redirect()->route('register');
    }
}
