<?php

// Include confi.php
include_once('db_config.php');

if($_SERVER['REQUEST_METHOD'] == "PUT" OR $_SERVER['REQUEST_METHOD'] == "POST" ){

if($_SERVER['REQUEST_METHOD'] == "PUT"){
	$uid = isset($_SERVER['HTTP_UID']) ? $_SERVER['HTTP_UID'] : "";
	$status = isset($_SERVER['HTTP_STATUS']) ? $_SERVER['HTTP_STATUS'] : "";
		}
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$uid = isset($_POST['id']) ? $_POST['id'] : "";
	$status = isset($_POST['status']) ? $_POST['status'] : "";
		}		
		
		
	// Add your validations
	if(!empty($uid)){
	$qur = $db->prepare('UPDATE  users SET  status =  :status WHERE  id = :id');			
		$qur->bindValue(':id', $uid, PDO::PARAM_INT);
		$qur->bindValue(':status', $status, PDO::PARAM_STR);
		$qur->execute();
		$affected_rows = $qur->rowCount();
		//$qur = mysql_query("UPDATE  users SET  status =  '$status' WHERE  id ='$uid';");
		if($affected_rows>0){
			$json = array("status" => 1, "msg" => "Status updated!!.");
		}else{
			$json = array("status" => 0, "msg" => "Error updating status");
		}
	}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
	$db=null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>