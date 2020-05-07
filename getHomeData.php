<?php
	// Include confi.php
	include_once('db_config.php');
	$wsVersion=0;


  $qur = $db->prepare('select id, newsPicture, newsLabel, newsId, albumPicture, albumLabel, albumId,
  				historyPicture, historyLabel, historyId, musicPicture, musicLabel, musicID,
  				announcePicture, announcePictureBlob, announceLabel, announceId, newsType, videoPath
				from HOME_DATA
				where HOME_DATA.newsType <> "video"
                Limit 1
				');			
				

if (isset($_GET['wsversion']))
{
$wsVersion=$_GET['wsversion'];
if($wsVersion==2)
{
	$qur = $db->prepare("select id, newsPicture, newsLabel, newsId, albumPicture, albumLabel, albumId,
	historyPicture, historyLabel, historyId, musicPicture, musicLabel, musicID,
	announcePicture, announcePictureBlob, announceLabel, announceId, newsType, videoPath
	from HOME_DATA
  Limit 1
  ");	
}
}

		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array('newsPicture' =>$r->newsPicture, 'newsLabel' => $r->newsLabel, 'newsId' => $r->newsId,
			  'albumPicture' =>$r->albumPicture, 'albumLabel' => $r->albumLabel, 'albumId' => $r->albumId,
			  'historyPicture' =>$r->historyPicture, 'historyLabel' => $r->historyLabel, 'historyId' => $r->historyId,
			  'musicPicture' =>$r->musicPicture, 'musicLabel' => $r->musicLabel, 'musicID' => $r->musicID,

			  'announcePicture' => $r->announcePicture,'announcePictureBlob' => $r->announcePictureBlob,
			  'announceLabel' => $r->announceLabel, 'announceId' => $r->announceId,
			  'newsType' => $r->newsType, 'videoPath' => $r->videoPath  ); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃƒÂ©sultats

		if(count($result)<1){
			$result[] = array('aucunes donnees' =>"" ); 
		}
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
	
?>