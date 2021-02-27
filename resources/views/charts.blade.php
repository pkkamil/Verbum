<?php
    $active = 'profile';
    $title = 'Verbum - Testowanie';
    // $lazy = True;
?>

@extends('layouts.app')
@section('content')
<article class="charts" style="padding: 200px; display: flex;justify-content:center; align-items:center;">
    <div id="chart1" style="height: 300px; width: 500px"></div>
    <div id="chart2" style="height: 300px; width: 500px"></div>
    <div id="chart3" style="height: 300px; width: 500px"></div>
</article>
<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
<!-- Charts -->
<script>
    const chart1 = new Chartisan({
        el: '#chart1',
        url: "http://localhost:8000/charts/profile/1",
        hooks: new ChartisanHooks()
            .legend(false)
            .beginAtZero()
            .minimalist()
            .colors(['#c4c4c4'])
    });
    const chart2 = new Chartisan({
        el: '#chart2',
        url: "http://localhost:8000/charts/profile/2",
        hooks: new ChartisanHooks()
            .legend(false)
            .beginAtZero()
            .minimalist()
            .colors(['#c4c4c4'])
    });
    const chart3 = new Chartisan({
        el: '#chart3',
        url: "http://localhost:8000/charts/profile/3",
        hooks: new ChartisanHooks()
            .legend(false)
            .beginAtZero()
            .minimalist()
            .colors(['#c4c4c4'])
    });
  </script>
@endsection
