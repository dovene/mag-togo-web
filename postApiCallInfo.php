<?php 
// response json
$json = array();
$result =array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */
 
if (isset($_POST['api_name'])) {
$api_name = $_POST['api_name']; 
$date = date('Y-m-d'); 
$stmt = $db->prepare("INSERT INTO API_CALL_INFOS(date_call,api_name) VALUES(:date_call,:api_name)");
$stmt->execute(array(':date_call' => $date, ':api_name' => $api_name));
 
$affected_rows = $stmt->rowCount();

	if ($affected_rows>0) {
      $json = array("status" => 1,"message" => "Insertion réussie", "info" => $result);
	} else {
       $json = array("status" => 0,"message" => "Insertion échouée", "info" => $result);
	}

 $db = null;  
} else {
    // required param details are not received 
    $json = array("status" => -2,"message" => "Impossible de faire l'insertion, param manquants", "info" => $result);
}
/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			