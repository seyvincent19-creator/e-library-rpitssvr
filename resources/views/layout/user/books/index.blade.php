@extends('layout.user.app')

@section('head')
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ─── Search & Filter Bar ─── */
        .filter-bar {
            background: #fff;
            border-radius: 12px;
            padding: 18px 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
            margin-bottom: 28px;
        }
        .filter-bar .form-control,
        .filter-bar .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            font-size: .9rem;
        }
        .filter-bar .form-control:focus,
        .filter-bar .form-select:focus {
            border-color: #3949ab;
            box-shadow: 0 0 0 .2rem rgba(57,73,171,.15);
        }

        /* ─── Book Card ─── */
        .book-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .22s, box-shadow .22s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(0,0,0,.13);
        }
        .book-cover-wrap {
            position: relative;
            background: #f0f2f9;
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .book-cover-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .pdf-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: #fff;
            font-size: .7rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            letter-spacing: .5px;
        }
        .book-body {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .book-title {
            font-weight: 600;
            font-size: .95rem;
            color: #1a237e;
            margin-bottom: 4px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .book-author {
            font-size: .8rem;
            color: #757575;
            margin-bottom: 10px;
        }
        .book-meta {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }
        .book-meta .badge {
            font-size: .72rem;
            font-weight: 500;
            border-radius: 20px;
            padding: 4px 10px;
        }
        .book-actions {
            margin-top: auto;
            display: flex;
            gap: 8px;
        }
        .btn-view {
            flex: 1;
            background: #3949ab;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .82rem;
            padding: 7px 0;
            cursor: pointer;
            transition: background .2s;
        }
        .btn-view:hover { background: #283593; }
        .btn-download {
            flex: 1;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .82rem;
            padding: 7px 0;
            text-decoration: none;
            text-align: center;
            transition: background .2s;
        }
        .btn-download:hover { background: #b71c1c; color: #fff; }
        .btn-download-disabled {
            flex: 1;
            background: #e0e0e0;
            color: #9e9e9e;
            border: none;
            border-radius: 8px;
            font-size: .82rem;
            padding: 7px 0;
            text-align: center;
            cursor: not-allowed;
        }

        /* ─── Empty State ─── */
        .empty-state {
            text-align: center;
            padding: 80px 0;
            color: #9e9e9e;
        }
        .empty-state i { font-size: 4rem; margin-bottom: 16px; }

        /* ─── Modal ─── */
        .modal-book-cover {
            width: 100%;
            max-width: 140px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 16px rgba(0,0,0,.15);
        }
        .detail-table th {
            width: 35%;
            font-weight: 600;
            color: #424242;
            background: #f9f9ff;
        }
        .detail-table td { color: #212121; }

        /* ─── Stats ─── */
        .stats-bar {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .stat-chip {
            background: #fff;
            border-radius: 30px;
            padding: 6px 18px;
            font-size: .82rem;
            font-weight: 500;
            color: #3949ab;
            box-shadow: 0 1px 6px rgba(0,0,0,.07);
        }
        .stat-chip span { font-weight: 700; }
    </style>
@endsection

@section('content')

    {{-- Flash error --}}
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon: 'error', title: 'Oops!', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
            });
        </script>
    @endif

    <!-- Hero -->
    <div class="page-hero">
        <div class="container">
            <h1><i class="bi bi-collection-fill me-2"></i>Book Library</h1>
            <p class="mb-0">Browse and download books from our digital collection.</p>
        </div>
    </div>

    <div class="container py-4">

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-chip">Total: <span>{{ $books->total() }}</span> books</div>
            <div class="stat-chip">Page: <span>{{ $books->currentPage() }}</span> of <span>{{ $books->lastPage() }}</span></div>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('user.books.index') }}" id="filterForm">
        <div class="filter-bar">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                               placeholder="Search by title, author, subject..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="textbook" {{ request('category') == 'textbook' ? 'selected' : '' }}>Textbook</option>
                        <option value="reference book" {{ request('category') == 'reference book' ? 'selected' : '' }}>Reference Book</option>
                        <option value="research" {{ request('category') == 'research' ? 'selected' : '' }}>Research</option>
                        <option value="thesis" {{ request('category') == 'thesis' ? 'selected' : '' }}>Thesis</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="language" class="form-select" onchange="this.form.submit()">
                        <option value="">All Languages</option>
                        <option value="khmer" {{ request('language') == 'khmer' ? 'selected' : '' }}>Khmer</option>
                        <option value="english" {{ request('language') == 'english' ? 'selected' : '' }}>English</option>
                        <option value="chinese" {{ request('language') == 'chinese' ? 'selected' : '' }}>Chinese</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                    <a href="{{ route('user.books.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        </form>

        <!-- Book Grid -->
        <div class="row g-4" id="bookGrid">
            @forelse($books as $book)
                <div class="col-6 col-md-4 col-lg-3 book-item"
                     data-title="{{ strtolower($book->title) }}"
                     data-author="{{ strtolower($book->author) }}"
                     data-subject="{{ strtolower($book->subject) }}"
                     data-category="{{ $book->category }}"
                     data-language="{{ $book->language }}">
                    <div class="book-card">
                        <div class="book-cover-wrap">
                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}"
                                 onerror="this.onerror=null;this.src='{{ asset('assets/images/default-book.svg') }}'">
                            @if($book->file)
                                <span class="pdf-badge"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</span>
                            @endif
                        </div>
                        <div class="book-body">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author"><i class="bi bi-person-fill me-1"></i>{{ $book->author }}</div>
                            <div class="book-meta">
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ Str::title($book->category) }}
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    {{ ucfirst($book->language) }}
                                </span>
                            </div>
                            <div class="book-actions">
                                <button class="btn-view btn-show-detail"
                                        data-id="{{ $book->id }}"
                                        data-title="{{ $book->title }}"
                                        data-subject="{{ $book->subject }}"
                                        data-category="{{ Str::title($book->category) }}"
                                        data-author="{{ $book->author }}"
                                        data-pages="{{ $book->pages }}"
                                        data-language="{{ ucfirst($book->language) }}"
                                        data-date="{{ $book->published_date }}"
                                        data-qty="{{ $book->quantity }}"
                                        data-location="{{ strtoupper($book->location) }}"
                                        data-image="{{ $book->image_url }}"
                                        data-fileurl="{{ $book->file_url ?? '' }}">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </button>
                                @if($book->file)
                                    @auth
                                        <a href="{{ url('user/books/' . $book->id . '/download') }}"
                                           class="btn-download">
                                            <i class="bi bi-download me-1"></i>PDF
                                        </a>
                                    @else
                                        <a href="{{ url('login') }}" class="btn-download">
                                            <i class="bi bi-lock me-1"></i>Login
                                        </a>
                                    @endauth
                                @else
                                    <span class="btn-download-disabled">
                                        <i class="bi bi-file-x me-1"></i>No PDF
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-journal-x d-block"></i>
                        <h5>No books found</h5>
                        <p>The library catalog is empty.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

    <!-- ===== Book Detail Modal ===== -->
    <div class="modal fade" id="bookDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background: linear-gradient(135deg,#1a237e,#3949ab); color:#fff;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-book me-2"></i>Book Detail</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3 text-center">
                            <img id="detailImage" src="" alt="Cover" class="modal-book-cover mb-3">
                            <div id="detailDownloadWrap"></div>
                        </div>
                        <div class="col-md-9">
                            <h5 id="detailTitle" class="fw-bold text-primary mb-3"></h5>
                            <table class="table table-sm table-bordered detail-table">
                                <tr><th>Subject</th><td id="detailSubject"></td></tr>
                                <tr><th>Category</th><td id="detailCategory"></td></tr>
                                <tr><th>Author</th><td id="detailAuthor"></td></tr>
                                <tr><th>Pages</th><td id="detailPages"></td></tr>
                                <tr><th>Language</th><td id="detailLanguage"></td></tr>
                                <tr><th>Published</th><td id="detailDate"></td></tr>
                                <tr><th>Quantity</th><td id="detailQty"></td></tr>
                                <tr><th>Location</th><td id="detailLocation"></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // ─── Book Detail Modal ───────────────────────────────────────
    $(document).on('click', '.btn-show-detail', function () {
        const b = $(this).data();

        $('#detailTitle').text(b.title || '-');
        $('#detailSubject').text(b.subject || '-');
        $('#detailCategory').text(b.category || '-');
        $('#detailAuthor').text(b.author || '-');
        $('#detailPages').text(b.pages || '-');
        $('#detailLanguage').text(b.language || '-');
        $('#detailDate').text(b.date || '-');
        $('#detailQty').text(b.qty || '-');
        $('#detailLocation').text(b.location || '-');
        $('#detailImage').attr('src', b.image || '');

        const fileUrl = b.fileurl;
        if (fileUrl) {
            @auth
            $('#detailDownloadWrap').html(
                `<a href="${fileUrl}" class="btn btn-danger btn-sm w-100" download>
                    <i class="bi bi-download me-1"></i>Download PDF
                </a>`
            );
            @else
            $('#detailDownloadWrap').html(
                `<a href="{{ url('login') }}" class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-lock me-1"></i>Login to Download
                </a>`
            );
            @endauth
        } else {
            $('#detailDownloadWrap').html(
                `<span class="text-muted small"><i class="bi bi-file-x me-1"></i>No PDF available</span>`
            );
        }

        new bootstrap.Modal(document.getElementById('bookDetailModal')).show();
    });

</script>
@endsection
