// Chart Pie > Donut chart
Highcharts.chart('container-donut', {
    chart: {
        type: 'pie',
        // backgroundColor: 'var(--panel-color)',
        backgroundColor: 'transparent',
        // width: 360,
        // height: 260,
        spacing: [0, 0, 0, 0],
        custom: {},
        events: {
            render() {
                const chart = this,
                    series = chart.series[0];
                let customLabel = chart.options.chart.custom.label;

                if (!customLabel) {
                    customLabel = chart.options.chart.custom.label =
                        chart.renderer.label(
                            'Total<br/>' +
                            '<span style="font-size:20px;font-weight:700">2,230</span>'

                        )
                            .css({

                                color: 'var(--dark-light)',
                                textAnchor: 'middle',
                            })
                            .add();
                }

                const x = series.center[0] + chart.plotLeft,
                    y = series.center[1] + chart.plotTop -
                    (customLabel.attr('height') / 2);

                customLabel.attr({
                    x,
                    y
                });
                // Set font size based on chart diameter
                customLabel.css({
                    fontSize: `${series.center[2] / 12}px`
                });
            }
        }
    },

    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    title: {
        text: null
    },
    subtitle: {
        text: null
    },

    credits: {
        enabled: false
    },

    tooltip: {
        enabled: false // Hover False
    },
    legend: {
        enabled: false
    },
    exporting: {
        enabled: false
    },

    plotOptions: {

        pie: {
            innerSize: '70%',
            dataLabels: {
            enabled: false
        }
        },
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            borderRadius: 8,
            dataLabels: [{
                enabled: true,
                distance: 20,
                format: '{point.name}'
            }, {
                enabled: true,
                distance: -15,
                format: '{point.percentage:.0f}%',
                style: {
                    fontSize: '0.9em'
                }
            }],
            showInLegend: true
        }
    },
    series: [{
        name: 'Percentage of books',
        colorByPoint: true,
        innerSize: '75%',
        data: [{
            name: 'Khmer',
            y: 20.9
        }, {
            name: 'English',
            y: 12.6
        }]
    }]
});


