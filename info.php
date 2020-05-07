<?php
	// Include confi.php
	include_once('db_config.php');
	$uid = isset($_GET['uid']) ? $_GET['uid'] :  "";
	if(!empty($uid)){
		$qur = $db->prepare('select lastname, email, status from users where id = :id');			
		$qur->bindValue(':id', $uid, PDO::PARAM_INT);
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("lastname" =>$r->lastname, "email" => $r->email, 'status' => $r->status); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
	$db = null;
	/*$uid = isset($_GET['uid']) ? mysql_real_escape_string($_GET['uid']) :  "";
	if(!empty($uid)){
		$qur = mysql_query("select lastname, email, status from users where id=$uid");
		if($qur == FALSE) { 
 		   die(mysql_error()); // TODO: better error handling
		}
		$result =array();
		while($r = mysql_fetch_array($qur)){
			extract($r);
			$result[] = array("lastname" => $lastname, "email" => $email, 'status' => $status); 
		}
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
	@mysql_close($conn);*/

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>