<?php
	// Include confi.php
	include_once('db_config.php');

   	$qur = $db->prepare('select libCategory, colorCategory
                from ANNOUNCEMENT_CATEGORY
                order by libCategory DESC');		
                	
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("libCategory" =>$r->libCategory, "colorCategory" => $r->colorCategory); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>