<!DOCTYPE html>
<html lang="km">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registration</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>

  <link rel="stylesheet" href="{{ asset('assets/css/style_registration/style.css') }}">
</head>
<body>

  <div class="reg-card">
    <!-- Title -->
    <h1 class="reg-title">Registration</h1>

    <!-- Section label -->
    <p class="section-label">Personal Details</p>

    <!-- Form -->
    <form action="{{ url('registration/student') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Row 1 : Student ID | Full Name | Gender -->
        <div class="row g-3">

            <div class="col-12 col-md-4">
            <label class="form-label">Student ID</label>
            <input
                    type="text"
                    class="form-control
                    @error('student_code') is-invalid @enderror"
                    name="student_code"
                    placeholder="Enter Student ID">
                    @error('student_code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-12 col-md-4">

                <label class="form-label">Full Name</label>
                <input
                    type="text"
                    class="form-control
                    @error('full_name') is-invalid @enderror"
                    name="full_name"
                    placeholder="Enter Full Name">
                    @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

            </div>

            <div class="col-12 col-md-4">

            <label class="form-label">Gender</label>
            <select
                    id="gender"
                    class="form-select
                    @error('gender') is-invalid @enderror"
                    name="gender">

                        <option selected disabled value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>

                </select>
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>

        </div>

      <!-- Row 2 : Date of Birth | Mobile Number | Enroll Year -->
        <div class="row g-3 mt-1">

            <div class="col-12 col-md-4">

                <label class="form-label">Date of Birth</label>
                <input
                    type="date"
                    class="form-control
                    @error('date_of_birth') is-invalid @enderror"
                    name="date_of_birth">

                </input>
                @error('date_of_birth')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Mobile Number</label>
                <input
                    id="phone"
                    type="text"
                    class="form-control
                    @error('phone') is-invalid @enderror"
                    name="phone"
                    placeholder="Enter Phone">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-12 col-md-4">

                <label class="form-label">Enroll Year</label>
                <input
                    type="text"
                    class="form-control
                    @error('enroll_year') is-invalid @elseif(old('enroll_year')) is-valid @enderror"
                    name="enroll_year"
                    placeholder="2015 ..">
                    @error('enroll_year')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

            </div>

        </div>

      <!-- Row 3 : Degree | Major | Study Time -->
        <div class="row g-3 mt-1">
            {{-- Select Degree Level (Degree FK) --}}
            <div class="col-12 col-md-3">
                <label for="degree">Degree</label>
                <select
                    id="degree"
                    class="form-select
                    @error('degree') is-invalid @enderror"
                    name="degree">

                        <option selected disabled value="">Select Degree</option>


                        @foreach ($degrees as $degree)
                            <option value="{{ $degree->degree_level }}">
                                {{ Str::ucfirst($degree->degree_level) }}
                            </option>
                        @endforeach

                </select>
                @error('degree')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            {{-- Select Major (Degree FK) --}}
            <div class="col-12 col-md-5">
                <label for="majors">Major</label>
                <select
                    id="majors"
                    class="form-select
                    @error('majors') is-invalid @enderror"
                    name="majors">
                        <option selected disabled value="">Select Major</option>


                </select>
                @error('majors')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            {{-- Select Time (Degree FK) --}}
            <div class="col-md-4">
                <label for="study_time">Study Time</label>
                <select
                    id="study_time"
                    class="form-select
                    @error('study_time') is-invalid @enderror"
                    name="study_time">

                        <option selected disabled value="">Select Study Time</option>

                </select>
                @error('study_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            {{-- Hidden degree_id --}}
            <input type="hidden" name="degree_id" id="degree_id">
        </div>

      <!-- Row 4 : Address + Profile Photo -->
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label for="address">Address</label>
                <textarea
                    class="form-control
                    @error('address') is-invalid @enderror"
                    name="address"
                    placeholder="Enter your Village, commune/sangtat, city/district, province"></textarea>

                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>


            <div class="col-12 col-md-6">
                <label class="form-label">Profile Photo</label>

                <!-- Upload zone -->
                <div class="upload-zone" id="uploadZone">
                    {{-- <input type="file" id="photoInput" accept="image/*"/> --}}
                    <input
                        type="file"
                        class="@error('image') is-invalid @enderror"
                        name="image"
                        id="photoInput"
                        accept="image/*" >
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <i class="bi bi-cloud-arrow-up upload-icon"></i>
                    <p class="upload-text mb-0">
                    <span>Click to upload</span> or drag &amp; drop<br>
                    PNG, JPG, JPEG (max 5 MB)
                    </p>

                </div>

                <!-- Preview -->
                <div class="img-preview-wrap mt-2" id="previewWrap">
                    <img id="previewImg" src="#" alt="Preview"/>
                    <button type="button" class="img-remove-btn" id="removeBtn" title="Remove">
                    <i class="bi bi-x"></i>
                    </button>
                </div>

                <div id="fileName" class="mt-1" style="font-size:.75rem; color:var(--text-muted);"></div>

            </div>

        </div>

        <!-- Next button -->
        <div>
            <button type="submit" class="btn-next">
            Submit <i class="bi bi-send-fill"></i>
            </button>
        </div>


    </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="{{ asset('assets/js/script_registration/script.js') }}"></script>

  {{-- Script Phone --}}
  <script>
    document.getElementById("phone").addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, ""); // Remove non-digits

        // Format: 3 3 4 digits
        if (value.length > 3 && value.length <= 6) {
            value = value.replace(/(\d{3})(\d+)/, "$1 $2");
        } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{1,4})/, "$1 $2 $3");
        }

        e.target.value = value;
    });

  </script>

  <script src="{{ asset('assets/js/script_ajax_api/script.js') }}"></script>
</body>
</html>
