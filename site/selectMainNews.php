<?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select id, title, content, category, publicationDate, source, sourceUrl, image, 
                imgCategory from News, Category
                Where News.category=Category.libCategory
                And News.isMainNews="1"
                order by id DESC
                Limit 1');			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("title" =>$r->title, "content" => $r->content, 'source' => $r->source,
			  'sourceUrl' => $r->sourceUrl, 'category' => $r->category, 
                          'publicationDate' => $r->publicationDate,
			  'image' => $r->image,'imgCategory' => $r->imgCategory,'idNews' => $r->id); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>