<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Covid Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Covid Dashboard</h1>

    <h2>Indonesia ({{ $today_idn->date }})</h2>
<ul>
    <li>Positif: {{ number_format($today_idn->confirmed) }}</li>
    <li>Sembuh: {{ number_format($today_idn->recovered) }}</li>
    <li>Kematian: {{ number_format($today_idn->deaths) }}</li>
    <li>Aktif: {{ number_format($today_idn->active) }}</li>
    <li>Potensi: {{ number_format($potensi_idn, 2) }}%</li>
</ul>

<h2>Dunia ({{ $today_world->date }})</h2>
<ul>
    <li>Positif: {{ number_format($today_world->confirmed) }}</li>
    <li>Sembuh: {{ number_format($today_world->recovered) }}</li>
    <li>Kematian: {{ number_format($today_world->deaths) }}</li>
    <li>Aktif: {{ number_format($today_world->active) }}</li>
    <li>Potensi: {{ number_format($potensi_world, 2) }}%</li>
</ul>

<h2>Timeline Indonesia (H-30 hingga H-1)</h2>
<canvas id="timelineChartIDN"></canvas>

<h2>Timeline Dunia (H-30 hingga H-1)</h2>
<canvas id="timelineChartWorld"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxIDN = document.getElementById('timelineChartIDN').getContext('2d');
    const timelineChartIDN = new Chart(ctxIDN, {
        type: 'line',
        data: {
            labels: {!! json_encode($timeline_idn->pluck('date')) !!},
            datasets: [
                {
                    label: 'Positif',
                    data: {!! json_encode($timeline_idn->pluck('confirmed')) !!},
                    borderColor: 'orange',
                    fill: false
                },
                {
                    label: 'Sembuh',
                    data: {!! json_encode($timeline_idn->pluck('recovered')) !!},
                    borderColor: 'green',
                    fill: false
                },
                {
                    label: 'Kematian',
                    data: {!! json_encode($timeline_idn->pluck('deaths')) !!},
                    borderColor: 'red',
                    fill: false
                }
            ]
        }
    });

    const ctxWorld = document.getElementById('timelineChartWorld').getContext('2d');
    const timelineChartWorld = new Chart(ctxWorld, {
        type: 'line',
        data: {
            labels: {!! json_encode($timeline_world->pluck('date')) !!},
            datasets: [
                {
                    label: 'Positif',
                    data: {!! json_encode($timeline_world->pluck('confirmed')) !!},
                    borderColor: 'orange',
                    fill: false
                },
                {
                    label: 'Sembuh',
                    data: {!! json_encode($timeline_world->pluck('recovered')) !!},
                    borderColor: 'green',
                    fill: false
                },
                {
                    label: 'Kematian',
                    data: {!! json_encode($timeline_world->pluck('deaths')) !!},
                    borderColor: 'red',
                    fill: false
                }
            ]
        }
    });
</script>
</body>
</html>
