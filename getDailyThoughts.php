<?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select id, content 
                from DAILY_THOUGHTS');			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("content" => $r->content); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>