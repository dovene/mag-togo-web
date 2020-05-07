<?php
	// Include confi.php
	include_once('db_config.php');
	
	
if (isset($_GET['search']))
{
 $search=$_GET['search'];
  $qur = $db->prepare("select id, title, content, category, publicationDate, source, sourceUrl,
  				image, imgCategory, nbClicksReadMore
  				from News, Category
                Where News.category=Category.libCategory
                And News.title LIKE :param
                Limit 1
                ");			
  $qur->bindValue(':param', '%'.$search.'%', PDO::PARAM_STR);	
	}else if (isset($_GET['id']))
{
 $id=$_GET['id'];
  $qur = $db->prepare("select id, title, content, category, publicationDate, source, sourceUrl,
  				image, imgCategory, nbClicksReadMore
  				from News, Category
                Where News.category=Category.libCategory
                And News.id = :param
                Limit 1
                ");			
  $qur->bindValue(':param', $id, PDO::PARAM_INT);	
	}
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("title" =>$r->title, "content" => $r->content, 'source' => $r->source,
			  'sourceUrl' => $r->sourceUrl, 'category' => $r->category, 
                          'publicationDate' => $r->publicationDate,
			  'image' => $r->image,'idNews' => $r->id,'imgCategory' => $r->imgCategory, 'nbClicksReadMore' => $r->nbClicksReadMore  ); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
	
?>