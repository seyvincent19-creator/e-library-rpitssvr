Highcharts.chart('container-basic_column', {
    chart: {
        type: 'column',
        backgroundColor: 'transparent',
    },
    title: {
        text: null
    },
    subtitle: {
        text: null
    },
    exporting: {
        enabled: false
    },
    xAxis: {
        categories: ['IT', 'ENG', 'BUS', 'ACC', 'ELE', 'Other'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        },
        labels: {
            style: {
            color: 'var(--dark-light)' }
        }
    },
    yAxis: {
        min: 0,
        max: 70,
        tickInterval: 10,
        title: {
            text: null
        },
        gridLineColor: '#cccccc',   // Border color
        gridLineWidth: 1,           // Border width
        gridLineDashStyle: 'Solid', // Solid | Dash | Dot | ShortDash | ShortDot
            labels: {
            style: {
            color: 'var(--dark-light)' }
        }


    },
    tooltip: {
        enabled: false // Hover False
    },
    credits: {
        enabled: false  // Hidden Link website HightCharts
    },
    plotOptions: {
        column: {
            // pointPadding: 0.2,
            borderWidth: 0
        },

    },
    series: [
        {
            name: 'English',
            color: 'blue',
                data: [46, 50, 35, 12, 18, 5]   // IT, ENG, BUS, ACC, ELE, Other
        },

        {
            name: 'Khmer',
            data: [54, 30, 60, 30, 20, 8]  // IT, ENG, BUS, ACC, ELE, Other
        }


    ],
    legend: {
        itemStyle: {
            color: 'var(--dark-light)',
            fontWeight: '600'
        },
            itemHoverStyle: {
            color: 'rgb(134, 134, 134)',
        },
            itemHiddenStyle: {
                color: '#4b5563'
        }
    }
});

