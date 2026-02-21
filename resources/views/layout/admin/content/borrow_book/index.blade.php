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
                    <h2>Books Borrowed Today</h2>
                    <span class="material-symbols-rounded icon icon-book">book_3</span>
                </div>
                <p class="number-book">{{ $borrowsToday }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Overdue Books</h2>
                    <span class="material-symbols-rounded icon icon-out">assignment_late</span>
                </div>
                <p class="exit">{{ $overdueCount }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total Borrowings</h2>
                    <span class="material-symbols-rounded icon icon-tol_book">collections_bookmark</span>
                </div>
                <p class="number-tol_book">{{ $totalBorrows }}</p>
            </div>

        </div>

        <div class="recent-activity">
            <h5 class="activity-title">Recent Borrowings

                <a href="{{ route('borrow_book.create') }}" class="btn btn-primary float-end mb-2">
                    <i class="bi bi-database-fill-add pe-1"></i>
                    Issue Book
                </a>
            </h5>

            <table id="example" class="table table-striped table-hover text-center table-bordered nowrap">
                <thead class="table-primary">
                    <tr>
                        <th>Code Member</th>
                        <th>Member Name</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">

                    @foreach ($borrows as $borrow)
                        @php
                            $isReturned = $borrow->returnBook !== null;
                            $isOverdue  = !$isReturned && $borrow->due_date < now()->toDateString();
                        @endphp
                        <tr>
                            <td>{{ $borrow->user?->code_member ?? '-' }}</td>
                            <td>{{ $borrow->user?->name_formatted ?? '-' }}</td>
                            <td class="text-start">{{ Str::limit($borrow->book?->title, 35, '...') ?? '-' }}</td>
                            <td>{{ $borrow->borrow_date }}</td>
                            <td>{{ $borrow->due_date }}</td>
                            <td>
                                @if ($isReturned)
                                    <span class="badge bg-success">Returned</span>
                                @elseif ($isOverdue)
                                    <span class="badge bg-danger">Overdue</span>
                                @else
                                    <span class="badge bg-primary">Borrowed</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm me-1 btn-show"
                                   data-id="{{ $borrow->id }}" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if (!$isReturned)
                                    <a href="{{ route('borrow_book.edit', $borrow->id) }}"
                                       class="btn btn-warning btn-sm me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endif
                                <form action="{{ route('borrow_book.destroy', $borrow->id) }}"
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
                        <h5 class="modal-title">Borrow Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr><th>Code Member</th><td id="modalCode"></td></tr>
                            <tr><th>Member Name</th><td id="modalUser"></td></tr>
                            <tr><th>Book Title</th><td id="modalBook"></td></tr>
                            <tr><th>Subject</th><td id="modalSubject"></td></tr>
                            <tr><th>Author</th><td id="modalAuthor"></td></tr>
                            <tr><th>Borrow Date</th><td id="modalBorrowDate"></td></tr>
                            <tr><th>Due Date</th><td id="modalDueDate"></td></tr>
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
            $.get(`/admin/borrow_book/${id}`, function (b) {
                $('#modalCode').text(b.code_member ?? '-');
                $('#modalUser').text(b.user_name ?? '-');
                $('#modalBook').text(b.book_title ?? '-');
                $('#modalSubject').text(b.subject ?? '-');
                $('#modalAuthor').text(b.author ?? '-');
                $('#modalBorrowDate').text(b.borrow_date ?? '-');
                $('#modalDueDate').text(b.due_date ?? '-');
                let badge = '<span class="badge bg-primary">Borrowed</span>';
                if (b.is_returned)     badge = '<span class="badge bg-success">Returned</span>';
                else if (b.is_overdue) badge = '<span class="badge bg-danger">Overdue</span>';
                $('#modalStatus').html(badge);
                new bootstrap.Modal(document.getElementById('showModal')).show();
            });
        });
    </script>

@endsection

@section('script_custom')
    <script src="{{ asset('assets/js/script_dashboard/script_table.js') }}"></script>
    <script src="{{ asset('assets/js/script_sweetalert/script.js') }}"></script>
@endsection
