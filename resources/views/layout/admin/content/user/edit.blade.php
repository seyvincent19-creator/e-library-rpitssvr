@extends('layout.admin.dashboard')

@section('other_link_head')

    <!-- Bootstrap5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style_alert/style.css') }}">

@endsection

@section('link_custom')
    <link rel="stylesheet" href="{{ asset('assets/css/style_dashboard/style_all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style_book/style.css') }}">
@endsection

@section('content')
    <main>

        {{-- Success --}}
        @if (session('success'))
            <div class="container">
                <script>
                    Swal.fire({
                        position: "top-end",
                        title: "✔ {{ session('success') }}",
                        showConfirmButton: false,
                        timer: 3000,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        },
                        background: '#cbe9ba',
                        color: 'seagreen',
                        width: 'auto',
                    });
                </script>
            </div>
        @endif

        {{-- Error --}}
        @if ($errors->any())
            <div class="container">
                <script>
                    Swal.fire({
                        position: "top-end",
                        title: "❌ Something Wrong! Please Check Again.",
                        showConfirmButton: false,
                        timer: 3000,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        },
                        background: '#f8d7da',
                        color: 'rgb(201 60 60)',
                        width: 'auto',
                    });
                </script>
            </div>
        @endif

        <div class="recent-activity">
            <h2 class="activity-title">Edit User

                <a href="{{ route('user.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('user.update', $user->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- User Name --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">User Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="User Name..."
                           value="{{ old('name', $user->name_formatted) }}">
                    @error('name')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email..."
                           value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Role</label>
                    <select name="role"
                            class="form-select @error('role') is-invalid @enderror">
                        <option value="admin"     {{ old('role', $user->role) === 'admin'     ? 'selected' : '' }}>Admin</option>
                        <option value="librarian" {{ old('role', $user->role) === 'librarian' ? 'selected' : '' }}>Librarian</option>
                        <option value="user"      {{ old('role', $user->role) === 'user'      ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- New Password (optional) --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="New Password...">
                    @error('password')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Confirm Password...">
                </div>

                <div class="d-flex justify-content-end col-md-12">
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-arrow-up-circle pe-1"></i>
                        Update
                    </button>
                </div>

            </form>

        </div>

    </main>
@endsection

@section('other_script')
    <!-- Bootstrap5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endsection
