<?php
	// Include confi.php
	include_once('db_config.php');
	
	
		$qur = $db->prepare('select id, title, videoId from VideoList order by id desc');			
		$qur->execute();
		$result =array();
		
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("title" =>$r->title, "videoId" => $r->videoId, "id" => $r->id); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃƒÂ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>