<?php 
require_once('db_connection.php');
require_once('config.php');



/**
 * [getAveragePrices : Grabs data from db]
 */

function getMemorysForOneVm ($connection, $vmip,$QueryNumber)
{
    $sqlAverageQuery = "SELECT  time, rate,free,used FROM memory WHERE ip = '$vmip' Order By time DESC limit {$QueryNumber} ";
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