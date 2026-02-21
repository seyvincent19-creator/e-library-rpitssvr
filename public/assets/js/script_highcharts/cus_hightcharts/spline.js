// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
Highcharts.chart('container-spline', {
    chart: {
        type: 'spline',
        backgroundColor: 'transparent',

    },
    title: {
        text: null
    },
    subtitle: {
        text: null
    },
    xAxis: {
        categories: [
            'Mon', 'Tue', 'Wed', 'Thu', 'Fir', 'Sat', 'Sun'
        ],
        accessibility: {
            description: 'Day of the Month'
        },
        labels: {
            style: {
            color: 'var(--dark-light)' }
        }
    },
    yAxis: {
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
    exporting: {
        enabled: false
    },
    credits: {
        enabled: false  // Hidden Link website HightCharts
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Students',
         data: [
        15, 28, 25 , 20, 32, 28, 20,

    ]

    }, {
        name: 'Lecturers',

           data: [

        2, 15, 8, 12, 20, 10, 5,

    ]
    }],
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

