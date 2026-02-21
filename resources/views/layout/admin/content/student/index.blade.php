@extends('layout.admin.dashboard')

@section('other_link_head')

    <!-- Bootstrap5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap5.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css"/>
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

        <div class="info-data">

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Students Registered Today</h2>
                    <span class="material-symbols-rounded icon icon-people">person_book</span>
                </div>
                <p class="number-people">{{ $studentsToday }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total Students</h2>
                    <span class="material-symbols-rounded icon icon-member">groups</span>
                </div>
                <p class="totle-member">{{ $totalStudents }}</p>
            </div>

        </div>

        <div class="recent-activity">
            <h5 class="activity-title">Recent Students

                <a href="{{ route('student.create') }}" class="btn btn-primary float-end mb-2">
                    <i class="bi bi-database-fill-add pe-1"></i>
                    Add New Student
                </a>
            </h5>

            <table id="example" class="table table-striped table-hover text-center table-bordered nowrap">
                <thead class="table-primary">
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Degree</th>
                        <th>Major</th>
                        <th>Study Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">

                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->studentcode_formatted }}</td>
                            <td>{{ $student->fullname_formatted }}</td>
                            <td>{{ Str::ucfirst($student->gender) }}</td>
                            <td>{{ $student->degree ? Str::ucfirst($student->degree->degree_level) : '-' }}</td>
                            <td>{{ $student->degree ? Str::limit($student->degree->majors, 25, '...') : '-' }}</td>
                            <td>{{ $student->degree ? Str::title($student->degree->study_time) : '-' }}</td>
                            <td>
                                @php
                                    $badge = match($student->status) {
                                        'active'    => 'success',
                                        'inactive'  => 'secondary',
                                        'graduated' => 'primary',
                                        'suspended' => 'danger',
                                        default     => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $student->status_formatted }}</span>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm me-1 btn-show" data-id="{{ $student->id }}" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <!-- ===================== Show Modal -->
        <div class="modal fade" id="showModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Student Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img id="modalImage" src="" alt="Student Photo"
                                 class="rounded-circle" style="width:100px;height:100px;object-fit:cover;">
                        </div>
                        <table class="table table-bordered">
                            <tr><th>Student ID</th><td id="modalCode"></td></tr>
                            <tr><th>Full Name</th><td id="modalName"></td></tr>
                            <tr><th>Gender</th><td id="modalGender"></td></tr>
                            <tr><th>Date of Birth</th><td id="modalDob"></td></tr>
                            <tr><th>Phone</th><td id="modalPhone"></td></tr>
                            <tr><th>Enroll Year</th><td id="modalEnroll"></td></tr>
                            <tr><th>Degree Level</th><td id="modalDegree"></td></tr>
                            <tr><th>Major</th><td id="modalMajor"></td></tr>
                            <tr><th>Study Time</th><td id="modalStudyTime"></td></tr>
                            <tr><th>Address</th><td id="modalAddress"></td></tr>
                            <tr><th>Status</th><td id="modalStatus"></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection

@section('other_script')
    <!-- Bootstrap5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).on('click', '.btn-show', function () {
            const id = $(this).data('id');
            $.get(`/admin/student/${id}`, function (s) {
                $('#modalCode').text(s.studentcode_formatted ?? '-');
                $('#modalName').text(s.fullname_formatted ?? '-');
                $('#modalGender').text(s.gender ?? '-');
                $('#modalDob').text(s.date_of_birth ?? '-');
                $('#modalPhone').text(s.phone_formatted ?? '-');
                $('#modalEnroll').text(s.enroll_year ?? '-');
                $('#modalDegree').text(s.degree_level ?? '-');
                $('#modalMajor').text(s.majors_formatted ?? '-');
                $('#modalStudyTime').text(s.study_time ?? '-');
                $('#modalAddress').text(s.address_formatted ?? '-');
                $('#modalStatus').text(s.status_formatted ?? '-');
                $('#modalImage').attr('src', s.image_url);
                new bootstrap.Modal(document.getElementById('showModal')).show();
            });
        });
    </script>

@endsection

@section('script_custom')
    <script src="{{ asset('assets/js/script_dashboard/script_table.js') }}"></script>
    <script src="{{ asset('assets/js/script_sweetalert/script.js') }}"></script>
@endsection
