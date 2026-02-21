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
            <h2 class="activity-title">Return Book

                <a href="{{ route('return_book.index') }}" class="btn btn-danger float-end">
                    <i class="bi bi-arrow-left-circle pe-1"></i>
                    Back
                </a>

            </h2>

            <form action="{{ route('return_book.store') }}" method="POST" class="row g-3">
                @csrf

                {{-- Borrow Record --}}
                <div class="mb-3 col-md-12">
                    <label class="form-label">Borrow Record <small class="text-muted">(only unreturned records shown)</small></label>
                    <select name="borrow_book_id" id="borrowSelect"
                            class="form-select @error('borrow_book_id') is-invalid @enderror">
                        <option value="" selected disabled>Select Borrow Record</option>
                        @foreach ($borrows as $borrow)
                            <option value="{{ $borrow->id }}"
                                    data-due="{{ $borrow->due_date }}"
                                    {{ old('borrow_book_id') == $borrow->id ? 'selected' : '' }}>
                                {{ $borrow->user?->code_member }} — {{ $borrow->user?->name_formatted }}
                                | {{ Str::limit($borrow->book?->title, 30, '...') }}
                                | Due: {{ $borrow->due_date }}
                            </option>
                        @endforeach
                    </select>
                    @error('borrow_book_id')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Return Date --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Return Date</label>
                    <input type="date" name="return_date" id="returnDate"
                           class="form-control @error('return_date') is-invalid @enderror"
                           value="{{ old('return_date', now()->toDateString()) }}">
                    @error('return_date')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" id="statusSelect"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="returned" {{ old('status', 'returned') === 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="overdue"  {{ old('status') === 'overdue'  ? 'selected' : '' }}>Overdue</option>
                        <option value="borrowed" {{ old('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="other"    {{ old('status') === 'other'    ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('status')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                {{-- Fine --}}
                <div class="mb-3 col-md-4">
                    <label class="form-label">Fine ($) <small class="text-muted">($0.50 / day overdue)</small></label>
                    <input type="number" name="fine" id="fineInput" step="0.01" min="0"
                           class="form-control @error('fine') is-invalid @enderror"
                           value="{{ old('fine', '0.00') }}">
                    @error('fine')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-end col-md-12">
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-arrow-up-circle pe-1"></i>
                        Submit Return
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

    <script>
        const FINE_PER_DAY = 0.50;

        function calcFine() {
            const selected   = $('#borrowSelect option:selected');
            const dueDate    = selected.data('due');
            const returnDate = $('#returnDate').val();

            if (!dueDate || !returnDate) {
                $('#fineInput').val('0.00');
                return;
            }

            const due    = new Date(dueDate);
            const ret    = new Date(returnDate);
            const days   = Math.ceil((ret - due) / (1000 * 60 * 60 * 24));
            const fine   = days > 0 ? (days * FINE_PER_DAY).toFixed(2) : '0.00';

            $('#fineInput').val(fine);
            $('#statusSelect').val(days > 0 ? 'overdue' : 'returned');
        }

        $('#borrowSelect, #returnDate').on('change', calcFine);

        $(document).ready(function () {
            calcFine();
        });
    </script>

@endsection
