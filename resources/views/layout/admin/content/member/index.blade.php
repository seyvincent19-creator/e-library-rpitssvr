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
                    <h2>Members Registered Today</h2>
                    <span class="material-symbols-rounded icon icon-people">person_book</span>
                </div>
                <p class="number-people">{{ $membersToday }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Active Borrowers</h2>
                    <span class="material-symbols-rounded icon icon-book">book_3</span>
                </div>
                <p class="number-book">{{ $activeMembers }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total Members</h2>
                    <span class="material-symbols-rounded icon icon-member">groups</span>
                </div>
                <p class="totle-member">{{ $totalMembers }}</p>
            </div>

        </div>

        <div class="recent-activity">
            <h5 class="activity-title">Library Members

                <a href="{{ route('member.create') }}" class="btn btn-primary float-end mb-2">
                    <i class="bi bi-database-fill-add pe-1"></i>
                    Add Member
                </a>
            </h5>

            <table id="example" class="table table-striped table-hover text-center table-bordered nowrap">
                <thead class="table-primary">
                    <tr>
                        <th>Code Member</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profile Type</th>
                        <th>Profile Name</th>
                        <th>Active Borrows</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">

                    @foreach ($members as $member)
                        @php
                            $profileType = $member->student ? 'Student' : ($member->lecturer ? 'Lecturer' : '-');
                            $profileName = $member->student?->fullname_formatted
                                        ?? $member->lecturer?->fullname_formatted
                                        ?? '-';
                            $badgeColor  = $member->student ? 'info' : ($member->lecturer ? 'warning' : 'secondary');
                        @endphp
                        <tr>
                            <td>{{ $member->code_member }}</td>
                            <td>{{ $member->name_formatted }}</td>
                            <td>{{ $member->email }}</td>
                            <td><span class="badge bg-{{ $badgeColor }}">{{ $profileType }}</span></td>
                            <td>{{ $profileName }}</td>
                            <td>
                                @if ($member->active_borrows > 0)
                                    <span class="badge bg-primary">{{ $member->active_borrows }}</span>
                                @else
                                    <span class="text-muted">0</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm me-1 btn-show"
                                   data-id="{{ $member->id }}" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('member.edit', $member->id) }}"
                                   class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('member.destroy', $member->id) }}"
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

        <!-- ===================== Show Modal -->
        <div class="modal fade" id="showModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Member Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr><th>Code Member</th><td id="modalCode"></td></tr>
                            <tr><th>Name</th><td id="modalName"></td></tr>
                            <tr><th>Email</th><td id="modalEmail"></td></tr>
                            <tr><th>Profile Type</th><td id="modalType"></td></tr>
                            <tr><th>Profile Code</th><td id="modalProfileCode"></td></tr>
                            <tr><th>Profile Name</th><td id="modalProfileName"></td></tr>
                            <tr><th>Phone</th><td id="modalPhone"></td></tr>
                            <tr><th>Active Borrows</th><td id="modalActive"></td></tr>
                            <tr><th>Total Borrows</th><td id="modalTotal"></td></tr>
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
            $.get(`/admin/member/${id}`, function (m) {
                $('#modalCode').text(m.code_member ?? '-');
                $('#modalName').text(m.name ?? '-');
                $('#modalEmail').text(m.email ?? '-');
                $('#modalType').text(m.profile_type ?? '-');
                $('#modalProfileCode').text(m.profile_code ?? '-');
                $('#modalProfileName').text(m.profile_name ?? '-');
                $('#modalPhone').text(m.phone ?? '-');
                $('#modalActive').text(m.active_borrows ?? 0);
                $('#modalTotal').text(m.total_borrows ?? 0);
                new bootstrap.Modal(document.getElementById('showModal')).show();
            });
        });
    </script>

@endsection

@section('script_custom')
    <script src="{{ asset('assets/js/script_dashboard/script_table.js') }}"></script>
    <script src="{{ asset('assets/js/script_sweetalert/script.js') }}"></script>
@endsection
