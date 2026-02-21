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

        {{-- ── Banner ──────────────────────────────────────────────────────────── --}}
        <div class="image">
            <img src="{{ asset('assets/image/img_dashboard/banner-e-library.jpg') }}" alt="">
            <h1 class="title welcome-title" data-aos="fade-down" data-aos-delay="100">
                <span>សូមស្វាគមន៍មកកាន់ការគ្រប់គ្រង</span>
                បណ្ណាល័យនៃវិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនស្វាយរៀង
            </h1>
        </div>

        {{-- ── Summary Cards ───────────────────────────────────────────────────── --}}
        <div class="info-data">

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <div>
                        <h2>Total Books</h2>
                        <p>{{ number_format($totalBooks) }}</p>
                    </div>
                    <span class="material-symbols-rounded icon icon-book">book_2</span>
                </div>
                <span class="progress pro-book" data-value="{{ $booksProgress }}"></span>
                <span class="label">{{ $booksProgress }} checked out</span>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <div>
                        <h2>Active Members</h2>
                        <p>{{ number_format($activeMembers) }} / {{ number_format($totalMembers) }}</p>
                    </div>
                    <span class="material-symbols-rounded icon icon-member">groups</span>
                </div>
                <span class="progress pro-member" data-value="{{ $memberProgress }}"></span>
                <span class="label">{{ $memberProgress }} currently borrowing</span>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <div>
                        <h2>Books Checked Out</h2>
                        <p>{{ number_format($checkedOut) }}
                            @if ($overdueCount > 0)
                                <small class="text-danger">({{ $overdueCount }} overdue)</small>
                            @endif
                        </p>
                    </div>
                    <span class="material-symbols-rounded icon icon-out">sync_alt</span>
                </div>
                <span class="progress pro-out" data-value="{{ $overdueProgress }}"></span>
                <span class="label">{{ $overdueProgress }} overdue</span>
            </div>

        </div>

        {{-- ── Recent Activity + Chart ─────────────────────────────────────────── --}}
        <div class="dashboard-row">

            {{-- Activity Feed --}}
            <div class="recent-activity">
                <h2 class="activity-title">Recent Activity</h2>

                @forelse ($activities as $item)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <span class="material-symbols-rounded icon {{ $item['class'] }}">
                                {{ $item['icon'] }}
                            </span>
                        </div>
                        <div class="activity-details">
                            <h4>{{ $item['title'] }}</h4>
                            <p>{{ $item['desc'] }}</p>
                            @if ($item['sub'])
                                <p class="text-muted" style="font-size:0.82rem;">{{ $item['sub'] }}</p>
                            @endif
                            <span class="activity-time">
                                {{ $item['time'] ? $item['time']->diffForHumans() : '' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">No recent activity yet.</p>
                @endforelse
            </div>

            {{-- Bar Chart: Registrations Last 7 Days --}}
            <div class="recent-activity">
                <h2 class="activity-title">User Registrations — Last 7 Days</h2>
                <div id="column_with_drilldown"></div>
            </div>

        </div>

    </main>
@endsection

@section('other_script')
    <!-- Bootstrap5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Highcharts -->
    <script src="{{ asset('assets/js/script_highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('assets/js/script_highcharts/exporting.js') }}"></script>
    <script src="{{ asset('assets/js/script_highcharts/export-data.js') }}"></script>
    <script src="{{ asset('assets/js/script_highcharts/accessibility.js') }}"></script>

    <script>
        const weekData = @json($weekData);

        Highcharts.chart('column_with_drilldown', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent',
            },
            title:    { text: null },
            subtitle: { text: null },
            credits:  { enabled: false },
            exporting: { enabled: false },
            accessibility: { announceNewData: { enabled: true } },
            xAxis: {
                type: 'category',
                labels: { style: { color: 'var(--dark-light)' } }
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Registrations',
                    style: { color: 'var(--dark-light)' }
                },
                labels: {
                    style: { color: 'var(--dark-light)', fontSize: '12px', fontWeight: '500' }
                }
            },
            legend: { enabled: false },
            tooltip: { enabled: true, headerFormat: '<b>{point.key}</b><br/>', pointFormat: '{series.name}: <b>{point.y}</b>' },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    borderRadius: 4,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            series: [{
                name: 'Users Registered',
                colorByPoint: true,
                data: weekData
            }]
        });
    </script>
@endsection
