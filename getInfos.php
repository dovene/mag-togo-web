<?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select id, content, action, status, gcm_regid
                from INFOS
                Where status="1"
                order by id desc
                Limit 1');			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("content" =>$r->content,"status" =>$r->status,"gcm_regid" =>$r->gcm_regid,
			 "action" => $r->action,
			 'id' => $r->id); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃƒÂ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>		