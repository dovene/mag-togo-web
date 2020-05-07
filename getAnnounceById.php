<?php
	// Include confi.php
	include_once('db_config.php');
	
if (isset($_GET['id'])){
 $id=$_GET['id'];
	   $qur = $db->prepare('select ANNOUNCEMENTS.id, content, tel, email, ANNOUNCEMENTS.libCategory, 
				username,colorCategory, status, created_at, imageOne, imageTwo,
				 imageOnePath, imageTwoPath
                from ANNOUNCEMENTS, ANNOUNCEMENT_CATEGORY
                Where ANNOUNCEMENTS.libCategory=ANNOUNCEMENT_CATEGORY.libCategory
                and ANNOUNCEMENTS.id = :param
                order by id DESC
                Limit 30');		
  $qur->bindValue(':param', $id, PDO::PARAM_INT);	



			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("tel" =>$r->tel, "content" => $r->content, 'email' => $r->email,
			  'libCategory' => $r->libCategory, 'username' => $r->username, 
                          'colorCategory' => $r->colorCategory,'idAnnouncement' => $r->id,
                           'status' => $r->status,'created_at' => $r->created_at,
						  'imageOne' => $r-> imageOne,'imageTwo' => $r-> imageTwo,
						  'imageOnePath' => $r->imageOnePath,'imageTwoPath' => $r->imageTwoPath); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	}
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>