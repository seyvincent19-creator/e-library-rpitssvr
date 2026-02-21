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
    <form action="{{ url('registration/lecturer') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Row 1 : Lecturer ID | Full Name | Gender -->
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <label class="form-label">Lecturer ID</label>
          <input
            type="text"
            class="form-control @error('lecturer_code') is-invalid @enderror"
            name="lecturer_code"
            placeholder="Enter Lecturer ID">
          @error('lecturer_code')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Full Name</label>
          <input
            type="text"
            class="form-control @error('full_name') is-invalid @enderror"
            name="full_name"
            placeholder="Enter Full Name">
          @error('full_name')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Gender</label>
          <select
            class="form-select @error('gender') is-invalid @enderror"
            name="gender">
            <option value="" selected disabled>Select Gender</option>
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
            class="form-control @error('date_of_birth') is-invalid @enderror"
            name="date_of_birth">
          @error('date_of_birth')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Mobile Number</label>
          <input
            id="phone"
            type="text"
            class="form-control @error('phone') is-invalid @enderror"
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
            class="form-control @error('enroll_year') is-invalid @enderror"
            name="enroll_year"
            placeholder="2008..">
          @error('enroll_year')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <!-- Row 3 : Department -->
      <div class="row g-3 mt-1">
        <div class="col-12 col-md-6">
          <label class="form-label">Department</label>
          <input
            type="text"
            class="form-control @error('department') is-invalid @enderror"
            name="department"
            placeholder="e.g. Computer Science">
          @error('department')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <!-- Row 4 : Address + Profile Photo -->
      <div class="row g-3 mt-1">
        <div class="col-md-6">
          <label for="address">Address</label>
          <textarea
            class="form-control @error('address') is-invalid @enderror"
            name="address"
            placeholder="Enter your Village, commune/sangkat, city/district, province"></textarea>
          @error('address')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Profile Photo</label>

          <!-- Upload zone -->
          <div class="upload-zone" id="uploadZone">
            <input
              type="file"
              class="@error('image') is-invalid @enderror"
              name="image"
              id="photoInput"
              accept="image/*">
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

      <!-- Submit button -->
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
        let value = e.target.value.replace(/\D/g, "");
        if (value.length > 3 && value.length <= 6) {
            value = value.replace(/(\d{3})(\d+)/, "$1 $2");
        } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{1,4})/, "$1 $2 $3");
        }
        e.target.value = value;
    });
  </script>
</body>
</html>
