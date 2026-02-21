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
            <h2 class="activity-title">Add Lecturer

                <a href="{{ route('lecturer.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('lecturer.store') }}" method="POST"
                  class="row g-3" enctype="multipart/form-data">
                @csrf

                {{-- Lecturer ID --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Lecturer ID</label>
                    <input type="text" name="lecturer_code"
                           class="form-control @error('lecturer_code') is-invalid @enderror"
                           placeholder="e.g. Pro_3351..."
                           value="{{ old('lecturer_code') }}">
                    @error('lecturer_code')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Full Name --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name"
                           class="form-control @error('full_name') is-invalid @enderror"
                           placeholder="Enter full name..."
                           value="{{ old('full_name') }}">
                    @error('full_name')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="" selected disabled>Select Gender</option>
                        <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other"  {{ old('gender') == 'other'  ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Date of Birth --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                           class="form-control @error('date_of_birth') is-invalid @enderror"
                           value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           placeholder="e.g. 012345678..."
                           value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Enroll Year --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Enroll Year</label>
                    <input type="number" name="enroll_year"
                           class="form-control @error('enroll_year') is-invalid @enderror"
                           placeholder="e.g. 2020"
                           min="1990" max="{{ now()->year }}"
                           value="{{ old('enroll_year') }}">
                    @error('enroll_year')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Department --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Department</label>
                    <input type="text" name="department"
                           class="form-control @error('department') is-invalid @enderror"
                           placeholder="e.g. Computer Science..."
                           value="{{ old('department') }}">
                    @error('department')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active"    {{ old('status', 'active') == 'active'    ? 'selected' : '' }}>Active</option>
                        <option value="inactive"  {{ old('status') == 'inactive'  ? 'selected' : '' }}>Inactive</option>
                        <option value="retired"   {{ old('status') == 'retired'   ? 'selected' : '' }}>Retired</option>
                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="mb-3 col-md-8">
                    <label class="form-label">Address</label>
                    <textarea name="address"
                              class="form-control @error('address') is-invalid @enderror"
                              placeholder="Village, Commune, District, Province">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Image Upload --}}
                <div class="mb-3 col-md-9 upload-card">
                    <label class="form-label upload-box image-box">
                        <input type="file" name="image" class="form-control"
                               accept="image/*" id="imageInput" hidden>
                        <div class="upload-content">
                            <img id="imagePreview" src="" alt="" style="display:none;">
                            <i class="bi bi-image"></i>
                            <p>Upload Image <small class="text-muted">(max 2MB)</small></p>
                        </div>
                    </label>
                    @error('image')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-end col-md-12">
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-arrow-up-circle pe-1"></i>
                        Create
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

@section('script_custom')
    <script src="{{ asset('assets/js/script_member/script.js') }}"></script>
@endsection
