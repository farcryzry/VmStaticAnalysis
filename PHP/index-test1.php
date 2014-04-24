<?php
/**
 * Database connection details
 * Stored in a seperate file called db.php and included
 *
 * Fake example details for reference
 *
 * $db_host = 'localhost';
 * $db_database = 'bigcompanyinc';
 * $db_user = 'corporate_stooge';
 * $db_password = 'password1';
 */
//include('../../inc/db.php');
// $db = mysql_connect($db_host, $db_user, $db_password);
// mysql_select_db($db_database);

define("DB_SERVER", "127.0.0.1");
define("DB_USER", "group3");
define("DB_PASS", "sjsugroup3");
define("DB_NAME", "cmpe283");
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);


// Collect average CPU and Memory
$vmname='T03-VM02-Lin-Ling';

$data_array = getAverageForOneVm($connection,$vmname);


// Store graph data
$graphData =buildAvgArray($data_array);


/**
 * [getAveragePrices : Grabs data from db]
 */

function getAverageForOneVm ($connection, $vmname)
{
    $sqlAverageQuery = "SELECT  time, avg_cpu, avg_memory FROM avg_stats WHERE vm_name = '$vmname'";
    $sqlAverageResult = mysqli_query($connection,$sqlAverageQuery);
	if (!$sqlAverageResult) {
		die("Database query failed.....");
	}
	else echo "query success";

    while ($row = mysqli_fetch_array($sqlAverageResult)) {
        $averageResult[] = $row;
    }

    return $averageResult;
}

/**
 * [buildPriceArray : Formats data for api]
 */
function buildAvgArray($data_array)
{

    $output = "['Week', '%CPU', 'Memory (Mb)'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', ";
        $output .= $data_array[$i]['avg_cpu'] . ", ";
        $output .= $data_array[$i]['avg_memory'];     
        // On the final count do not add a comma
        if (!empty($data_array[$i+1]) ){
            $output .= "],\n";
        } else {
            $output .= "]\n";
        }
		$i++;
    };

    return $output;
}
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Google Graphs API</title>

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
            <h1>CPU and Memory of Virtual Machine</h1>
            <div id="chart"></div>
        </div>

    </div>
    <?php echo $graphData ?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                <?php echo $graphData ?>
            ]);

            var options = {
                title: 'Average CPU and Memory Usage',
                fontSize: 11,
                series: {
                    0:{color: 'red', visibleInLegend: true, pointSize: 3, lineWidth: 1},
                    1:{color: 'blue', visibleInLegend: true, pointSize: 5, lineWidth: 3}
                },
                hAxis: {title: 'Time', titleTextStyle:{color: '#03619D'}},
                vAxis: {title: 'CPU and Memory Usage', titleTextStyle:{color: '#03619D'}}
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart'));
            chart.draw(data, options);
        }
    </script>
</body>
</html>