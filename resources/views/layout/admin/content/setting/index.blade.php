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

        {{-- ── Header ──────────────────────────────────────────────────────────── --}}
        <div class="info-data">
            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>System Settings</h2>
                    <span class="material-symbols-rounded icon icon-book">settings</span>
                </div>
                <p class="number-book">E-Library</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Logged in as</h2>
                    <span class="material-symbols-rounded icon icon-member">manage_accounts</span>
                </div>
                <p class="totle-member">{{ auth()->user()->role }}</p>
            </div>
        </div>

        {{-- ── Library Info ─────────────────────────────────────────────────────── --}}
        <div class="recent-activity" data-aos="fade-up">
            <h5 class="activity-title">Library Information</h5>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width:220px">System Name</th>
                        <td>E-Library Management System</td>
                    </tr>
                    <tr>
                        <th>Version</th>
                        <td>1.0.0</td>
                    </tr>
                    <tr>
                        <th>Framework</th>
                        <td>Laravel {{ app()->version() }}</td>
                    </tr>
                    <tr>
                        <th>PHP Version</th>
                        <td>{{ PHP_VERSION }}</td>
                    </tr>
                    <tr>
                        <th>Environment</th>
                        <td>
                            <span class="badge bg-{{ app()->environment('production') ? 'danger' : 'success' }}">
                                {{ ucfirst(app()->environment()) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>App URL</th>
                        <td>{{ config('app.url') }}</td>
                    </tr>
                    <tr>
                        <th>Timezone</th>
                        <td>{{ config('app.timezone') }}</td>
                    </tr>
                    <tr>
                        <th>Database Driver</th>
                        <td>{{ ucfirst(config('database.default')) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ── Account Info ─────────────────────────────────────────────────────── --}}
        <div class="recent-activity" data-aos="fade-up">
            <h5 class="activity-title">Account Information</h5>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width:220px">Name</th>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Member Since</th>
                        <td>{{ auth()->user()->created_at?->format('d M Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
@endsection

@section('other_script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
@endsection
