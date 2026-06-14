document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined' || typeof window.adminDashboardCharts === 'undefined') {
        return;
    }

    var charts = window.adminDashboardCharts;

    renderAdminDonutChart('admin_role_distribution_chart', {
        labels: charts.roleDistribution.labels || [],
        series: charts.roleDistribution.series || [],
        colors: charts.roleDistribution.colors || [],
    });

    renderAdminDonutChart('admin_verification_status_chart', {
        labels: charts.verificationStatuses.labels || [],
        series: charts.verificationStatuses.series || [],
        colors: charts.verificationStatuses.colors || [],
    });

    renderAdminActivityChart('admin_platform_activity_chart', {
        labels: charts.platformActivity.labels || [],
        registrationSeries: charts.platformActivity.registration_series || [],
        loginSeries: charts.platformActivity.login_series || [],
        registrationColor: charts.platformActivity.registration_color || '#e76505',
        loginColor: charts.platformActivity.login_color || '#202124',
    });
});

function renderAdminDonutChart(elementId, config) {
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
        stroke: {
            width: 0
        },
        dataLabels: {
            enabled: true
        }
    });

    chart.render();
}

function renderAdminActivityChart(elementId, config) {
    var element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    var chart = new ApexCharts(element, {
        series: [
            {
                name: 'New Users',
                data: config.registrationSeries
            },
            {
                name: 'Logins',
                data: config.loginSeries
            }
        ],
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            }
        },
        stroke: {
            curve: 'smooth',
            width: [3, 3]
        },
        colors: [config.registrationColor, config.loginColor],
        xaxis: {
            categories: config.labels
        },
        markers: {
            size: 4,
            strokeWidth: 0
        },
        grid: {
            borderColor: '#eff2f5'
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top'
        }
    });

    chart.render();
}
