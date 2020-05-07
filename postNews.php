<?php
// response json
$json = array();
$result = array();
include_once 'pdo_db_config.php';
include 'apiCallHelperClass.php';
/**
 * Registering a user device
 * Store reg id in users table
 */

if (isset($_POST['title'])) {


    $nbClicks = rand(25, 50);
    $isMainNewsValue = ($nbClicks % 2 == 0)? "1" : "0"; // :) 


    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $content = isset($_POST['content']) ? $_POST['content'] : "";
    $category = isset($_POST['category']) ? $_POST['category'] : "";
    $image = isset($_POST['image']) ? $_POST['image'] : "";
    $publicationDate = isset($_POST['publicationDate']) ? $_POST['publicationDate'] : "";
    $source = isset($_POST['source']) ? $_POST['source'] : "";
    $sourceUrl = isset($_POST['sourceUrl']) ? $_POST['sourceUrl'] : "";
    $newsType = isset($_POST['newsType']) ? $_POST['newsType'] : "";
    $newsOrigin = isset($_POST['newsOrigin']) ? $_POST['newsOrigin'] : "";
    $imageOrigin = isset($_POST['imageOrigin']) ? $_POST['imageOrigin'] : "";
    $isVideoNews = isset($_POST['isVideoNews']) ? $_POST['isVideoNews'] : "";
    $isMainNews = isset($_POST['isMainNews']) ? $_POST['isMainNews'] :  $isMainNewsValue;
    $videoPath = isset($_POST['videoPath']) ? $_POST['videoPath'] : "";
    $nbClicksReadMore = isset($_POST['nbClicksReadMoredeoPath']) ? $_POST['nbClicksReadMore'] : "";
    $sendPush = isset($_POST['sendPush']) ? $_POST['sendPush'] : "0";


  /* if(strlen($sourceUrl)>1){
    $urlContent=file_get_contents($sourceUrl);
       if($urlContent!==false && !empty($urlContent) ){
        if(strlen($content)<strlen($urlContent)){
           $content = $content."\n --------------\n".$urlContent;   
        }
       }
   }*/
    $date = date('Y-m-d'); 
    
    //test if data already exist 
    $queryCheck = $db->prepare('select title from News where title like :title');
    $queryCheck->execute(array(':title' => $title));
    $affected_rowsCheck = $queryCheck->rowCount();    
    if ($affected_rowsCheck > 0) {
        $json = array("status" => 0, "message" => "Insertion échouée - existence de doublons", "info" => $result);

    }else{

         // Save data into database
    $query = $db->prepare("INSERT INTO News (title,content,category,publicationDate,image,source,sourceUrl,nbClicksReadMore,newsType,videoPath,isMainNews)
    VALUES (:title, :content, :category, :publicationDate, :image, :source, :sourceUrl, :nbClicksReadMore, :newsType, :videoPath, :isMainNews)");

$query->execute(array(':title' => $title, ':content' => $content, ':category' => $category,
':publicationDate' => $date, ':image' => $image, ':source' => $source,
':sourceUrl' => $sourceUrl, ':nbClicksReadMore' => $nbClicks, 
':newsType' => $newsType, ':videoPath' => $videoPath,
':isMainNews' => $isMainNews));
$affected_rows = $query->rowCount();
if ($affected_rows > 0) {
$json = array("status" => 1, "message" => "Insertion réussie", "info" => $result);



// update homedata
if ($isMainNewsValue =="1" ) {
    $method = "GET";
    $url = "http://dovene.coolpage.biz/updateNewsInHomeData.php?title=".urlencode($title)."";    
    $callSendNotification = new ApiCallHelper($method, $url, $data);
    $resSendNotification = $callSendNotification->callAPI();

 //lets update other items of home data
    $data = array("home" => "where-the-heart-is");
    $method = "POST";
    $url = "http://dovene.coolpage.biz/updateStoriesAlbumsInHomeData.php";    
    $call = new ApiCallHelper($method, $url, $data);
    $call->callAPI();
}

if ($newsType != "video" && $sendPush=="1" ) {
$method = "POST";
$data = array("message" => $title);
$url = "http://dovene.coolpage.biz/gcm_inline_caller.php";

$callSendNotification = new ApiCallHelper($method, $url, $data);
$resSendNotification = $callSendNotification->callAPI();

}

} else {
$json = array("status" => 0, "message" => "Insertion échouée", "info" => $result);

}
    }


   

    $db = null;
} else {
    // required param details are not received
    $json = array("status" => -2, "message" => "Impossible de faire l'insertion, param manquants", "info" => $result);
}
/* Output header */
header('Content-type: application/json');
echo json_encode($json);
