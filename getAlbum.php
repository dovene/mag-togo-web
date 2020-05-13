<?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select idAlbum, libAlbum, pathImage1 , pathImage2, pathImage3,
		pathImage4,pathImage5,pathImage6,pathImage7,pathImage8,pathImage9,pathImage10,pathImage11,
		pathImage12,pathImage13,pathImage14,pathImage15,pathImage16,pathImage17,pathImage18,
		pathImage19,pathImage20, status
                from Album
                where status ="1"
                order by idAlbum desc
				Limit 1');	
				
		if (isset($_GET['type']) && $_GET['type']=='all'){
			$qur = $db->prepare('select idAlbum, libAlbum, pathImage1 , pathImage2, pathImage3,
			pathImage4,pathImage5,pathImage6,pathImage7,pathImage8,pathImage9,pathImage10,pathImage11,
			pathImage12,pathImage13,pathImage14,pathImage15,pathImage16,pathImage17,pathImage18,
			pathImage19,pathImage20, status
					from Album
					order by idAlbum');	
		}
				
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("libAlbum" =>$r->libAlbum,
			 "pathImage1" => $r->pathImage1,
			 'pathImage2' => $r->pathImage2,
			'pathImage3' => $r->pathImage3, 
			 "pathImage4" => $r->pathImage4,
			 'pathImage5' => $r->pathImage5,
			'pathImage6' => $r->pathImage6, 
			 "pathImage7" => $r->pathImage7,
			 'pathImage8' => $r->pathImage8,
			'pathImage9' => $r->pathImage9, 
			 "pathImage10" => $r->pathImage10,
			 'pathImage11' => $r->pathImage11,
			'pathImage12' => $r->pathImage12, 
			 "pathImage13" => $r->pathImage13,
			 'pathImage14' => $r->pathImage14,
			'pathImage15' => $r->pathImage15, 
			 "pathImage16" => $r->pathImage16,
			 'pathImage17' => $r->pathImage17,
			'pathImage18' => $r->pathImage18, 
			 "pathImage19" => $r->pathImage19,
			 'pathImage20' => $r->pathImage20,
			  'idAlbum' => $r->idAlbum); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃƒÂ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>		