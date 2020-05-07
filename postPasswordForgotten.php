<?php 
// response json
$json = array();
$result =array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */
 
if (isset($_POST['username']) or  isset($_POST['email'])) {
    $username = $_POST['username']; 
  $email = $_POST['email']; 

 
$qur = $db->prepare("select username, password, email, status from USERS where username=:username or email=:email");			
$qur->bindValue(':username', $username , PDO::PARAM_STR);
$qur->bindValue(':email', $email , PDO::PARAM_STR);
$qur->execute();

 
$nbint= (int) $qur->rowCount();  
if ($nbint<1){
$json = array("status" => -1,"message" => "Opération refusée, Paramètres de connexion non reconnues", "info" => $result);
}else{

while($r = $qur->fetch(PDO::FETCH_OBJ)){
$result[] = array("password" =>$r->password, "status" =>$r->status);
}
$qur->closeCursor(); 
$json = array("status" => 1,"message" => "ok", "info" => $result);
}
 $db = null;  
} else {
    // required user details are not received 
    $json = array("status" => -2,"message" => "Opération impossible", "info" => $result);
}
/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			