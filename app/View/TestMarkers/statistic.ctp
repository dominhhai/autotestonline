<h2><?php echo $testname.'統計'?></h2>
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript"><!--

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?php
						echo $data?> );
      data.setColumnLabel(0,"問題");
      data.setColumnLabel(1,"点");
      var options = {
    		  width: 900,
    		  height: 440,
              title: 'ヒストグラム',
              hAxis: {title: '点'},     
            };
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      
    }

    // TABLE
    google.load('visualization', '1', {packages:['table']});
    google.setOnLoadCallback(drawTable);
    function drawTable() {
      var data = new google.visualization.DataTable(<?php
						echo $data?>);
      data.setColumnLabel(0,"点");
      data.setColumnLabel(1,"人数");
    
                  
      var table = new google.visualization.Table(document.getElementById('table_div'));
      table.draw(data, {showRowNumber: false});
    }

    // TRENDS
    google.load('visualization', '1', {packages: ['corechart']});
	google.setOnLoadCallback(drawVisualization);

	function drawVisualization() 
	{
  		// Create and populate the data table.
  		var data = new google.visualization.DataTable();
 	 	data.addColumn('string', 'パーセント');
  		data.addColumn('number', '正しい回答');
  		data.addColumn({type: 'string', role: 'tooltip'});
  		data.addColumn('number', '正しくない回答');
  		data.addColumn({type: 'string', role: 'tooltip'});
  		data.addColumn('number', 'まだ回答しない');
  		data.addColumn({type: 'string', role: 'tooltip'});
  		<?php 
  		foreach ($questions as $key => $question):
  			$dung = 0;
  			$sai = 0;
  			$chua = 0;
  			foreach ($question['score'] as $k => $sco) {
  				if($sco != 0) $dung++;
  				else if($sco == 0 && $question['do'][$k] == 1) $sai++;
  				else $chua++;
  			}
  			$sum = count($question['score']);
  		?>
	  		data.addRows([
	    	['Q('+<?php echo $key ?>+')', <?php echo ($dung/$sum)*100?>, <?php echo ($dung/$sum)*100?>+'%', <?php echo ($sai/$sum)*100?>, <?php echo ($sai/$sum)*100?>+'%', <?php echo ($chua/$sum)*100?>, <?php echo ($chua/$sum)*100?>+'%']
	  		]);
  		<?php endforeach;?>
  		// Create and draw the visualization.
  		new google.visualization.ColumnChart(document.getElementById('visualization')).
  		draw(data,
       		{title:"点のトレンド",
        	isStacked: true,
        	'legend': 'bottom',
       		width:900, height:400,
        	vAxis: {title: "パーセント"},
        	hAxis: {title: "質問"}}
      	);
	}

    --></script>
</head>

<body>
<!--Div that will hold the pie chart-->
<div id="chart_div" ></div>
<div id="visualization"></div>
<h2>
<p align="center">グラフィカル
</h2>
<div id="table_div">
</div>
<div id="ranking_div">
<h2>
<p align="center">ランキング

</h2>

<table>
	<tr>
		<th>順番</th>
		<th>ユーザーID</th>
		<th>点</th>
	</tr>
	<?php
	$i = 0;
	foreach ( $score as $key => $value ) {
		$i ++;
		if ($i < 11) {
			echo '<tr><td>' . $i . '</td><td>' . $key . '</td><td>' . $value . '</td></tr>';
		}
	}
	?>
</table>
</div>
<div class="clear"></div>
<div id="average_div">
<?php
$j = 0;
$sum = 0;
foreach ( $score as $key => $value ) {
	$sum += $value;
	$j ++;
}
if($j > 0)$average = $sum / $j;
else $average = 0;
echo "<h2><p align='center'>平均点算出 : " . $average . '</h2>';
?>
</div>