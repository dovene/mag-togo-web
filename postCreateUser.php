<?php 
// response json
$json = array();
$result =array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */
 
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = $_POST['username']; 
  $password = $_POST['password']; 
  $email = $_POST['email']; 
$gcmid = $_POST['gcmid']; 
 
$qur = $db->prepare("select username from USERS where username=:username or email=:email");			
$qur->bindValue(':username', $username , PDO::PARAM_STR);
$qur->bindValue(':email', $email , PDO::PARAM_STR);
$qur->execute();
$rows = $qur->fetchAll(PDO::FETCH_ASSOC);
$count = (int) $qur->fetchColumn();
$nb=$qur->fetchColumn();      
 

$nbint= (int) $qur->rowCount();  

 
if ($nbint<1){
$stmt = $db->prepare("INSERT INTO USERS(username,password,email,gcm_regid) VALUES(:username,:password,:email,:gcmid)");
$stmt->execute(array(':username' => $username, ':password' => $password, ':email' => $email, ':gcmid' => $gcmid  ));
 
$affected_rows = $stmt->rowCount();

	if ($affected_rows>0) {
      $json = array("status" => 1,"message" => "Utilisateur crée avec suucès", "info" => $result);
	} else {
       $json = array("status" => 0,"message" => "Impossible de créer l'utilisateur, réessayer en modifiant vos données", "info" => $result);
	}
}else{
$json = array("status" => -1,"message" => "Changer le nom d'utilisateur et/ou l'émail", "info" => $result);
}
 $db = null;  
} else {
    // required user details are not received 
    $json = array("status" => -2,"message" => "Impossible de créer l'utilisateur", "info" => $result);
}
/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			