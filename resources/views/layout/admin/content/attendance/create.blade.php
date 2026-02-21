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
            <h2 class="activity-title">Record Attendance

                <a href="{{ route('attendance.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('attendance.store') }}" method="POST" class="row g-3">
                @csrf

                {{-- Auto-filled info (read-only display) --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label text-muted">Entry Time <small>(auto)</small></label>
                    <input type="text" id="displayEntryTime" class="form-control bg-light" readonly>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label text-muted">Visit Date <small>(auto)</small></label>
                    <input type="text" id="displayDate" class="form-control bg-light" readonly>
                </div>

                {{-- Exit Time --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Exit Time <small class="text-muted">(optional)</small></label>
                    <input type="time" name="exit_time" id="exitTime"
                           class="form-control @error('exit_time') is-invalid @enderror"
                           value="{{ old('exit_time') }}">
                    @error('exit_time')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Visitor Type --}}
                <div class="col-md-12">
                    <label class="form-label">Visitor Type</label>
                    <div class="d-flex gap-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visitor_type"
                                   id="typeStudent" value="student"
                                   {{ old('visitor_type', 'student') === 'student' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeStudent">Student</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visitor_type"
                                   id="typeLecturer" value="lecturer"
                                   {{ old('visitor_type') === 'lecturer' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeLecturer">Lecturer</label>
                        </div>
                    </div>
                    @error('visitor_type')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Student Select --}}
                <div class="mb-3 col-md-12" id="studentSection">
                    <label class="form-label">Select Student</label>
                    <select name="student_id"
                            class="form-select @error('student_id') is-invalid @enderror">
                        <option value="">-- Select Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id') == $student->id ? 'selected' : '' }}>
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
                                {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->lecturercode_formatted }} — {{ $lecturer->fullname_formatted }}
                            </option>
                        @endforeach
                    </select>
                    @error('lecturer_id')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Purpose --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Purpose</label>
                    <select name="purpose"
                            class="form-select @error('purpose') is-invalid @enderror">
                        <option value="">-- Select Purpose --</option>
                        <option value="reading"    {{ old('purpose') === 'reading'    ? 'selected' : '' }}>Reading</option>
                        <option value="use_pc"     {{ old('purpose') === 'use_pc'     ? 'selected' : '' }}>Use PC</option>
                        <option value="assignment" {{ old('purpose') === 'assignment' ? 'selected' : '' }}>Assignment</option>
                        <option value="other"      {{ old('purpose') === 'other'      ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('purpose')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-end col-md-12">
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-arrow-up-circle pe-1"></i>
                        Record
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
        // Auto-fill entry time and date for display
        document.addEventListener('DOMContentLoaded', function () {
            const now = new Date();
            const hh  = String(now.getHours()).padStart(2, '0');
            const mm  = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('displayEntryTime').value = `${hh}:${mm}`;

            const yyyy = now.getFullYear();
            const mo   = String(now.getMonth() + 1).padStart(2, '0');
            const dd   = String(now.getDate()).padStart(2, '0');
            document.getElementById('displayDate').value = `${yyyy}-${mo}-${dd}`;
        });

        // Toggle student / lecturer dropdown
        function toggleVisitor() {
            const type = $('input[name="visitor_type"]:checked').val();
            $('#studentSection').toggle(type === 'student');
            $('#lecturerSection').toggle(type === 'lecturer');
            if (type !== 'student')  $('select[name="student_id"]').val('');
            if (type !== 'lecturer') $('select[name="lecturer_id"]').val('');
        }

        $('input[name="visitor_type"]').on('change', toggleVisitor);
        $(document).ready(toggleVisitor);
    </script>

@endsection
