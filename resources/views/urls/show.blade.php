@extends('layouts.app')
@section('content')
  <div class="row">
    <div class="col s12">
      <ul class="card-panel collection with-header">
        <li class="collection-header">
          <h4>
            Stats for {{ url($url->short_url) }}
          </h4>
        </li>
        <li class="collection-item">Created {{  $url->created_at->format('M d, Y') }}</li>
        <li class="collection-item">
          Original URL: {{ $url->original_url }}
        </li>
      </ul>
    </div>
  </div>

  <div class="row">
    <div class="col s12">
      <div class="card-panel">
        <div id="total-clicks-chart"></div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col s6">
      <div class="card-panel">
        <div id="platforms-chart"></div>
      </div>
    </div>

    <div class="col s6">
      <div class="card-panel">
        <div id="browsers-chart"></div>
      </div>
    </div>
  </div>

  <script>
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawTotalClicksChart() {
      var data = google.visualization.arrayToDataTable([
        ['day', 'clicks'],
      ].concat(@json($daily_clicks)));

      var options = {
        title: 'Total clicks',
        haxis: {
          title: 'Day of month'
        },
        vaxis: {
          title: 'Clicks'
        }
      };

      var chart = new google.visualization.AreaChart(
        document.getElementById('total-clicks-chart')
      );
      chart.draw(data, options);
    }

    function drawBrowsersChart() {
      var data = google.visualization.arrayToDataTable([
        ['browser', 'clicks'],
      ].concat(@json($browsers_clicks)));

      var options = {
        title: 'Browsers'
      };

      var chart = new google.visualization.PieChart(
        document.getElementById('browsers-chart')
      );
      chart.draw(data, options);
    }

    function drawPlatformsChart() {
      var data = google.visualization.arrayToDataTable([
        ['platform', 'clicks'],
      ].concat(@json($platform_clicks)));

      var options = {
        title: 'Platform'
      };

      var chart = new google.visualization.PieChart(
        document.getElementById('platforms-chart')
      );
      chart.draw(data, options);
    }

    function drawCharts() {
      drawTotalClicksChart();
      drawBrowsersChart();
      drawPlatformsChart();
    }
  </script>
@endsection
