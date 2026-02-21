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
                    <h2>Books Added Today</h2>
                    <span class="material-symbols-rounded icon icon-book">book_2</span>
                </div>
                <p class="number-book">{{ $booksToday }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total Books</h2>
                    <span class="material-symbols-rounded icon icon-tol_book">collections_bookmark</span>
                </div>
                <p class="number-tol_book">{{ $totalBooks }}</p>
            </div>

        </div>

        <div class="recent-activity">
            <h5 class="activity-title">Books

                <a href="{{ route('manage_book.create') }}" class="btn btn-primary float-end mb-2">
                    <i class="bi bi-database-fill-add pe-1"></i>
                    Add New Book
                </a>
            </h5>

            <table id="example" class="table table-striped table-hover table-bordered nowrap">
                <thead class="table-primary">
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Qty</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">

                    @foreach ($books as $book)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $book->image_url }}"
                                     alt="{{ $book->title }}"
                                     style="width:45px;height:60px;object-fit:cover;border-radius:4px;">
                            </td>
                            <td>{{ Str::limit($book->title, 35, '...') }}</td>
                            <td>{{ $book->subject }}</td>
                            <td>{{ Str::title($book->category) }}</td>
                            <td>{{ $book->author }}</td>
                            <td class="text-center">{{ $book->quantity }}</td>
                            <td class="text-center">{{ strtoupper($book->location) }}</td>
                            <td class="text-center">
                                <a class="btn btn-success btn-sm me-1 btn-show"
                                   data-id="{{ $book->id }}" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('manage_book.edit', $book->id) }}"
                                   class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('manage_book.destroy', $book->id) }}"
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Book Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-3 text-center">
                            <img id="modalImage" src="" alt="Book Cover"
                                 style="width:100%;max-width:120px;border-radius:6px;object-fit:cover;">
                            <div class="mt-2" id="modalDownloadWrap" style="display:none;">
                                <a id="modalDownloadBtn" href="#" class="btn btn-sm btn-danger w-100" target="_blank">
                                    <i class="bi bi-download"></i> Download PDF
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tr><th>Title</th><td id="modalTitle"></td></tr>
                                <tr><th>Subject</th><td id="modalSubject"></td></tr>
                                <tr><th>Category</th><td id="modalCategory"></td></tr>
                                <tr><th>Author</th><td id="modalAuthor"></td></tr>
                                <tr><th>Pages</th><td id="modalPages"></td></tr>
                                <tr><th>Language</th><td id="modalLanguage"></td></tr>
                                <tr><th>Published</th><td id="modalDate"></td></tr>
                                <tr><th>Quantity</th><td id="modalQty"></td></tr>
                                <tr><th>Location</th><td id="modalLocation"></td></tr>
                            </table>
                        </div>
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
            $.get(`/admin/manage_book/${id}`, function (b) {
                $('#modalTitle').text(b.title ?? '-');
                $('#modalSubject').text(b.subject ?? '-');
                $('#modalCategory').text(b.category ?? '-');
                $('#modalAuthor').text(b.author ?? '-');
                $('#modalPages').text(b.pages ?? '-');
                $('#modalLanguage').text(b.language ?? '-');
                $('#modalDate').text(b.published_date ?? '-');
                $('#modalQty').text(b.quantity ?? '-');
                $('#modalLocation').text(b.location ?? '-');
                $('#modalImage').attr('src', b.image_url);
                if (b.file_url) {
                    $('#modalDownloadBtn').attr('href', b.file_url);
                    $('#modalDownloadWrap').show();
                } else {
                    $('#modalDownloadWrap').hide();
                }
                new bootstrap.Modal(document.getElementById('showModal')).show();
            });
        });
    </script>

@endsection

@section('script_custom')
    <script src="{{ asset('assets/js/script_dashboard/script_table.js') }}"></script>
    <script src="{{ asset('assets/js/script_sweetalert/script.js') }}"></script>
@endsection
