<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // ─── Public Auth ────────────────────────────────────────────────────────────

    public function register()
    {
        return view('layout.admin.content.auth.register');
    }

    public function registerSave(UserRequest $request)
    {
        $user = $this->createUser($request);

        if (session('student_id')) {
            $user->student_id = session('student_id');
            $user->save();
        } elseif (session('lecturer_id')) {
            $user->lecturer_id = session('lecturer_id');
            $user->save();
        }

        session()->forget(['registration_type', 'student_id', 'lecturer_id']);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function login()
    {
        return view('layout.admin.content.auth.login');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'admin', 'librarian' => redirect()->route('dashboard.admin'),
            default              => redirect()->route('user.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ─── Admin User Management ───────────────────────────────────────────────────

    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $usersToday = User::whereDate('created_at', now()->toDateString())->count();
        $totalUsers = $users->count();

        return view('layout.admin.content.user.index', compact('users', 'usersToday', 'totalUsers'));
    }

    public function create()
    {
        return view('layout.admin.content.user.create');
    }

    public function store(UserRequest $request)
    {
        $this->createUser($request);
        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'code_member' => $user->code_member,
            'name'        => $user->name_formatted,
            'email'       => $user->email,
            'role'        => ucfirst($user->role),
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('layout.admin.content.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|max:15',
            'email'    => ['required', 'email', 'max:25', Rule::unique('users')->ignore($id)],
            'role'     => 'nullable|in:admin,librarian,user',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role ?? $user->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────────

    private function createUser(UserRequest $request): User
    {
        return User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'user',
        ]);
    }
}
