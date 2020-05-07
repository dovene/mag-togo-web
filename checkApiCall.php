<?php 
// response json
$json = array();
$result =array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */
 
if (isset($_GET['api_name'])) {
    $api_name = $_GET['api_name']; 
 
    $date_call = date('Y-m-d'); 
    

$qur = $db->prepare("select date_call, api_name from API_CALL_INFOS
                     where date_call=:date_call and api_name=:api_name");			
$qur->bindValue(':api_name', $api_name , PDO::PARAM_STR);
$qur->bindValue(':date_call', $date_call , PDO::PARAM_STR);
$qur->execute();
   
 
$nbint= (int) $qur->rowCount();  
if ($nbint<1){
$json = array("status" => 0,"message" => "Call inexistant", "info" => $qur);
}else{
$json = array("status" => 1,"message" => "Call déjà effectué", "info" => $qur);
}
 $db = null;  
} else {
    // required user details are not received 
    $json = array("status" => -2,"message" => "Opération impossible", "info" => $qur);
}
/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			