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

        {{-- Duplicate Error --}}
        @if ($errors->has('duplicate'))
            <div class="container">
                <script>
                    Swal.fire({
                        position: "top-end",
                        title: "❌ {{ $errors->first('duplicate') }}",
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
            <h2 class="activity-title">Edit Degree

                <a href="{{ route('degree.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('degree.update', $degree->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- Major --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Major</label>
                    <input type="text" name="majors"
                           class="form-control @error('majors') is-invalid @enderror"
                           value="{{ old('majors', $degree->majors_formatted) }}"
                           placeholder="Enter major name...">
                    @error('majors')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Duration Years --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Duration Years</label>
                    <select name="duration_years"
                            class="form-select @error('duration_years') is-invalid @enderror">
                        <option value="1 year"   {{ old('duration_years', $degree->duration_years) === '1 year'    ? 'selected' : '' }}>ឆ្នាំទី ១</option>
                        <option value="2 years"  {{ old('duration_years', $degree->duration_years) === '2 years'   ? 'selected' : '' }}>ឆ្នាំទី ២</option>
                        <option value="4 years"  {{ old('duration_years', $degree->duration_years) === '4 years'   ? 'selected' : '' }}>ឆ្នាំទី ៤</option>
                        <option value="4.5 years"{{ old('duration_years', $degree->duration_years) === '4.5 years' ? 'selected' : '' }}>ឆ្នាំទី ៤.៥</option>
                    </select>
                    @error('duration_years')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Study Time --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Study Time</label>
                    <select name="study_time"
                            class="form-select @error('study_time') is-invalid @enderror">
                        <option value="monday-friday(day)"   {{ old('study_time', $degree->study_time) === 'monday-friday(day)'   ? 'selected' : '' }}>Monday–Friday (Day)</option>
                        <option value="monday-friday(night)" {{ old('study_time', $degree->study_time) === 'monday-friday(night)' ? 'selected' : '' }}>Monday–Friday (Night)</option>
                        <option value="saturday-sunday"      {{ old('study_time', $degree->study_time) === 'saturday-sunday'      ? 'selected' : '' }}>Saturday–Sunday</option>
                        <option value="sunday"               {{ old('study_time', $degree->study_time) === 'sunday'               ? 'selected' : '' }}>Sunday</option>
                    </select>
                    @error('study_time')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Degree Level --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Degree Level</label>
                    <select name="degree_level"
                            class="form-select @error('degree_level') is-invalid @enderror">
                        <option value="associate" {{ old('degree_level', $degree->degree_level) === 'associate' ? 'selected' : '' }}>Associate</option>
                        <option value="bachelor"  {{ old('degree_level', $degree->degree_level) === 'bachelor'  ? 'selected' : '' }}>Bachelor</option>
                        <option value="technical" {{ old('degree_level', $degree->degree_level) === 'technical' ? 'selected' : '' }}>Technical</option>
                    </select>
                    @error('degree_level')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Generation --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Generation</label>
                    <select name="generation"
                            class="form-select @error('generation') is-invalid @enderror">
                        @foreach (range(1, 12) as $g)
                            @php
                                $val   = 'generation ' . $g;
                                $khmer = ['', 'ជំនាន់ទី ១','ជំនាន់ទី ២','ជំនាន់ទី ៣','ជំនាន់ទី ៤','ជំនាន់ទី ៥','ជំនាន់ទី ៦','ជំនាន់ទី ៧','ជំនាន់ទី ៨','ជំនាន់ទី ៩','ជំនាន់ទី ១០','ជំនាន់ទី ១១','ជំនាន់ទី ១២'][$g];
                            @endphp
                            <option value="{{ $val }}"
                                {{ old('generation', $degree->generation) === $val ? 'selected' : '' }}>
                                {{ $khmer }}
                            </option>
                        @endforeach
                    </select>
                    @error('generation')
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
