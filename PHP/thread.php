<?php require_once('db_connection.php');
// Collect average CPU and Memory
$vmip1='172.16.35.139';
$vmip2='172.16.35.139';
$data_array1 = getThreadsForOneVm($connection,$vmip1);
$data_array2 = getThreadsForOneVm($connection,$vmip2);


// Store graph data
$graphThreadData1 =buildThreadsArray($data_array1);
$graphThreadData2 =buildThreadsArray($data_array2);


/**
 * [getAveragePrices : Grabs data from db]
 */

function getThreadsForOneVm ($connection, $vmip)
{
    $sqlAverageQuery = "SELECT  time, total FROM thread WHERE ip = '$vmip' Order By time limit 60 ";
    $sqlAverageResult = mysqli_query($connection,$sqlAverageQuery);
	if (!$sqlAverageResult) {
		die("Database query failed.....");
	}
	//else echo "query success";

    while ($row = mysqli_fetch_array($sqlAverageResult)) {
        $averageResult[] = $row;
    }

    return $averageResult;
}

/**
 * [buildPriceArray : Formats data for api]
 */
function buildThreadsArray($data_array)
{

    $output = "['Time', 'Total Threads'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', ";
        $output .= $data_array[$i]['total'] . ", ";  
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


