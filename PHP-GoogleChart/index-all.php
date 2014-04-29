<?php require_once('db_connection.php');?>
<?php require_once('config.php');?>
<?php include ("cpu.php");?>
<?php include ("memory.php");?>
<?php include ("thread.php");?>
<?php include ("io.php");?>

<head>

    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
	<meta http-equiv="refresh" content="<?php echo $RefreshPageInterval; ?>" >

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
			
            <h1>Thread Usage of Virtual Machines </h1>
			<table>
			<tr><td height=200px width=500px >	
			<?php echo $vmip1 ?>
            <div id="Threadchart1"></div>
		    </td><td height=200px width=500px>		
			<?php echo $vmip2 ?>
			<div id="Threadchart2"></div>
		    </td>
			<tr>
		    </table>
			
            <h1>I/O Usage of Virtual Machines </h1>
			<table>
			<tr><td height=200px width=500px >	
			<?php echo $vmip1 ?>
            <div id="IOchart1"></div>
		    </td><td height=200px width=500px>		
			<?php echo $vmip2 ?>
			<div id="IOchart2"></div>
		    </td>
			<tr>
			<tr><td height=200px width=500px >	
			<?php echo $vmip1 ?>
            <div id="IORWchart1"></div>
		    </td><td height=200px width=500px>		
			<?php echo $vmip2 ?>
			<div id="IORWchart2"></div>
		    </td>
			<tr>
		    </table>
			
        </div>

    </div>
	
	
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawAllChart);
		function drawAllChart(){
			drawCPUChart();
			drawMemoryChart();
			drawThreadChart();
			drawIOChart();
			//setTimeout("drawAllChart()", 6000);
		}
		
        function drawCPUChart() {            	
			<?php
			$data_array1 = getCPUsForOneVm($connection,$vmip1,$QueryNumber);
			$data_array2 = getCPUsForOneVm($connection,$vmip2,$QueryNumber);
			// Store graph data
			$graphCPUData1 =buildCPUsArray($data_array1);
			$graphCPUData2 =buildCPUsArray($data_array2);
			?>
            var cpudata1 = google.visualization.arrayToDataTable([
                <?php echo $graphCPUData1 ?>
            ]);
            var cpudata2 = google.visualization.arrayToDataTable([
                <?php echo $graphCPUData2 ?>
            ]);
			
            var cpuoptions = {
                title: 'CPU Usage of Virtual Machine <?php echo $j?> ' ,
                fontSize: 11,
				curveType:'function',
                series: {
                    0:{color: 'red', visibleInLegend: true, pointSize: 3, lineWidth: 1}          
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'CPU Usage', titleTextStyle:{color: '#03619D'}}
            };
            var cpuchart1 = new google.visualization.ColumnChart(document.getElementById('CPUchart1'));
            cpuchart1.draw(cpudata1, cpuoptions);					
			var cpuchart2 = new google.visualization.ColumnChart(document.getElementById('CPUchart2'));
			cpuchart2.draw(cpudata2, cpuoptions);

			//setInterval("drawCPUChart()", 6000);
		}
		
		function drawMemoryChart() { 	
			<?php
			$data_array1 = getMemorysForOneVm($connection,$vmip1,$QueryNumber);
			$data_array2 = getMemorysForOneVm($connection,$vmip2,$QueryNumber);
			$graphMemoryData1 =buildMemorysArray($data_array1);
			$graphMemoryData2 =buildMemorysArray($data_array2);
			$graphMemoryRateData1 =buildMemoryRatesArray($data_array1);
			$graphMemoryRateData2 =buildMemoryRatesArray($data_array2);
			?>
            var memorydata1 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryData1 ?>
            ]);
            var memorydata2 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryData2 ?>
            ]);
            var memoryoptions = {
                title: 'Memory Usage of Virtual Machine' ,
                fontSize: 11,
                series: {
                    0:{color: 'purple', visibleInLegend: true, pointSize: 3, lineWidth: 1}, 
					1:{color: 'green', visibleInLegend: true, pointSize: 5, lineWidth: 3}          
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'Memory Usage', titleTextStyle:{color: '#03619D'}}
            };
			
            var memoryratedata1 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryRateData1 ?>
            ]);
            var memoryratedata2 = google.visualization.arrayToDataTable([
                <?php echo $graphMemoryRateData2 ?>
            ]);
            var memoryrateoptions = {
                title: 'Memory Rate of Virtual Machine' ,
                fontSize: 11,
                series: {
                    0:{color: 'blue', visibleInLegend: true, pointSize: 3, lineWidth: 1}         
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'Memory Rate', titleTextStyle:{color: '#03619D'}}
            };
			
            var memorychart1 = new google.visualization.AreaChart(document.getElementById('Memorychart1'));
            memorychart1.draw(memorydata1, memoryoptions);					
			var memorychart2 = new google.visualization.AreaChart(document.getElementById('Memorychart2'));
			memorychart2.draw(memorydata2, memoryoptions);			
            var memoryratechart1 = new google.visualization.LineChart(document.getElementById('MemoryRatechart1'));
            memoryratechart1.draw(memoryratedata1, memoryrateoptions);					
			var memoryratechart2 = new google.visualization.LineChart(document.getElementById('MemoryRatechart2'));
			memoryratechart2.draw(memoryratedata2, memoryrateoptions);
		}
		
		
		function drawThreadChart() { 	
			<?php
			$data_array1 = getThreadsForOneVm($connection,$vmip1,$QueryNumber);
			$data_array2 = getThreadsForOneVm($connection,$vmip2,$QueryNumber);
			$graphThreadData1 =buildThreadsArray($data_array1);
			$graphThreadData2 =buildThreadsArray($data_array2);
			?>
            var threaddata1 = google.visualization.arrayToDataTable([
                <?php echo $graphThreadData1 ?>
            ]);
            var threaddata2 = google.visualization.arrayToDataTable([
                <?php echo $graphThreadData2 ?>
            ]);
            var threadoptions = {
                title: 'Thread Usage of Virtual Machine' ,
                fontSize: 11,
                series: {
                    0:{color: 'red', visibleInLegend: true, pointSize: 1, lineWidth: 1}                   
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'Threads', titleTextStyle:{color: '#03619D'}}
            };			
            var threadchart1 = new google.visualization.LineChart(document.getElementById('Threadchart1'));
            threadchart1.draw(threaddata1, threadoptions);
            var threadchart2 = new google.visualization.LineChart(document.getElementById('Threadchart2'));
            threadchart2.draw(threaddata2, threadoptions);
		}
		
		function drawIOChart() { 
			<?php
			$data_array1 = getIOsForOneVm($connection,$vmip1,$QueryNumber);
			$data_array2 = getIOsForOneVm($connection,$vmip2,$QueryNumber);
			$graphIOData1 =buildIOsArray($data_array1);
			$graphIOData2 =buildIOsArray($data_array2);
			$graphIORWData1 =buildIORWsArray($data_array1);
			$graphIORWData2 =buildIORWsArray($data_array2);
			?>
            var iodata1 = google.visualization.arrayToDataTable([
                <?php echo $graphIOData1 ?>
            ]);
            var iodata2 = google.visualization.arrayToDataTable([
                <?php echo $graphIOData2 ?>
            ]);
            var iooptions = {
                title: 'I/O Transfer of Virtual Machine' ,
                fontSize: 11,
                series: {
                    0:{color: 'blue', visibleInLegend: true, pointSize: 3, lineWidth: 1}                   
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'I/O Transfer', titleTextStyle:{color: '#03619D'}}
            };
			
            var iorwdata1 = google.visualization.arrayToDataTable([
                <?php echo $graphIORWData1 ?>
            ]);
            var iorwdata2 = google.visualization.arrayToDataTable([
                <?php echo $graphIORWData2 ?>
            ]);

            var iorwoptions = {
                title: 'I/O read/write of Virtual Machine' ,
                fontSize: 11,
				isStacked: true,
                series: {
                    0:{color: 'green', visibleInLegend: true, pointSize: 3, lineWidth: 1},
                    1:{color: 'blue', visibleInLegend: true, pointSize: 5, lineWidth: 3}
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'I/O Usage', titleTextStyle:{color: '#03619D'}}
            };
			
            var iochart1 = new google.visualization.AreaChart(document.getElementById('IOchart1'));
            iochart1.draw(iodata1, iooptions);
            var iochart2 = new google.visualization.AreaChart(document.getElementById('IOchart2'));
            iochart2.draw(iodata2, iooptions);
            var iorwchart1 = new google.visualization.ColumnChart(document.getElementById('IORWchart1'));
            iorwchart1.draw(iorwdata1, iorwoptions);
            var iorwchart2 = new google.visualization.ColumnChart(document.getElementById('IORWchart2'));
            iorwchart2.draw(iorwdata1, iorwoptions);
		}
			
        
    </script>
	
	
</body>
</html>