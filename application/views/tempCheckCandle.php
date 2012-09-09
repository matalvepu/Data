<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Temperature Range
    </title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        var data = google.visualization.arrayToDataTable(
          
          <?php
        echo $array;
        ?>
        , true);

        var options = {
          legend:'none'
        };

        var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 1400px; height: 900px;"></div>
  </body>
</html>