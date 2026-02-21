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
            <h2 class="activity-title">Edit Student

                <a href="{{ route('student.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('student.update', $student->id) }}" method="POST"
                  class="row g-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Student ID --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_code"
                           class="form-control @error('student_code') is-invalid @enderror"
                           value="{{ old('student_code', $student->studentcode_formatted) }}">
                    @error('student_code')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Full Name --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name"
                           class="form-control @error('full_name') is-invalid @enderror"
                           value="{{ old('full_name', $student->fullname_formatted) }}">
                    @error('full_name')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="male"   {{ old('gender', $student->gender) == 'male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other"  {{ old('gender', $student->gender) == 'other'  ? 'selected' : '' }}>Other</option>
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
                           value="{{ old('date_of_birth', $student->date_of_birth) }}">
                    @error('date_of_birth')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $student->phone) }}">
                    @error('phone')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Enroll Year --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Enroll Year</label>
                    <input type="number" name="enroll_year"
                           class="form-control @error('enroll_year') is-invalid @enderror"
                           min="2000" max="{{ now()->year }}"
                           value="{{ old('enroll_year', $student->enroll_year) }}">
                    @error('enroll_year')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Degree Level (AJAX step 1) --}}
                @php $currentDegree = $student->degree; @endphp
                <div class="mb-3 col-md-4">
                    <label class="form-label">Degree Level</label>
                    <select id="selectDegree" class="form-select">
                        <option value="" disabled>Select Degree Level</option>
                        <option value="associate" {{ $currentDegree?->degree_level == 'associate' ? 'selected' : '' }}>Associate</option>
                        <option value="bachelor"  {{ $currentDegree?->degree_level == 'bachelor'  ? 'selected' : '' }}>Bachelor</option>
                        <option value="technical" {{ $currentDegree?->degree_level == 'technical' ? 'selected' : '' }}>Technical</option>
                    </select>
                </div>

                {{-- Major (AJAX step 2) --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Major</label>
                    <select id="selectMajor" class="form-select">
                        <option value="" disabled>Select Major</option>
                        @if($currentDegree)
                            <option value="{{ $currentDegree->majors }}" selected>{{ $currentDegree->majors }}</option>
                        @endif
                    </select>
                </div>

                {{-- Study Time (AJAX step 3) --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Study Time</label>
                    <select id="selectStudyTime" class="form-select">
                        <option value="" disabled>Select Study Time</option>
                        @if($currentDegree)
                            <option value="{{ $currentDegree->study_time }}" selected>{{ $currentDegree->study_time }}</option>
                        @endif
                    </select>
                </div>

                {{-- Hidden degree_id --}}
                <input type="hidden" name="degree_id" id="degreeId"
                       value="{{ old('degree_id', $student->degree_id) }}">
                @error('degree_id')
                    <div class="col-md-12">
                        <span class="text-danger">* {{ $message }}</span>
                    </div>
                @enderror

                {{-- Status --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active"    {{ old('status', $student->status) == 'active'    ? 'selected' : '' }}>Active</option>
                        <option value="inactive"  {{ old('status', $student->status) == 'inactive'  ? 'selected' : '' }}>Inactive</option>
                        <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="suspended" {{ old('status', $student->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="mb-3 col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address"
                              class="form-control @error('address') is-invalid @enderror"
                              placeholder="Village, Commune, District, Province">{{ old('address', $student->address_formatted) }}</textarea>
                    @error('address')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Image Upload --}}
                <div class="mb-3 col-md-9 upload-card">
                    <label class="form-label upload-box image-box">
                        <input type="file" name="image" class="form-control" accept="image/*" id="imageInput" hidden>
                        <div class="upload-content">
                            <img id="imagePreview"
                                 src="{{ $student->image_url }}"
                                 alt="Student Photo"
                                 style="{{ $student->image ? 'display:block;' : 'display:none;' }}">
                            @if (!$student->image)
                                <i class="bi bi-image"></i>
                                <p>Upload New Image <small class="text-muted">(leave blank to keep current)</small></p>
                            @endif
                        </div>
                    </label>
                    @error('image')
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
        // ─── Cascading Dropdowns ─────────────────────────────────────────────────

        $('#selectDegree').on('change', function () {
            const degree = $(this).val();

            $('#selectMajor').html('<option value="" disabled selected>Select Major</option>').prop('disabled', true);
            $('#selectStudyTime').html('<option value="" disabled selected>Select Study Time</option>').prop('disabled', true);
            $('#degreeId').val('');

            if (!degree) return;

            $.get(`/get-majors/${degree}`, function (data) {
                data.forEach(function (item) {
                    $('#selectMajor').append(`<option value="${item.majors}">${item.majors}</option>`);
                });
                $('#selectMajor').prop('disabled', false);
            });
        });

        $('#selectMajor').on('change', function () {
            const degree = $('#selectDegree').val();
            const major  = $(this).val();

            $('#selectStudyTime').html('<option value="" disabled selected>Select Study Time</option>').prop('disabled', true);
            $('#degreeId').val('');

            if (!major) return;

            $.get(`/get-study_time/${degree}/${major}`, function (data) {
                data.forEach(function (item) {
                    $('#selectStudyTime').append(`<option value="${item.study_time}">${item.study_time}</option>`);
                });
                $('#selectStudyTime').prop('disabled', false);
            });
        });

        $('#selectStudyTime').on('change', function () {
            const degree    = $('#selectDegree').val();
            const major     = $('#selectMajor').val();
            const studyTime = $(this).val();

            $('#degreeId').val('');

            if (!studyTime) return;

            $.get(`/get-degree-id/${degree}/${major}/${studyTime}`, function (data) {
                $('#degreeId').val(data.id);
            });
        });
    </script>

@endsection

@section('script_custom')
    <script src="{{ asset('assets/js/script_member/script.js') }}"></script>
@endsection
