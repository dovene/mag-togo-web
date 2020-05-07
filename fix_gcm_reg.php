<?php 
// response json
$json = array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */

if (isset($_POST['regId'])) {
    $gcm_regid = $_POST['regId']; 
    $deviceId = $_POST['deviceId']; 

$qur = $db->prepare("select gcm_regid from gcm_users where gcm_regid=:regid");			
$qur->bindValue(':regid', $gcm_regid , PDO::PARAM_STR);
$qur->execute();
$rows = $qur->fetchAll(PDO::FETCH_ASSOC);
$count = (int) $qur->fetchColumn();
$nb=$qur->fetchColumn();      

echo $qur->rowCount();
$nbint= (int) $qur->rowCount();  
echo "$nbint";

if ($nbint<1){
      
$stmt = $db->prepare("INSERT INTO gcm_users(gcm_regid,created_at) VALUES(:id,NOW())");
$stmt->execute(array(':id' => $gcm_regid));

$affected_rows = $stmt->rowCount();
echo "$affected_rows";
	if ($affected_rows>0) {
    echo "New record created successfully";
	} else {
    echo "Error: " ; //. $query . "<br>" . $db->error;
	}
 
}else{
$stmt = $db->prepare("UPDATE gcm_users SET deviceId= :paramDeviceId where gcm_regid= :paramId");
$stmt->execute(array(':paramId' => $gcm_regid, ':paramDeviceId' => $deviceId));

}
      

 
 $db = null;  
        
   
} else {
    // required user details are not received 
echo "not received";
}
?>			