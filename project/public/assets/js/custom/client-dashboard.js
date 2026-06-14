document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined' || typeof window.clientDashboardCharts === 'undefined') {
        return;
    }

    var charts = window.clientDashboardCharts;

    renderDonutChart('client_progress_distribution_chart', {
        labels: charts.progressDistribution.labels || [],
        series: charts.progressDistribution.series || [],
        colors: charts.progressDistribution.colors || [],
    });

    renderBarChart('client_module_coverage_chart', {
        labels: charts.moduleCoverage.labels || [],
        series: charts.moduleCoverage.series || [],
        color: charts.moduleCoverage.color || '#e76505',
    });

    renderLineChart('client_verification_activity_chart', {
        labels: charts.verificationActivity.labels || [],
        series: charts.verificationActivity.series || [],
        color: charts.verificationActivity.color || '#202124',
    });
});

function renderDonutChart(elementId, config) {
    var element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    var chart = new ApexCharts(element, {
        series: config.series,
        chart: {
            type: 'donut',
            height: 300,
            toolbar: {
                show: false
            }
        },
        labels: config.labels,
        colors: config.colors,
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            width: 0
        },
        responsive: [{
            breakpoint: 576,
            options: {
                chart: {
                    height: 260
                }
            }
        }]
    });

    chart.render();
}

function renderBarChart(elementId, config) {
    var element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    var chart = new ApexCharts(element, {
        series: [{
            name: 'Verified',
            data: config.series
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                horizontal: false,
                columnWidth: '48%'
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: [config.color],
        xaxis: {
            categories: config.labels
        },
        yaxis: {
            min: 0,
            forceNiceScale: true
        },
        grid: {
            borderColor: '#eff2f5'
        }
    });

    chart.render();
}

function renderLineChart(elementId, config) {
    var element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    var chart = new ApexCharts(element, {
        series: [{
            name: 'Verification Activity',
            data: config.series
        }],
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: [config.color],
        xaxis: {
            categories: config.labels
        },
        markers: {
            size: 5,
            strokeWidth: 0
        },
        grid: {
            borderColor: '#eff2f5'
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.2,
                opacityTo: 0.05,
                stops: [0, 100]
            }
        }
    });

    chart.render();
}
