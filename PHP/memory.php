<?php require_once('db_connection.php');
// Collect average CPU and Memory
$vmip1='172.16.35.139';
$vmip2='172.16.35.139';
$data_array1 = getMemorysForOneVm($connection,$vmip1);
$data_array2 = getMemorysForOneVm($connection,$vmip2);


// Store graph data
$graphMemoryData1 =buildMemorysArray($data_array1);
$graphMemoryData2 =buildMemorysArray($data_array2);
$graphMemoryRateData1 =buildMemoryRatesArray($data_array1);
$graphMemoryRateData2 =buildMemoryRatesArray($data_array2);


/**
 * [getAveragePrices : Grabs data from db]
 */

function getMemorysForOneVm ($connection, $vmip)
{
    $sqlAverageQuery = "SELECT  time, rate,free,used FROM memory WHERE ip = '$vmip' Order By time limit 60 ";
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
 * [buildArray : Formats data for api]
 */
function buildMemorysArray($data_array)
{

    $output = "['Time', 'Free Memory(kb)', 'Used Memory(kb)'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', "; 
		$output .= $data_array[$i]['free'] . ", "; 
		$output .= $data_array[$i]['used'] . ", "; 
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

function buildMemoryRatesArray($data_array)
{

    $output = "['Time', '% Memory'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', ";
        $output .= $data_array[$i]['rate'] . ", ";  
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