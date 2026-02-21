Highcharts.chart('container-Egg_yolk', {
    chart: {
        type: 'pie',
          backgroundColor: 'transparent',
        panning: {
            enabled: true,
            type: 'xy'
        },
        panKey: 'shift'
    },
    title: {
        text: null
    },
    tooltip: {
        enabled: false // Hover False
    },
    subtitle: {
        text: null
    },
    exporting: {
        enabled: false
    },
    credits: {
        enabled: false  // Hidden Link website HightCharts
    },
    plotOptions: {
        pie: {

            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: [{
                enabled: true,
                distance: 20,
                format: '{point.name}',
                style: {
                    // fontSize: '0.8em',
                    color: 'var(--dark-light)'
                },
            }, {
                enabled: true,
                distance: -40,
                 format: '{point.y}',   // 👈 បង្ហាញជាចំនួន
                //format: '{point.percentage:.1f}%', // ចំនួនគិតភាគរយ
                style: {
                    fontSize: '1.2em',
                    textOutline: 'none',
                    opacity: 0.7
                },
                filter: {
                    operator: '>',
                    property: 'percentage',
                    value: 10
                }
            }]
        }
    },
    series: [
        {
            name: 'Percentage',
            colorByPoint: true,
            data: [
                { name: 'និស្សិតស្រី', y: 56 },
                { name: 'សរុបនិស្សិត', y: 120}

            ],


        }
    ]
});

