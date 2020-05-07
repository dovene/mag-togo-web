<?php
	// Include confi.php
	include_once('db_config.php');
	$wsVersion=0;	

if (isset($_GET['search'])){
 $search=$_GET['search'];
	   $qur = $db->prepare('select ANNOUNCEMENTS.id, content, tel, email, 
				ANNOUNCEMENTS.libCategory, username,colorCategory, status, 
				created_at, imageOnePath, imageTwoPath
                from ANNOUNCEMENTS, ANNOUNCEMENT_CATEGORY
                Where ANNOUNCEMENTS.libCategory=ANNOUNCEMENT_CATEGORY.libCategory
                and ANNOUNCEMENTS.content like :param
                order by id DESC
                Limit 30');		
  $qur->bindValue(':param', '%'.$search.'%', PDO::PARAM_STR);	
}
else
{
	   $qur = $db->prepare('select ANNOUNCEMENTS.id, content, tel, email, 
				ANNOUNCEMENTS.libCategory, username,colorCategory, status, 
				created_at, imageOnePath, imageTwoPath
                from ANNOUNCEMENTS, ANNOUNCEMENT_CATEGORY
                Where ANNOUNCEMENTS.libCategory=ANNOUNCEMENT_CATEGORY.libCategory
                order by id DESC
                Limit 30');		
        
}			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("tel" =>$r->tel, "content" => $r->content, 'email' => $r->email,
			  'libCategory' => $r->libCategory, 'username' => $r->username, 
                          'colorCategory' => $r->colorCategory,'idAnnouncement' => $r->id,
						   'status' => $r->status,'created_at' => $r->created_at,
						   'imageOnePath' => $r->imageOnePath,'imageTwoPath' => $r->imageTwoPath); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>