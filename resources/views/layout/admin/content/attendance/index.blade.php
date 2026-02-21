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

        {{-- ── Stats Cards ──────────────────────────────────────────────────── --}}
        <div class="info-data">

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Visitors Today</h2>
                    <span class="material-symbols-rounded icon icon-people">account_box</span>
                </div>
                <p class="number-people">{{ $visitorsToday }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Still Inside</h2>
                    <span class="material-symbols-rounded icon icon-book">meeting_room</span>
                </div>
                <p class="number-book">{{ $insideNow }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total This Month</h2>
                    <span class="material-symbols-rounded icon icon-member">groups</span>
                </div>
                <p class="totle-member">{{ $totalThisMonth }}</p>
            </div>

        </div>

        {{-- ── Table ──────────────────────────────────────────────────────────── --}}
        <div class="recent-activity">
            <h5 class="activity-title">Attendance Records

                <a href="{{ route('attendance.create') }}" class="btn btn-primary float-end mb-2">
                    <i class="bi bi-database-fill-add pe-1"></i>
                    Record Attendance
                </a>
            </h5>

            <table id="example" class="table table-striped table-hover text-center table-bordered nowrap">
                <thead class="table-primary">
                    <tr>
                        <th>Type</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Entry Time</th>
                        <th>Exit Time</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">

                    @foreach ($attendances as $att)
                        @php
                            $isStudent   = $att->student !== null;
                            $type        = $isStudent ? 'Student' : 'Lecturer';
                            $typeColor   = $isStudent ? 'info' : 'warning';
                            $code        = $att->student?->studentcode_formatted
                                        ?? $att->lecturer?->lecturercode_formatted
                                        ?? '-';
                            $name        = $att->student?->fullname_formatted
                                        ?? $att->lecturer?->fullname_formatted
                                        ?? '-';
                            $purposeLabel = ucwords(str_replace('_', ' ', $att->purpose));
                            $purposeColor = match($att->purpose) {
                                'reading'    => 'primary',
                                'use_pc'     => 'success',
                                'assignment' => 'danger',
                                'other'      => 'secondary',
                                default      => 'dark',
                            };
                        @endphp
                        <tr>
                            <td><span class="badge bg-{{ $typeColor }}">{{ $type }}</span></td>
                            <td>{{ $code }}</td>
                            <td>{{ $name }}</td>
                            <td><span class="badge bg-{{ $purposeColor }}">{{ $purposeLabel }}</span></td>
                            <td>{{ substr($att->entry_time, 0, 5) }}</td>
                            <td>{{ $att->exit_time ? substr($att->exit_time, 0, 5) : '<span class="text-muted">—</span>' }}</td>
                            <td>{{ $att->attendance_date }}</td>
                            <td>
                                <a class="btn btn-success btn-sm me-1 btn-show"
                                   data-id="{{ $att->id }}" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('attendance.edit', $att->id) }}"
                                   class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $att->id) }}"
                                      method="POST" class="d-inline">
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

        {{-- ── Show Modal ──────────────────────────────────────────────────────── --}}
        <div class="modal fade" id="showModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr><th>Visitor Type</th><td id="modalType"></td></tr>
                            <tr><th>Code</th><td id="modalCode"></td></tr>
                            <tr><th>Name</th><td id="modalName"></td></tr>
                            <tr><th>Phone</th><td id="modalPhone"></td></tr>
                            <tr><th>Entry Time</th><td id="modalEntry"></td></tr>
                            <tr><th>Exit Time</th><td id="modalExit"></td></tr>
                            <tr><th>Purpose</th><td id="modalPurpose"></td></tr>
                            <tr><th>Date</th><td id="modalDate"></td></tr>
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
            $.get(`/admin/attendance/${id}`, function (a) {
                $('#modalType').text(a.visitor_type ?? '-');
                $('#modalCode').text(a.visitor_code ?? '-');
                $('#modalName').text(a.visitor_name ?? '-');
                $('#modalPhone').text(a.phone ?? '-');
                $('#modalEntry').text(a.entry_time ?? '-');
                $('#modalExit').text(a.exit_time ?? '-');
                $('#modalPurpose').text(a.purpose ?? '-');
                $('#modalDate').text(a.date ?? '-');
                new bootstrap.Modal(document.getElementById('showModal')).show();
            });
        });
    </script>

@endsection

@section('script_custom')
    <script src="{{ asset('assets/js/script_dashboard/script_table.js') }}"></script>
    <script src="{{ asset('assets/js/script_sweetalert/script.js') }}"></script>
@endsection
