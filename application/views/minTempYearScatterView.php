<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(
           <?php
        echo $array;
        ?>);

        var options = {
          title: 'Date vs. Mintemp comparison 1953 - Dhaka',
          hAxis: {title: 'Date', minValue: 0, maxValue: 366},
          vAxis: {title: 'Mintemp', minValue: 0, maxValue: 30},
          legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 1500px; height: 1200px;"></div>
  </body>
</html>