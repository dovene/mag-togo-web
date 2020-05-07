<?php
	// Include confi.php
	include_once('db_config.php');

 $idUser = $_POST["idUser"]; 
 $idNews = $_POST["idNews"]; 

$query = $db->prepare("INSERT INTO news_users (idNews,idUsers) 
                                  VALUES (:news, :users)");

$query->execute(array(':news' => $idNews, ':users' => $idUser));
$affected_rows = $query->rowCount();

if($affected_rows>0){

//

$stmt = $db->prepare('SELECT count(*) as cnt FROM news_users WHERE idNews = :id');

    $stmt->bindParam(':id', $idNews, PDO::PARAM_INT);

    $isQueryOk = $stmt->execute();
     $count = 0;
    if ($isQueryOk) {
      $count = $stmt->fetchColumn();
      echo $count . ' rows of ' . $idNews ;  
    } else {
      trigger_error('Error executing statement.', E_USER_ERROR);
    }

// lire l'ancienne valeur

$st = $db->prepare("SELECT * FROM News WHERE id=:id");
$st->bindValue(':id', $idNews, PDO::PARAM_INT);
$st->execute();
while($r = $st->fetch(PDO::FETCH_OBJ)){
    $count = (int) $r->nbClicksReadMore; 
}

//update 
$stmt = $db->prepare("UPDATE News SET nbClicksReadMore=? WHERE id=?");
$stmt->execute(array( $count+1, $idNews));

echo "<script> alert ('Ajout effectuée')</script>";
} else {
echo "<script> alert ('Ajout échoué')</script>";
}	

?>