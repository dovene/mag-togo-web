<?php
	// Include confi.php
	include_once('db_config.php');
	$wsVersion=0;
		$qur = $db->prepare('select id, title, content, category, publicationDate, source, sourceUrl, image, 
                imgCategory, nbClicksReadMore, isMainNews, newsType, videoPath
                from News, Category
                Where News.category=Category.libCategory
                And News.isMainNews="1"
				And News.newsType <> "video"
                order by id DESC
                Limit 1');


if (isset($_GET['wsversion']))
{
$wsVersion=$_GET['wsversion'];
if($wsVersion==2)
{
$qur = $db->prepare('select id, title, content, category, publicationDate, source, sourceUrl, image, 
                imgCategory, nbClicksReadMore, isMainNews, newsType, videoPath
                from News, Category
                Where News.category=Category.libCategory
                And News.isMainNews="1"
                order by id DESC
                Limit 1');
}
}

				
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("title" =>$r->title, "content" => $r->content, 'source' => $r->source,
			  'sourceUrl' => $r->sourceUrl, 'category' => $r->category, 
                          'publicationDate' => $r->publicationDate,
			  'image' => $r->image,'idNews' => $r->id,'imgCategory' => $r->imgCategory,
			   'nbClicksReadMore' => $r->nbClicksReadMore, 'isMainNews' => $r->isMainNews,
			   'newsType' => $r->newsType, 'videoPath' => $r->videoPath ); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
