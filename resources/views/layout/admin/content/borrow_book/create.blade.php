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
            <h2 class="activity-title">Issue Book

                <a href="{{ route('borrow_book.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('borrow_book.store') }}" method="POST" class="row g-3">
                @csrf

                {{-- Member --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Member</label>
                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                        <option value="" selected disabled>Select Member</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->code_member }} — {{ $user->name_formatted }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Book --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Book <small class="text-muted">(only available books shown)</small></label>
                    <select name="book_id" class="form-select @error('book_id') is-invalid @enderror">
                        <option value="" selected disabled>Select Book</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}"
                                {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} — [Qty: {{ $book->quantity }}]
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Borrow Date --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Borrow Date</label>
                    <input type="date" name="borrow_date"
                           class="form-control @error('borrow_date') is-invalid @enderror"
                           value="{{ old('borrow_date', now()->toDateString()) }}">
                    @error('borrow_date')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Due Date --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date"
                           class="form-control @error('due_date') is-invalid @enderror"
                           value="{{ old('due_date') }}">
                    @error('due_date')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-end col-md-12">
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-arrow-up-circle pe-1"></i>
                        Issue
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
