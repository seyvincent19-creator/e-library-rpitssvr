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
            <h2 class="activity-title">Edit Attendance Record

                <a href="{{ route('attendance.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            @php
                $isStudent   = $attendance->student !== null;
                $visitorType = $isStudent ? 'Student' : 'Lecturer';
                $visitorCode = $attendance->student?->studentcode_formatted
                            ?? $attendance->lecturer?->lecturercode_formatted
                            ?? '-';
                $visitorName = $attendance->student?->fullname_formatted
                            ?? $attendance->lecturer?->fullname_formatted
                            ?? '-';
            @endphp

            {{-- Read-only info --}}
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Visitor Type</label>
                    <input type="text" class="form-control bg-light" value="{{ $visitorType }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Code</label>
                    <input type="text" class="form-control bg-light" value="{{ $visitorCode }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Name</label>
                    <input type="text" class="form-control bg-light" value="{{ $visitorName }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Entry Time</label>
                    <input type="text" class="form-control bg-light"
                           value="{{ substr($attendance->entry_time, 0, 5) }}" readonly>
                </div>
            </div>

            <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- Exit Time --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Exit Time <small class="text-muted">(optional)</small></label>
                    <input type="time" name="exit_time"
                           class="form-control @error('exit_time') is-invalid @enderror"
                           value="{{ old('exit_time', $attendance->exit_time ? substr($attendance->exit_time, 0, 5) : '') }}">
                    @error('exit_time')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Visit Date (read-only) --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label text-muted">Visit Date</label>
                    <input type="text" class="form-control bg-light"
                           value="{{ $attendance->attendance_date }}" readonly>
                </div>

                {{-- Purpose --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Purpose</label>
                    <select name="purpose"
                            class="form-select @error('purpose') is-invalid @enderror">
                        <option value="reading"    {{ old('purpose', $attendance->purpose) === 'reading'    ? 'selected' : '' }}>Reading</option>
                        <option value="use_pc"     {{ old('purpose', $attendance->purpose) === 'use_pc'     ? 'selected' : '' }}>Use PC</option>
                        <option value="assignment" {{ old('purpose', $attendance->purpose) === 'assignment' ? 'selected' : '' }}>Assignment</option>
                        <option value="other"      {{ old('purpose', $attendance->purpose) === 'other'      ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('purpose')
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
@endsection
