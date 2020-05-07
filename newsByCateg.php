<?php
	// Include confi.php
	include_once('db_config.php');
	
	
if (isset($_GET['category']))
{
 $category=$_GET['category'];
  $qur = $db->prepare("select id, title, content, category, publicationDate, source, sourceUrl, image from
   News WHERE category=:category order by id DESC");			
  $qur->bindValue(':category', $category, PDO::PARAM_STR);	
}
else
{
   	$qur = $db->prepare('select id, title, content, category, publicationDate, source, sourceUrl, image from News order by publicationDate ASC');			
	
}
	
	
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("title" =>$r->title, "content" => $r->content, 'source' => $r->source,
			  'sourceUrl' => $r->sourceUrl, 'category' => $r->category, 
                          'publicationDate' => $r->publicationDate,
			  'image' => $r->image,'idNews' => $r->id); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>