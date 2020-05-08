<?php
	// Include confi.php
    include_once('db_config.php');
include 'apiCallHelperClass.php';

$reqStatus=0;



//if(isset($_POST['home'])) {
    
// Story
    $qurStory = $db->prepare('select id, title,  image, contentPage1, contentPage2, contentPage3
    from History');			
$qurStory->execute();
$resCount= $qurStory->rowCount();
$chosen = rand(0,$resCount);
$resultAlbum =array();
$counter=0;
while($r = $qurStory->fetch(PDO::FETCH_OBJ)){
if($chosen==$counter){
    $reqStatus=1;
    $id=$r->id;
    $title=$r->title;
    $image=$r->image;

    $stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET historyPicture=:picture, historyLabel=:label, historyId=:id");
    $stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
    $stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
    $stUpdateHomeData->bindValue(':id', $id, PDO::PARAM_INT);
    $stUpdateHomeData->execute();
//update history
 $param = 1;
$paramAll = 0;
$stUpdateAll = $db->prepare("UPDATE History SET status=:paramAll");
$stUpdateAll->bindValue(':paramAll', $paramAll, PDO::PARAM_STR);
$stUpdateAll->execute();
$stmt = $db->prepare("UPDATE History SET status=:param WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();

// send notification
$messageStory = "Du nouveau dans votre rubrique histoire : ".$title;
$method="POST";
$dataStory=array("message" => $messageStory);
$url=$GCM_URL;
$callNotificationStory = new ApiCallHelper($method, $url, $dataStory);
//$callNotificationStory->callAPI();

}
//echo "counter :".$counter." chosen ".$chosen. " total from fetchCol ".$resCount;
$counter++;
}
$qurStory->closeCursor();

// Album
$qurAlbum = $db->prepare('select idAlbum, libAlbum, pathImage1, status from Album');			
					
$qurAlbum->execute();
$resCountAlbum= $qurAlbum->rowCount();

$chosenAlbum = rand(0,$resCountAlbum);
$counterAlbum=0;
while($r = $qurAlbum->fetch(PDO::FETCH_OBJ)){
if($chosenAlbum==$counterAlbum){
$reqStatus=1;
$id=$r->idAlbum;
$title=$r->libAlbum;
$image=$r->pathImage1;

			
$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET albumPicture=:picture, albumLabel=:label, albumId=:albumId");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':albumId', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();

//update album
$param = 1;
$paramAll = 0;
$stUpdateAll = $db->prepare("UPDATE Album SET status=:paramAll");
$stUpdateAll->bindValue(':paramAll', $paramAll, PDO::PARAM_STR);
$stUpdateAll->execute(); 
$stmt = $db->prepare("UPDATE Album SET status=:param WHERE idAlbum=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();

//send notif
 
$messageNotification = "Ne manquez pas votre album du moment, tout en images : ".$title;
$method = "POST";
$data = array("message" => $messageNotification);
$url = $GCM_URL;
$callNotification = new ApiCallHelper($method, $url, $data);
//$callNotification->callAPI();


}
//echo "counterAlbum :".$counterAlbum." chosenAlbum ".$chosenAlbum. " total from fetchColAlbum ".$resCountAlbum;
$counterAlbum++;
}
$qurAlbum->closeCursor();

 

// Video
$qurVideo = $db->prepare("select id, title, videoId from VideoList");			
					
$qurVideo->execute();
$resCount= $qurVideo->rowCount();
$chosen = rand(0,$resCount);
$counter=0;
while($r = $qurVideo->fetch(PDO::FETCH_OBJ)){
if($chosen==$counter){
$reqStatus=1;
$id=$r->id;
$title=$r->title;
$image=$r->videoId;

// homdedata			

$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET musicPicture=:picture, musicLabel=:label, musicId=:musicId");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':musicId', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();

}
//echo "counter :".$counter." chosen ".$chosen. " total from fetchCol ".$resCount;
$counter++;
}
$qurVideo->closeCursor();



// Announces
$qurAnnounces = $db->prepare("select id, content, tel, email, status, created_at, 
username, libCategory, imageOne 
from ANNOUNCEMENTS");
$qurAnnounces->execute();
$resCount= $qurAnnounces->rowCount();
$chosen = rand(0,$resCount);
$counter=0;
while($r = $qurAnnounces->fetch(PDO::FETCH_OBJ)){
if($chosen==$counter){
$reqStatus=1;
$id=$r->id;
$title=$r->content;
$image=$r->libCategory;

// homdedata			

$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET announcePicture=:picture, announceLabel=:label, announceId=:id");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':id', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();

}
//echo "counter :".$counter." chosen ".$chosen. " total from fetchCol ".$resCount;
$counter++;
}
$qurAnnounces->closeCursor();


$affected_rows = $reqStatus;
if($affected_rows>0){
    $json = array("status" => 1, "info" => "Succes");
 
} else {
    $json = array("status" => 0, "info" => "Echec");
} 

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
//}

?>