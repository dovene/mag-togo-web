<?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select id, title, contentPage1, contentPage2, contentPage3
                from History
                where status ="1"
                order by id DESC
                Limit 1');			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("title" =>$r->title, "contentPage1" => $r->contentPage1,
			 'contentPage2' => $r->contentPage2,
			  'contentPage3' => $r->contentPage3, 
			  'idNews' => $r->id); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>	