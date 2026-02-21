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
            <h2 class="activity-title">Edit Member

                <a href="{{ route('member.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            {{-- Read-only info --}}
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label text-muted">Code Member</label>
                    <input type="text" class="form-control bg-light"
                           value="{{ $member->code_member }}" readonly>
                </div>
            </div>

            <form action="{{ route('member.update', $member->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $member->name_formatted) }}">
                    @error('name')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $member->email) }}">
                    @error('email')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Min 8 characters...">
                    @error('password')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Confirmation --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Repeat new password...">
                </div>

                {{-- Link Profile --}}
                <div class="col-md-12">
                    <label class="form-label">Link Profile</label>
                    <div class="d-flex gap-3 mb-2">
                        @php
                            $currentType = old('profile_type',
                                $member->student_id  ? 'student'  :
                                ($member->lecturer_id ? 'lecturer' : 'none')
                            );
                        @endphp
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="profile_type"
                                   id="typeNone" value="none"
                                   {{ $currentType === 'none' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeNone">None</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="profile_type"
                                   id="typeStudent" value="student"
                                   {{ $currentType === 'student' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeStudent">Student</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="profile_type"
                                   id="typeLecturer" value="lecturer"
                                   {{ $currentType === 'lecturer' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeLecturer">Lecturer</label>
                        </div>
                    </div>
                </div>

                {{-- Student Select --}}
                <div class="mb-3 col-md-12" id="studentSection" style="display:none;">
                    <label class="form-label">Select Student</label>
                    <select name="student_id"
                            class="form-select @error('student_id') is-invalid @enderror">
                        <option value="">-- Select Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id', $member->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->studentcode_formatted }} — {{ $student->fullname_formatted }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Lecturer Select --}}
                <div class="mb-3 col-md-12" id="lecturerSection" style="display:none;">
                    <label class="form-label">Select Lecturer</label>
                    <select name="lecturer_id"
                            class="form-select @error('lecturer_id') is-invalid @enderror">
                        <option value="">-- Select Lecturer --</option>
                        @foreach ($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}"
                                {{ old('lecturer_id', $member->lecturer_id) == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->lecturercode_formatted }} — {{ $lecturer->fullname_formatted }}
                            </option>
                        @endforeach
                    </select>
                    @error('lecturer_id')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
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

    <script>
        function toggleProfile() {
            const type = $('input[name="profile_type"]:checked').val();
            $('#studentSection').toggle(type === 'student');
            $('#lecturerSection').toggle(type === 'lecturer');

            if (type !== 'student')  $('select[name="student_id"]').val('');
            if (type !== 'lecturer') $('select[name="lecturer_id"]').val('');
        }

        $('input[name="profile_type"]').on('change', toggleProfile);

        $(document).ready(function () {
            toggleProfile();
        });
    </script>

@endsection
