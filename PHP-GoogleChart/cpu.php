<?php 
require_once('db_connection.php');
require_once('config.php');
// Collect average CPU and Memory


 	

/**
 * [getAveragePrices : Grabs data from db]
 */

function getCPUsForOneVm ($connection, $vmip,$QueryNumber)
{
    $sqlAverageQuery = "SELECT  time, percent FROM cpu WHERE ip = '$vmip' Order By time DESC limit {$QueryNumber} ";
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
function buildCPUsArray($data_array)
{

    $output = "['Time', '%CPU'], ";
	$i=0;
    // The data needs to be in a format ['string', decimal, int]
   while (!empty($data_array[$i]) ){
        $output .= "['" . $data_array[$i]['time'] . "', ";
        $output .= $data_array[$i]['percent'] . ", ";  
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


