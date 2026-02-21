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
            <h2 class="activity-title">Add New Book

                <a href="{{ route('manage_book.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('manage_book.store') }}" method="POST"
                  class="row g-3" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Enter book title..."
                           value="{{ old('title') }}">
                    @error('title')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Subject --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject"
                           class="form-control @error('subject') is-invalid @enderror"
                           placeholder="e.g. Computer Science..."
                           value="{{ old('subject') }}">
                    @error('subject')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="" selected disabled>Select Category</option>
                        <option value="textbook"      {{ old('category') == 'textbook'      ? 'selected' : '' }}>Textbook</option>
                        <option value="reference book" {{ old('category') == 'reference book' ? 'selected' : '' }}>Reference Book</option>
                        <option value="research"      {{ old('category') == 'research'      ? 'selected' : '' }}>Research</option>
                        <option value="thesis"        {{ old('category') == 'thesis'        ? 'selected' : '' }}>Thesis</option>
                    </select>
                    @error('category')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Author --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Author</label>
                    <input type="text" name="author"
                           class="form-control @error('author') is-invalid @enderror"
                           placeholder="Enter author name..."
                           value="{{ old('author') }}">
                    @error('author')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Published Date --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Published Date</label>
                    <input type="date" name="published_date"
                           class="form-control @error('published_date') is-invalid @enderror"
                           value="{{ old('published_date') }}">
                    @error('published_date')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Language --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-select @error('language') is-invalid @enderror">
                        <option value="" selected disabled>Select Language</option>
                        <option value="khmer"   {{ old('language') == 'khmer'   ? 'selected' : '' }}>Khmer</option>
                        <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>English</option>
                        <option value="chinese" {{ old('language') == 'chinese' ? 'selected' : '' }}>Chinese</option>
                    </select>
                    @error('language')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Pages --}}
                <div class="mb-3 col-md-3">
                    <label class="form-label">Pages</label>
                    <input type="number" name="pages"
                           class="form-control @error('pages') is-invalid @enderror"
                           placeholder="e.g. 320"
                           min="1"
                           value="{{ old('pages') }}">
                    @error('pages')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div class="mb-3 col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity"
                           class="form-control @error('quantity') is-invalid @enderror"
                           placeholder="e.g. 5"
                           min="0"
                           value="{{ old('quantity') }}">
                    @error('quantity')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-3 col-md-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location"
                           class="form-control @error('location') is-invalid @enderror"
                           placeholder="e.g. A1, B5..."
                           value="{{ old('location') }}">
                    @error('location')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Book Cover Image --}}
                <div class="mb-3 col-md-5 upload-card">
                    <label class="form-label upload-box image-box">
                        <input type="file" name="image" class="form-control"
                               accept="image/*" id="imageInput" hidden>
                        <div class="upload-content">
                            <img id="imagePreview" src="" alt="" style="display:none;">
                            <i class="bi bi-image"></i>
                            <p>Upload Cover <small class="text-muted">(max 2MB)</small></p>
                        </div>
                    </label>
                    @error('image')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- PDF Upload --}}
                <div class="mb-3 col-md-5 upload-card">
                    <label class="form-label upload-box file-box">
                        <input type="file" name="file" id="pdfInput" accept="application/pdf" hidden>
                        <div class="upload-content">
                            <i class="bi bi-filetype-pdf"></i>
                            <p id="pdfName">Upload PDF <small class="text-muted">(optional, max 20MB)</small></p>
                        </div>
                    </label>
                    @error('file')
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
    <script src="{{ asset('assets/js/script_book/script.js') }}"></script>
@endsection
