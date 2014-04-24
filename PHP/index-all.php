<?php include ("cpu.php");?>
<?php include ("memory.php");?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>CMPE283Lab3</title>

    <meta name="viewport" content="width=device-width">

    <style type="text/css">
        #chart {
            height: 400px;
            width: 100%;
        }
        #siteWrapper {
            padding: 2em;
        }
        h1 {
            font: bold 2em/1.5 sans-serif;
        }
    </style>

</head>

<body>

    <div id="siteWrapper">

        <div class="container">
            <h1>CPU Usage of Virtual Machines </h1>
			<table>
			<tr><td height=200px width=500px >	
			<?php echo $vmip1 ?>
            <div id="CPUchart1"></div>
		    </td><td height=200px width=500px>		
			<?php echo $vmip2 ?>
			<div id="CPUchart2"></div>
		    </td>
			<tr>
		    </table>
			
            <h1>Memory Usage of Virtual Machines </h1>
			<table>
			<tr><td height=200px width=500px >	
			<?php echo $vmip1 ?>
            <div id="Memorychart1"></div>
		    </td><td height=200px width=500px>		
			<?php echo $vmip2 ?>
			<div id="Memorychart2"></div>
		    </td>
			<tr>
			<tr><td height=200px width=500px >	
			<?php echo $vmip1 ?>
            <div id="MemoryRatechart1"></div>
		    </td><td height=200px width=500px>		
			<?php echo $vmip2 ?>
			<div id="MemoryRatechart2"></div>
		    </td>
			<tr>
		    </table>
			
        </div>

    </div>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var cpudata1 = google.visualization.arrayToDataTable([
                <?php echo $graphCPUData1 ?>
            ]);
            var cpudata2 = google.visualization.arrayToDataTable([
                <?php echo $graphCPUData2 ?>
            ]);
			
            var memorydata1 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryData1 ?>
            ]);
            var memorydata2 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryData2 ?>
            ]);
            var memoryratedata1 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryRateData1 ?>
            ]);
            var memoryratedata2 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryRateData2 ?>
            ]);

            var options = {
                title: 'Usage of Virtual Machine' ,
                fontSize: 11,
                series: {
                    0:{color: 'red', visibleInLegend: true, pointSize: 3, lineWidth: 1},
                    1:{color: 'blue', visibleInLegend: true, pointSize: 5, lineWidth: 3}
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'Usage', titleTextStyle:{color: '#03619D'}}
            };

            var cpuchart1 = new google.visualization.LineChart(document.getElementById('CPUchart1'));
            cpuchart1.draw(cpudata1, options);
					
			var cpuchart2 = new google.visualization.AreaChart(document.getElementById('CPUchart2'));
			cpuchart2.draw(cpudata2, options);
			
            var memorychart1 = new google.visualization.LineChart(document.getElementById('Memorychart1'));
            memorychart1.draw(memorydata1, options);
					
			var memorychart2 = new google.visualization.AreaChart(document.getElementById('Memorychart2'));
			memorychart2.draw(memorydata2, options);
			
            var memoryratechart1 = new google.visualization.LineChart(document.getElementById('MemoryRatechart1'));
            memoryratechart1.draw(memoryratedata1, options);
					
			var memoryratechart2 = new google.visualization.AreaChart(document.getElementById('MemoryRatechart2'));
			memoryratechart2.draw(memoryratedata2, options);
			
        }
    </script>
	
	
</body>
</html>