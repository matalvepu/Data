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
          title: '<?php echo $title;?>',
          vAxis: {
              title: "<?php echo $yAxistitle;?>",
              maxValue: 8
            },
            hAxis:  
                {
                    maxValue : 2020
                }

        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 600px; height: 400px;"></div>
  </body>
</html>