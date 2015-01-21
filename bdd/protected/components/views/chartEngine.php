<style type='text/css'>
  .text-left {
      text-align:left;
  }
</style>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">

    // Load the Visualization API and the piechart package.
      google.load('visualization', '1', {packages: ['corechart','table']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawTable);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create our data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Basis of Record');
        data.addColumn('number', 'Specimens');
        data.addRows([
            ['Preseverd Specimen', 11],
            ['Observation', 2],
        ]);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 300, legend:'none', height: 150, is3D: false});

        // Instantiate and draw our chart, passing in some options.
        var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart2.draw(data, {width: 150, legend:'none', height: 200, is3D: false});
  }

  function drawTable() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Resource');
  data.addColumn('number', 'Number');
  data.addColumn('boolean', 'Full Time');
  data.addRows(4);
  data.setCell(0, 0, 'Georeferenced');
  data.setCell(0, 1, 10000, '$10,000');
  data.setCell(0, 2, true);
  data.setCell(1, 0, 'Media');
  data.setCell(1, 1, 25000, '$25,000');
  data.setCell(1, 2, true);
  data.setCell(2, 0, 'References');
  data.setCell(2, 1, 8000, '$8,000');
  data.setCell(2, 2, false);
  data.setCell(3, 0, 'Interaction');
  data.setCell(3, 1, 20000, '$20,000');
  data.setCell(3, 2, true);

  var table = new google.visualization.Table(document.getElementById('table_div'));
  table.draw(data);


}


</script>

<!--Div that will hold the pie chart-->

<table cellpadding="0" cellspacing="10" align="center">
    <tr>
        <td><div id="table_div"></div></td>
    </tr>
</table>

