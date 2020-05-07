<?php
/* include db.config.php */
include_once('db_config.php');
header('Content-type: application/json; charset=UTF-8');
if($_SERVER['REQUEST_METHOD'] == "POST"){
// Get post data`
$title = isset($_POST['title']) ? $_POST['title'] : "";
$content = isset($_POST['content']) ? $_POST['content'] : "";
$category = isset($_POST['category']) ? $_POST['category'] : "";
$image = isset($_POST['image']) ? $_POST['image'] : "";
$publicationDate = isset($_POST['publicationDate']) ? $_POST['publicationDate'] : "";
// Save data into database
$query = $db->prepare("INSERT INTO News (title,content,category,publicationDate,image) 
                                  VALUES (:title, :content, :category, :publicationDate, :image)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));
$query->execute(array(':title' => $title, ':content' =>$content, ':category' => $category,
 ':publicationDate' => $publicationDate, ':image' => $image));

$affected_rows = $query->rowCount();

if($affected_rows>0){
$data = array("result" => 1, "message" => "Ajout bien effectué!");
} else {
$data = array("result" => 0, "message" => "Erreur!");
}
} else {
$data = array("result" => 0, "message" => "Mauvaise requête!");
}

$db=null;
/* JSON Response */
echo json_encode($data);
?>