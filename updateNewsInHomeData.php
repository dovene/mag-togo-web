<?php
	// Include confi.php
    include_once('db_config.php');
    

if(isset($_GET['id']) || isset($_GET['title'])) {
$id = $_GET['id'];
$title = $_GET['title'];
$param = 1;
 

if($id!=0){
    $qur = $db->prepare("select id, title, content, category, publicationDate, source, sourceUrl,
    image, imgCategory, nbClicksReadMore, newsType, videoPath
    from News, Category
  Where News.category=Category.libCategory
  And News.id = :id
  Limit 1
  ");	
  $qur->bindValue(':id', $id, PDO::PARAM_STR);	


}else{
    $title = urldecode($title);
    $qur = $db->prepare("select id, title, content, category, publicationDate, source, sourceUrl,
    image, imgCategory, nbClicksReadMore, newsType, videoPath
    from News, Category
  Where News.category=Category.libCategory
  And News.title = :title
  Limit 1
  ");	
  $qur->bindValue(':title', $title, PDO::PARAM_STR);	

}
 
 
		
  $qur->execute();
  while($r = $qur->fetch(PDO::FETCH_OBJ)){
 
			//extract($r);
               $id=$r->id;
            $title=$r->title;
            $newsType=$r->newsType;
            $videoPath=$r->videoPath;
			$image='';
			if (($r->image=='') || (strlen($r->image)==0)){
			$image=$r->imgCategory;
			}else{
			$image=$r->image;
			}
 
$stmt1 = $db->prepare("UPDATE HOME_DATA SET newsPicture=:picture, newsLabel=:label, 
newsId=:newsId, newsType=:newsType, videoPath=:videoPath ");
$stmt1->bindValue(':picture', $image, PDO::PARAM_STR);
$stmt1->bindValue(':label', $title, PDO::PARAM_STR);
$stmt1->bindValue(':newsId', $id, PDO::PARAM_INT);
$stmt1->bindValue(':newsType', $newsType, PDO::PARAM_STR);
$stmt1->bindValue(':videoPath', $videoPath, PDO::PARAM_STR);
$stmt1->execute();
	}
 
 
 
$stmt = $db->prepare("UPDATE News SET isMainNews=:param WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();
 
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
    $json = array("status" => 1, "info" => "Succes");
 
} else {
    $json = array("status" => 0, "info" => "Echec");
} 

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
}

?>