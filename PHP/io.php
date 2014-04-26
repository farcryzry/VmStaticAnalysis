<?php 
require_once('db_connection.php');
require_once('config.php');


/**
 * [getAveragePrices : Grabs data from db]
 */

function getIOsForOneVm ($connection, $vmip, $QueryNumber)
{
    $sqlAverageQuery = "SELECT  time, tps, readps, writeps FROM io WHERE ip = '$vmip' Order By time DESC limit {$QueryNumber} ";
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
function buildIOsArray($data_array)
{

    $output = "['Time', 'Transfer/Second'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', ";
        $output .= $data_array[$i]['tps'] . ", ";  
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

function buildIORWsArray($data_array)
{

    $output = "['Time', 'Read(kb/s)', 'Write(kb/s)'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', ";
        $output .= $data_array[$i]['readps'] . ", ";  
		$output .= $data_array[$i]['writeps'] . ", "; 
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


