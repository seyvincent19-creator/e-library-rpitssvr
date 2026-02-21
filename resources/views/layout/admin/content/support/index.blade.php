@extends('layout.admin.dashboard')

@section('other_link_head')
    <!-- Bootstrap5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
@endsection

@section('link_custom')
    <link rel="stylesheet" href="{{ asset('assets/css/style_dashboard/style_all.css') }}">
@endsection

@section('content')
    <main>

        {{-- ── Header Cards ──────────────────────────────────────────────────────── --}}
        <div class="info-data">
            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Help & Support</h2>
                    <span class="material-symbols-rounded icon icon-book">help</span>
                </div>
                <p class="number-book">FAQ</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Contact</h2>
                    <span class="material-symbols-rounded icon icon-member">contact_support</span>
                </div>
                <p class="totle-member">Admin</p>
            </div>
        </div>

        {{-- ── FAQ ─────────────────────────────────────────────────────────────── --}}
        <div class="recent-activity" data-aos="fade-up">
            <h5 class="activity-title">Frequently Asked Questions</h5>

            <div class="accordion" id="faqAccordion">

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How do I borrow a book?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to <strong>Library → Borrow Books</strong> and click <em>Add New Borrow</em>. Select the member and book, set the borrow date and due date, then save.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            How do I return a book?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to <strong>Library → Return Books</strong> and click <em>Add New Return</em>. Select the borrow record, set the return date, and update the status accordingly.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            How do I add a new member?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            First add the student or lecturer profile under <strong>Member → Student</strong> or <strong>Member → Lecturer</strong>, then create their user account under <strong>Member → Users</strong>.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            How is overdue fine calculated?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Fines are applied manually when processing a return. Enter the fine amount in the return book form. The default charge is <strong>$0.25 per overdue day</strong>.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            How do I record attendance?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to <strong>Attendance</strong> from the sidebar and click <em>Add New Attendance</em>. Select the student or lecturer, entry time, purpose, and date.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Contact ──────────────────────────────────────────────────────────── --}}
        <div class="recent-activity" data-aos="fade-up">
            <h5 class="activity-title">Contact & Support</h5>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width:200px"><i class="bi bi-person-fill me-2"></i>System Admin</th>
                        <td>admin@example.com</td>
                    </tr>
                    <tr>
                        <th><i class="bi bi-envelope-fill me-2"></i>Support Email</th>
                        <td>support@elibrary.local</td>
                    </tr>
                    <tr>
                        <th><i class="bi bi-telephone-fill me-2"></i>Phone</th>
                        <td>+855 88 500 1000</td>
                    </tr>
                    <tr>
                        <th><i class="bi bi-clock-fill me-2"></i>Office Hours</th>
                        <td>Monday – Friday, 08:00 – 17:00</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
@endsection

@section('other_script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
@endsection
