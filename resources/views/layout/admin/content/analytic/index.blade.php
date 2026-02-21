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

@endsection

@section('link_custom')
    <link rel="stylesheet" href="{{ asset('assets/css/style_dashboard/style_all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style_analytic/style.css') }}">
@endsection

@section('content')
    <main>

        {{-- ── Summary Stats ──────────────────────────────────────────── --}}
        <div class="info-data">

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total Books</h2>
                    <span class="material-symbols-rounded icon icon-book">auto_stories</span>
                </div>
                <p class="number-book">{{ number_format($totalBooks) }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Total Members</h2>
                    <span class="material-symbols-rounded icon icon-member">groups</span>
                </div>
                <p class="totle-member">{{ number_format($totalMembers) }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Borrows This Month</h2>
                    <span class="material-symbols-rounded icon icon-tol_book">book_3</span>
                </div>
                <p class="number-tol_book">{{ number_format($borrowsThisMonth) }}</p>
            </div>

            <div class="card-dashboard" data-aos="fade-up">
                <div class="head">
                    <h2>Returns This Month</h2>
                    <span class="material-symbols-rounded icon icon-out">rotate_auto</span>
                </div>
                <p class="exit">{{ number_format($returnsThisMonth) }}</p>
            </div>

        </div>

        {{-- ── Row 1: Language Donut + Purpose Cards ──────────────────── --}}
        <div class="charts-section">

            <div class="recent-activity chart-card">
                <h5 class="activity-title">Books by Language</h5>
                <div id="container-donut" class="chart-responsive"></div>

                <div class="summary-grid">
                    @foreach ($bookLanguages as $lang)
                        <div class="summary-card">
                            <p class="summary-title">Total {{ $lang['name'] }} Books</p>
                            <h2 class="summary-number">{{ number_format($lang['y']) }}</h2>
                        </div>
                    @endforeach
                    @if ($bookLanguages->isEmpty())
                        <div class="summary-card">
                            <p class="summary-title">Total Books</p>
                            <h2 class="summary-number">{{ number_format($totalBooksCount) }}</h2>
                        </div>
                    @endif
                </div>
            </div>

            <div class="recent-activity purpose-section">
                <h5 class="activity-title">Attendance by Purpose — This Month</h5>

                <div class="purpose-grid">
                    <div class="purpose-card">
                        <div class="purpose-left">
                            <div class="purpose-icon icon-blue">
                                <span class="material-symbols-rounded">menu_book</span>
                            </div>
                            <div class="purpose-text">
                                <h6>Reading</h6>
                                <p>Total this month</p>
                            </div>
                        </div>
                        <div class="purpose-number">{{ $purposeThisMonth->get('reading', 0) }}</div>
                    </div>

                    <div class="purpose-card">
                        <div class="purpose-left">
                            <div class="purpose-icon icon-green">
                                <span class="material-symbols-rounded">jamboard_kiosk</span>
                            </div>
                            <div class="purpose-text">
                                <h6>Use PC</h6>
                                <p>Total this month</p>
                            </div>
                        </div>
                        <div class="purpose-number">{{ $purposeThisMonth->get('use_pc', 0) }}</div>
                    </div>

                    <div class="purpose-card">
                        <div class="purpose-left">
                            <div class="purpose-icon icon-red">
                                <span class="material-symbols-rounded">card_travel</span>
                            </div>
                            <div class="purpose-text">
                                <h6>Assignment</h6>
                                <p>Total this month</p>
                            </div>
                        </div>
                        <div class="purpose-number">{{ $purposeThisMonth->get('assignment', 0) }}</div>
                    </div>

                    <div class="purpose-card">
                        <div class="purpose-left">
                            <div class="purpose-icon icon-teal">
                                <span class="material-symbols-rounded">other_houses</span>
                            </div>
                            <div class="purpose-text">
                                <h6>Other</h6>
                                <p>Total this month</p>
                            </div>
                        </div>
                        <div class="purpose-number">{{ $purposeThisMonth->get('other', 0) }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Row 2: Books by Category Column + Most Borrowed Table ─── --}}
        <div class="charts-section">

            <div class="recent-activity">
                <h5 class="activity-title">Books by Category &amp; Language</h5>
                <div id="container-basic_column"></div>
            </div>

            <div class="recent-activity">
                <h5 class="activity-title">Most Borrowed Books
                    <a href="{{ route('manage_book.index') }}" class="btn btn-primary float-end mb-2 btn-sm">
                        <i class="bi bi-eye"></i> View All
                    </a>
                </h5>

                <table id="topBooksTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Book Title</th>
                            <th>Category</th>
                            <th>Times Borrowed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topBooks as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->book?->title ?? '-' }}</td>
                                <td>{{ $row->book ? Str::title($row->book->category) : '-' }}</td>
                                <td><span class="badge bg-primary">{{ $row->borrow_count }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No borrow records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ── Row 3: Gender Pie + Weekly Attendance Spline ───────────── --}}
        <div class="charts-section">

            <div class="recent-activity">
                <h5 class="activity-title">Student Gender Breakdown</h5>
                <div id="container-Egg_yolk"></div>
            </div>

            <div class="recent-activity">
                <h5 class="activity-title">Attendance This Week</h5>
                <div id="container-spline"></div>
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

    <!-- Highcharts -->
    <script src="{{ asset('assets/js/script_highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('assets/js/script_highcharts/exporting.js') }}"></script>
    <script src="{{ asset('assets/js/script_highcharts/accessibility.js') }}"></script>
    <script src="{{ asset('assets/js/script_highcharts/adaptive.js') }}"></script>

    <script>
        // ── PHP → JS data ──────────────────────────────────────────────────────────
        const bookLanguages  = @json($bookLanguages->values());
        const totalBooks     = {{ $totalBooksCount }};
        const chartCategories = @json($categories);
        const chartSeries    = @json($chartSeries);
        const genderData     = @json($genderData->values());
        const weekLabels     = @json($weekLabels);
        const studentWeek    = @json($studentWeek);
        const lecturerWeek   = @json($lecturerWeek);

        // ── 1. Donut: Books by Language ───────────────────────────────────────────
        Highcharts.chart('container-donut', {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                spacing: [0, 0, 0, 0],
                custom: {},
                events: {
                    render() {
                        const chart = this, series = chart.series[0];
                        let label = chart.options.chart.custom.label;
                        if (!label) {
                            label = chart.options.chart.custom.label = chart.renderer
                                .label('Total<br/><span style="font-size:20px;font-weight:700">' + totalBooks + '</span>')
                                .css({ color: 'var(--dark-light)', textAnchor: 'middle' })
                                .add();
                        }
                        const x = series.center[0] + chart.plotLeft;
                        const y = series.center[1] + chart.plotTop - (label.attr('height') / 2);
                        label.attr({ x, y });
                        label.css({ fontSize: `${series.center[2] / 12}px` });
                    }
                }
            },
            title: { text: null },
            subtitle: { text: null },
            credits: { enabled: false },
            tooltip: { enabled: false },
            legend: { enabled: false },
            exporting: { enabled: false },
            accessibility: { point: { valueSuffix: '%' } },
            plotOptions: {
                pie: { innerSize: '70%', dataLabels: { enabled: false } },
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    borderRadius: 8,
                    dataLabels: [
                        { enabled: true, distance: 20, format: '{point.name}' },
                        { enabled: true, distance: -15, format: '{point.percentage:.0f}%', style: { fontSize: '0.9em' } }
                    ],
                    showInLegend: true
                }
            },
            series: [{
                name: 'Books',
                colorByPoint: true,
                innerSize: '75%',
                data: bookLanguages.length ? bookLanguages : [{ name: 'No Data', y: 1 }]
            }]
        });

        // ── 2. Column: Books by Category & Language ──────────────────────────────
        Highcharts.chart('container-basic_column', {
            chart: { type: 'column', backgroundColor: 'transparent' },
            title: { text: null },
            subtitle: { text: null },
            exporting: { enabled: false },
            credits: { enabled: false },
            xAxis: {
                categories: chartCategories.length ? chartCategories : ['No Data'],
                crosshair: true,
                labels: { style: { color: 'var(--dark-light)' } }
            },
            yAxis: {
                min: 0,
                title: { text: null },
                gridLineColor: '#cccccc',
                gridLineWidth: 1,
                gridLineDashStyle: 'Solid',
                labels: { style: { color: 'var(--dark-light)' } }
            },
            tooltip: { enabled: true, shared: true },
            plotOptions: { column: { borderWidth: 0 } },
            series: chartSeries.length ? chartSeries : [{ name: 'No Data', data: [0] }],
            legend: {
                itemStyle: { color: 'var(--dark-light)', fontWeight: '600' },
                itemHoverStyle: { color: 'rgb(134,134,134)' },
                itemHiddenStyle: { color: '#4b5563' }
            }
        });

        // ── 3. Pie: Student Gender ────────────────────────────────────────────────
        Highcharts.chart('container-Egg_yolk', {
            chart: { type: 'pie', backgroundColor: 'transparent' },
            title: { text: null },
            subtitle: { text: null },
            tooltip: { enabled: true },
            exporting: { enabled: false },
            credits: { enabled: false },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [
                        { enabled: true, distance: 20, format: '{point.name}', style: { color: 'var(--dark-light)' } },
                        { enabled: true, distance: -40, format: '{point.y}', style: { fontSize: '1.2em', textOutline: 'none', opacity: 0.7 }, filter: { operator: '>', property: 'percentage', value: 10 } }
                    ]
                }
            },
            series: [{
                name: 'Students',
                colorByPoint: true,
                data: genderData.length ? genderData : [{ name: 'No Data', y: 1 }]
            }]
        });

        // ── 4. Spline: Attendance this week ───────────────────────────────────────
        Highcharts.chart('container-spline', {
            chart: { type: 'spline', backgroundColor: 'transparent' },
            title: { text: null },
            subtitle: { text: null },
            exporting: { enabled: false },
            credits: { enabled: false },
            xAxis: {
                categories: weekLabels,
                labels: { style: { color: 'var(--dark-light)' } }
            },
            yAxis: {
                title: { text: null },
                gridLineColor: '#cccccc',
                gridLineWidth: 1,
                gridLineDashStyle: 'Solid',
                labels: { style: { color: 'var(--dark-light)' } }
            },
            tooltip: { enabled: true, shared: true },
            plotOptions: {
                spline: { marker: { radius: 4, lineColor: '#666666', lineWidth: 1 } }
            },
            series: [
                { name: 'Students',  data: studentWeek },
                { name: 'Lecturers', data: lecturerWeek }
            ],
            legend: {
                itemStyle: { color: 'var(--dark-light)', fontWeight: '600' },
                itemHoverStyle: { color: 'rgb(134,134,134)' },
                itemHiddenStyle: { color: '#4b5563' }
            }
        });
    </script>

@endsection

@section('script_custom')
    <script>
        $(document).ready(function () {
            $('#topBooksTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                scrollCollapse: true,
                scrollY: '320px'
            });
        });
    </script>
@endsection
