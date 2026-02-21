@extends('layout.user.app')

@section('head')
<style>
    /* ─── Stat cards ─── */
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .stat-label { font-size: .78rem; color: #757575; font-weight: 500; margin-bottom: 2px; }
    .stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; color: #1a237e; }

    /* ─── Profile card ─── */
    .profile-card {
        background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
        border-radius: 16px;
        padding: 28px;
        color: #fff;
        box-shadow: 0 6px 24px rgba(26,35,126,.3);
    }
    .profile-avatar {
        width: 70px; height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; margin-bottom: 12px;
        border: 3px solid rgba(255,255,255,.4);
        overflow: hidden;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-name { font-size: 1.2rem; font-weight: 700; margin-bottom: 2px; }
    .profile-code { font-size: .8rem; opacity: .8; margin-bottom: 16px; }
    .profile-meta { font-size: .82rem; opacity: .9; }
    .profile-meta i { width: 18px; }
    .member-badge {
        display: inline-block;
        background: rgba(255,255,255,.2);
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 20px;
        padding: 3px 12px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .5px;
        margin-bottom: 14px;
    }

    /* ─── Section cards ─── */
    .section-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .section-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 600;
        font-size: .95rem;
        color: #1a237e;
        display: flex; align-items: center; gap: 8px;
    }
    .section-body { padding: 20px; }

    /* ─── Borrow table ─── */
    .borrow-table th {
        font-size: .78rem;
        font-weight: 600;
        color: #616161;
        text-transform: uppercase;
        letter-spacing: .4px;
        border-top: none;
        background: #f9f9ff;
    }
    .borrow-table td { font-size: .85rem; vertical-align: middle; }
    .borrow-cover {
        width: 36px; height: 48px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0,0,0,.12);
    }

    /* ─── Status badges ─── */
    .badge-borrowed { background: #e3f2fd; color: #1565c0; }
    .badge-returned { background: #e8f5e9; color: #2e7d32; }
    .badge-overdue  { background: #fce4ec; color: #c62828; }
    .badge-other    { background: #f3e5f5; color: #6a1b9a; }

    /* ─── Quick book strip ─── */
    .quick-book {
        display: flex; gap: 10px; align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
        text-decoration: none; color: inherit;
        transition: background .15s;
        border-radius: 8px;
        padding: 10px 8px;
    }
    .quick-book:hover { background: #f9f9ff; }
    .quick-book:last-child { border-bottom: none; }
    .quick-book-cover {
        width: 38px; height: 50px;
        object-fit: cover; border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0,0,0,.12);
        flex-shrink: 0;
    }
    .quick-book-title { font-size: .83rem; font-weight: 600; color: #1a237e; line-height: 1.3; margin-bottom: 2px; }
    .quick-book-author { font-size: .75rem; color: #9e9e9e; }

    /* ─── Empty state ─── */
    .empty-borrow {
        text-align: center; padding: 40px 0; color: #bdbdbd;
    }
    .empty-borrow i { font-size: 2.5rem; display: block; margin-bottom: 8px; }
    .empty-borrow p { font-size: .85rem; }

    /* ─── Fine alert ─── */
    .fine-alert {
        background: #fff8e1;
        border-left: 4px solid #f9a825;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: .85rem;
        color: #5d4037;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')

    <!-- Page hero -->
    <div class="page-hero">
        <div class="container">
            <h1><i class="bi bi-speedometer2 me-2"></i>My Dashboard</h1>
            <p class="mb-0">Welcome back, <strong>{{ $user->name_formatted }}</strong>! Here's your library overview.</p>
        </div>
    </div>

    <div class="container py-4">

        {{-- Fine alert --}}
        @if($totalFine > 0)
        <div class="fine-alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            You have an outstanding fine of <strong>${{ number_format($totalFine, 2) }}</strong>.
            Please visit the library to settle the payment.
        </div>
        @endif

        <div class="row g-4">

            {{-- ─── Left Column ─── --}}
            <div class="col-lg-4">

                {{-- Profile Card --}}
                <div class="profile-card mb-4">
                    <div class="profile-avatar">
                        @if($user->student && $user->student->image)
                            <img src="{{ $user->student->image_url }}" alt="avatar">
                        @elseif($user->lecturer && $user->lecturer->image)
                            <img src="{{ $user->lecturer->image_url }}" alt="avatar">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>

                    <div class="member-badge">
                        <i class="bi bi-patch-check-fill me-1"></i>
                        {{ $user->code_member ?? 'Member' }}
                    </div>

                    <div class="profile-name">{{ $user->name_formatted }}</div>
                    <div class="profile-code">{{ $user->email }}</div>

                    @if($user->student)
                        <div class="profile-meta">
                            <div class="mb-1"><i class="bi bi-mortarboard-fill"></i> {{ $user->student->fullname_formatted }}</div>
                            <div class="mb-1"><i class="bi bi-card-text"></i> {{ strtoupper($user->student->student_code) }}</div>
                            <div class="mb-1"><i class="bi bi-telephone-fill"></i> {{ $user->student->phone_formatted }}</div>
                            @if($user->student->degree)
                            <div class="mb-1"><i class="bi bi-award-fill"></i> {{ $user->student->degree->level ?? '' }}</div>
                            @endif
                        </div>
                    @elseif($user->lecturer)
                        <div class="profile-meta">
                            <div class="mb-1"><i class="bi bi-person-workspace"></i> {{ $user->lecturer->fullname_formatted }}</div>
                            <div class="mb-1"><i class="bi bi-card-text"></i> {{ strtoupper($user->lecturer->lecturer_code) }}</div>
                            <div class="mb-1"><i class="bi bi-telephone-fill"></i> {{ $user->lecturer->phone_formatted }}</div>
                            <div class="mb-1"><i class="bi bi-building"></i> {{ $user->lecturer->department }}</div>
                        </div>
                    @else
                        <div class="profile-meta">
                            <div><i class="bi bi-person-circle"></i> Regular Member</div>
                        </div>
                    @endif
                </div>

                {{-- Quick Links --}}
                <div class="section-card mb-4">
                    <div class="section-header"><i class="bi bi-lightning-fill"></i> Quick Links</div>
                    <div class="section-body p-0">
                        <a href="{{ url('user/books') }}" class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none border-bottom" style="color:inherit; transition:background .15s;" onmouseover="this.style.background='#f9f9ff'" onmouseout="this.style.background=''">
                            <span style="width:34px;height:34px;background:#e8eaf6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#3949ab;font-size:1rem;flex-shrink:0;">
                                <i class="bi bi-collection-fill"></i>
                            </span>
                            <div>
                                <div style="font-size:.85rem;font-weight:600;color:#1a237e;">Browse Books</div>
                                <div style="font-size:.75rem;color:#9e9e9e;">{{ $totalBooks }} books · {{ $pdfBooks }} with PDF</div>
                            </div>
                        </a>
                        <a href="{{ url('/') }}" class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none" style="color:inherit; transition:background .15s;" onmouseover="this.style.background='#f9f9ff'" onmouseout="this.style.background=''">
                            <span style="width:34px;height:34px;background:#e8f5e9;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#2e7d32;font-size:1rem;flex-shrink:0;">
                                <i class="bi bi-house-fill"></i>
                            </span>
                            <div>
                                <div style="font-size:.85rem;font-weight:600;color:#1a237e;">Home Page</div>
                                <div style="font-size:.75rem;color:#9e9e9e;">Back to landing page</div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- New Arrivals --}}
                @if($newBooks->count())
                <div class="section-card">
                    <div class="section-header"><i class="bi bi-stars"></i> New Arrivals</div>
                    <div class="section-body">
                        @foreach($newBooks as $nb)
                        <a href="{{ url('user/books') }}" class="quick-book">
                            <img src="{{ $nb->image_url }}" alt="{{ $nb->title }}" class="quick-book-cover">
                            <div>
                                <div class="quick-book-title">{{ Str::limit($nb->title, 30) }}</div>
                                <div class="quick-book-author">{{ $nb->author }}</div>
                            </div>
                            @if($nb->file)
                                <span class="ms-auto badge" style="background:#fce4ec;color:#c62828;font-size:.65rem;border-radius:20px;">PDF</span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- ─── Right Column ─── --}}
            <div class="col-lg-8">

                {{-- Stat cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background:#e8eaf6;color:#3949ab;">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <div>
                                <div class="stat-label">Total Borrowed</div>
                                <div class="stat-value">{{ $borrows->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background:#e3f2fd;color:#1565c0;">
                                <i class="bi bi-bookmark-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Active</div>
                                <div class="stat-value" style="color:#1565c0;">{{ $activeBorrows->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background:#e8f5e9;color:#2e7d32;">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Returned</div>
                                <div class="stat-value" style="color:#2e7d32;">{{ $returnedCount }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background:#fce4ec;color:#c62828;">
                                <i class="bi bi-exclamation-circle-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Overdue</div>
                                <div class="stat-value" style="color:#c62828;">{{ $overdueCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Borrow History --}}
                <div class="section-card mb-4">
                    <div class="section-header">
                        <i class="bi bi-clock-history"></i> Borrow History
                        <span class="ms-auto badge" style="background:#e8eaf6;color:#3949ab;border-radius:20px;font-size:.72rem;">
                            {{ $borrows->count() }} records
                        </span>
                    </div>
                    <div class="section-body p-0">
                        @if($borrows->isEmpty())
                            <div class="empty-borrow">
                                <i class="bi bi-journal-x"></i>
                                <p>You haven't borrowed any books yet.</p>
                                <a href="{{ url('user/books') }}" class="btn btn-sm" style="background:#3949ab;color:#fff;border-radius:8px;">Browse Books</a>
                            </div>
                        @else
                        <div class="table-responsive">
                            <table class="table borrow-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Book</th>
                                        <th>Borrow Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th class="pe-4">Fine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrows->sortByDesc('borrow_date') as $borrow)
                                    @php
                                        $ret    = $borrow->returnBook;
                                        $status = $ret ? $ret->status : 'borrowed';
                                        $fine   = $ret ? $ret->fine : 0;
                                        $isOverdue = !$ret && \Carbon\Carbon::parse($borrow->due_date)->isPast();
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $borrow->book->image_url }}"
                                                     alt="{{ $borrow->book->title }}"
                                                     class="borrow-cover">
                                                <div>
                                                    <div style="font-weight:600;font-size:.83rem;color:#1a237e;">
                                                        {{ Str::limit($borrow->book->title, 28) }}
                                                    </div>
                                                    <div style="font-size:.74rem;color:#9e9e9e;">
                                                        {{ $borrow->book->author }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($borrow->due_date)->format('d M Y') }}
                                            @if($isOverdue)
                                                <div style="font-size:.7rem;color:#c62828;">Overdue!</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isOverdue && $status === 'borrowed')
                                                <span class="badge badge-overdue rounded-pill px-3">Overdue</span>
                                            @elseif($status === 'returned')
                                                <span class="badge badge-returned rounded-pill px-3">Returned</span>
                                            @elseif($status === 'overdue')
                                                <span class="badge badge-overdue rounded-pill px-3">Overdue</span>
                                            @elseif($status === 'other')
                                                <span class="badge badge-other rounded-pill px-3">Other</span>
                                            @else
                                                <span class="badge badge-borrowed rounded-pill px-3">Active</span>
                                            @endif
                                        </td>
                                        <td class="pe-4">
                                            @if($fine > 0)
                                                <span style="color:#c62828;font-weight:600;">${{ number_format($fine, 2) }}</span>
                                            @else
                                                <span style="color:#bdbdbd;">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Active borrows reminder --}}
                @if($activeBorrows->count())
                <div class="section-card">
                    <div class="section-header">
                        <i class="bi bi-bookmark-check-fill" style="color:#1565c0;"></i>
                        Currently Borrowed
                        <span class="ms-auto badge rounded-pill" style="background:#e3f2fd;color:#1565c0;font-size:.72rem;">
                            {{ $activeBorrows->count() }}
                        </span>
                    </div>
                    <div class="section-body">
                        <div class="row g-3">
                            @foreach($activeBorrows as $ab)
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($ab->due_date), false);
                            @endphp
                            <div class="col-md-6">
                                <div style="border:1px solid #e8eaf6;border-radius:10px;padding:12px;display:flex;gap:12px;align-items:center;">
                                    <img src="{{ $ab->book->image_url }}" alt="{{ $ab->book->title }}"
                                         style="width:42px;height:56px;object-fit:cover;border-radius:5px;box-shadow:0 2px 8px rgba(0,0,0,.1);flex-shrink:0;">
                                    <div style="min-width:0;">
                                        <div style="font-size:.83rem;font-weight:600;color:#1a237e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ Str::limit($ab->book->title, 25) }}
                                        </div>
                                        <div style="font-size:.75rem;color:#9e9e9e;">Due: {{ \Carbon\Carbon::parse($ab->due_date)->format('d M Y') }}</div>
                                        @if($daysLeft < 0)
                                            <span style="font-size:.72rem;color:#c62828;font-weight:600;">
                                                <i class="bi bi-exclamation-triangle-fill"></i> {{ abs($daysLeft) }} days overdue
                                            </span>
                                        @elseif($daysLeft <= 3)
                                            <span style="font-size:.72rem;color:#f57c00;font-weight:600;">
                                                <i class="bi bi-clock-fill"></i> {{ $daysLeft }} days left
                                            </span>
                                        @else
                                            <span style="font-size:.72rem;color:#2e7d32;">
                                                <i class="bi bi-check-circle-fill"></i> {{ $daysLeft }} days left
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

@endsection
