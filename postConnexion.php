<?php 
// response json
$json = array();
$result =array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */
 
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username']; 
  $password = $_POST['password']; 

 
$qur = $db->prepare("select username, password, email from USERS where username=:username and password=:password");			
$qur->bindValue(':username', $username , PDO::PARAM_STR);
$qur->bindValue(':password', $password , PDO::PARAM_STR);
$qur->execute();
   
 
$nbint= (int) $qur->rowCount();  
if ($nbint<1){
$json = array("status" => -1,"message" => "Connexion refusée, Paramètres de connexion non reconnues", "info" => $result);
}else{
while($r = $qur->fetch(PDO::FETCH_OBJ)){
$result[] = array("email" =>$r->email);
}
$qur->closeCursor(); 
$json = array("status" => 1,"message" => "ok", "info" => $result);
}
 $db = null;  
} else {
    // required user details are not received 
    $json = array("status" => -2,"message" => "Connexion impossible", "info" => $result);
}
/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			