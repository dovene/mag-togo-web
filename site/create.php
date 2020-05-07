<?php
/* include db.config.php */
include_once('db_config.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
// Get post data`
$firstName = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$lastName = isset($_POST['lastname']) ? $_POST['lastname'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$status = 0; // Here we set by default status In-active.
// Save data into database
$query = $db->prepare("INSERT INTO users (firstname,lastname,email,password,status) 
                                  VALUES (:firstname, :lastname, :email, :password, :status)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));
$query->execute(array(':firstname' => $firstName, ':lastname' =>$lastName, ':email' => $email, ':password' => $password, ':status' => $status));

$affected_rows = $query->rowCount();

if($affected_rows>0){
$data = array("result" => 1, "message" => "Successfully user added!");
} else {
$data = array("result" => 0, "message" => "Error!");
}
} else {
$data = array("result" => 0, "message" => "Request method is wrong!");
}

$db=null;
/* JSON Response */
header('Content-type : application/json');
echo json_encode($data);
?>