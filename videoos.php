<!DOCTYPE html>
<html lang="fr"> 
  <head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>Administration des bases de donnÃ©es</title> 
 
    <link href="bootstrap.min.css" rel="stylesheet"> 
    <link href="bootstrap-datepicker.min.css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
 
  </head> 
 
  <body> 
 
 <?php
 include_once('db_config.php');
?>
  <?php
 include_once('nav.html');
?>
 
<br/>
<br/>
    <div class="container">
 
      <div class="starter-template">
        <h1></h1>
      </div>
 
 		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"  style="color:#FFFFFF; background-color:#336600">
            Ajouter une nouvelle vid�o
        </button>
        <label id="nbRecords"></label>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAjout" 
                data-fv-framework="bootstrap"
            action="videoos.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel" style="color:#336600">
                                <strong>NOUVELLE VIDEO</strong></h4>
                        </div>
 
                        <div class="modal-body">
 
                            <table width="590" style="border:0px; border-collapse:separate; border-spacing:1.5em;"id="news" cellspacing="0px">
                               <tr>
                                    <td  valign="top">Titre</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="title" id="libelle" class="a_voir" value="" required="required"/>	</td>
 			                   </tr>
                                <tr>
                                    <td  valign="top">Code</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="code" id="libelle" class="a_voir" value="" required="required"/>	</td>
 			                   </tr>
 
                            </table>
 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <input type="submit" name="add" value="Valider" class="btn btn-primary"/>
 
                        </div>
                    </div></form>
            </div>
        </div>
 
 
<?php
/* include db.config.php */
if($_POST['title']){
// Get post data`
$title = isset($_POST['title']) ? $_POST['title'] : "";
$code = isset($_POST['code']) ? $_POST['code'] : "";
 
 
// Save data into database
$query = $db->prepare("INSERT INTO VideoList (title,videoId) 
                                  VALUES (:title, :code)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));
 
 
$query->execute(array(':title' => $title, ':code' => $code));
$affected_rows = $query->rowCount();
 
if($affected_rows>0){
echo "<script> alert ('Ajout effectuÃ©e')</script>";
} else {
echo "<script> alert ('Ajout Ã©chouÃ©')</script>";
}
} 
?>
<br/>
<br/>
 
<!-- affichage des enreg -->
<div class="table-responsive">
            <table width="98%" style="border: 1px solid #CCCCCC" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                   <tr style=" font-weight:700; color:#FFFFFF; background-color:#336600">
                        <td align="center">Titre</td>
 
                        <td align="center">Code</td>
 
 
                        <td COLSPAN=3 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
 
                <?php
	// Include confi.php
	include_once('db_config.php');
 
		$qur = $db->prepare('select id, title, videoId from VideoList order by id desc');			
		$qur->execute();
		$result =array();
                $nb = 0;
				$ligne = 1;
            $bg_color = "";
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r)
 
		  ($ligne % 2 == 0) ? ($bg_color = '') : ($bg_color = '#E7E7E7');
                        ?>
                        <tr >
 
                            <td align="left">
                                <?php echo stripslashes($r->title) ?>
                            </td>
 
                            <td align="left">
                                <?php echo stripslashes($r->videoId) ?>
                            </td>
 
                        <?php
 
                        echo '<td>'.'<a title="" onclick="functionNA()">Modifier</a></td>
                        <td><a href="videoos.php?del=1&id='.stripslashes($r->id).'">Supprimer</a></td>
                        <td><a href="videoos.php?del=0&id='.stripslashes($r->id).'">Mettre en avant</a></td>';
                         ?>
                        </tr>
                        <?php
                        $ligne++;
                        $nb++;
 
                    }
                    echo " il y a $nb videos ";
 
				?>
                 </tbody>
            </table>
        </div>
<?php
function functionNA()
{
   echo "<script> alert ('Fonction Indisponible')</script>";
}
?>
 
<?php
 
if(isset($_GET['id']) and is_numeric($_GET['id'] && ($_GET['del']==1))) {
 
$id = $_GET['id'];
  // here comes your delete query: use $_POST['deleteItem'] as your id
$stmt = $db->prepare("DELETE FROM VideoList  WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectu�e')</script>";
 
} else {
echo "<script> alert ('Suppression �chou�e')</script>";
}
 
 echo "<script> window.location.href='videoos.php'</script>";
 
}
 
 
 
 if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==0)) {
$id = $_GET['id'];
$param = 1;
$paramAll = 0;
$dataTitle = "";

//update home_data
 $qur = $db->prepare("select id, title, videoId from VideoList
                WHERE id=:id ");			
  $qur->bindValue(':id', $id, PDO::PARAM_STR);	
  $qur->execute();
while($r = $qur->fetch(PDO::FETCH_OBJ)){
	echo	 "<script> alert ('Selection ok')</script>";	
			//extract($r);
			$title=$r->title;
			$image=$r->videoId;
			$dataTitle = $title;
			
$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET musicPicture=:picture, musicLabel=:label, musicId=:musicId");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':musicId', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();
$affected_rows = $stUpdateHomeData->rowCount();
if($affected_rows>0){
echo "<script> alert ('Maj effectu�e')</script>";
 
$messageHistory = "Passez de bons moments en musique avec le clip : ".$dataTitle;
$method="POST";
$data=array("message" => $messageHistory);
$url=$GCM_URL;
CallAPI($method, $url, $data);
 
 
} else {
echo "<script> alert ('Maj �chou�e')</script>";
}
 
echo "<script> window.location.href='videoos.php'</script>";
}

}


 
  function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
?>

    </div><!-- /.container -->
<!-- JQuery -->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js'></script>
<!-- JQuery local use
<script src="bootstrap/js/jquery-1.11.3.min.js"></script> 
  <script src="bootstrap/js/jquery-ui.min.js"></script>  
  -->
 
  <script src="bootstrap.min.js"></script> 
    <script src="bootstrap-datepicker.min.js"></script> 
  <script type="text/javascript">
            // When the document is ready
    $(document).ready(function () {
 
                $('#publicationDate').datepicker({
                    "format": "dd/mm/yyyy",
                     "autoclose": true
                });  
 
    $("#publicationDate").datepicker("setDate", "0");
 
 $('#formAjout').formValidation();
            });
 
 
 
        </script>
        <script type="text/javascript">
function updateLabel(nb) {
    document.getElementById('nbRecords').innerHTML = 'Il y a '+nb + ' enregistrements';
}
</script>
  </body> 
</html>
