<?php

namespace App\Http\Controllers;

use App\Http\Requests\DegreeRequest;
use App\Models\Degree;

class DegreeController extends Controller
{
    public function index()
    {
        $degrees = Degree::orderBy('id', 'desc')->get();
        $degreesToday = Degree::whereDate('created_at', now()->toDateString())->count();
        $totalDegrees = $degrees->count();

        return view('layout.admin.content.degree.index', compact(
            'degrees',
            'degreesToday',
            'totalDegrees'
        ));
    }

    public function create()
    {
        return view('layout.admin.content.degree.create');
    }

    public function store(DegreeRequest $request)
    {
        if ($this->duplicateExists($request->validated())) {
            return back()->withInput()->withErrors([
                'duplicate' => 'This record already exists in the system.',
            ]);
        }

        Degree::create($request->validated());

        return redirect()->route('degree.create')->with('success', 'Degree created successfully.');
    }

    public function show($id)
    {
        return response()->json(Degree::findOrFail($id));
    }

    public function edit($id)
    {
        $degree = Degree::findOrFail($id);
        return view('layout.admin.content.degree.edit', compact('degree'));
    }

    public function update(DegreeRequest $request, $id)
    {
        $degree = Degree::findOrFail($id);

        if ($this->duplicateExists($request->validated(), $id)) {
            return back()->withInput()->withErrors([
                'duplicate' => 'This record already exists in the system.',
            ]);
        }

        $degree->fill($request->validated())->save();

        return redirect()->route('degree.index')->with('success', 'Degree updated successfully.');
    }

    public function destroy($id)
    {
        Degree::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Degree deleted successfully.');
    }

    private function duplicateExists(array $data, $excludeId = null): bool
    {
        $query = Degree::where('majors', $data['majors'])
            ->where('duration_years', $data['duration_years'])
            ->where('study_time', $data['study_time'])
            ->where('degree_level', $data['degree_level'])
            ->where('generation', $data['generation']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
