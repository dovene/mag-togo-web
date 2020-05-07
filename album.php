<?php
   ob_start();
   session_start();
if (!isset($_SESSION['username'])) {
  header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="fr"> 
  <head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>Administration des bases de donn�es</title> 
 
    <link href="bootstrap.min.css" rel="stylesheet"> 
    <link href="bootstrap-datepicker.min.css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
 
  </head> 
 
  <body> 
 
 <?php
 include_once('db_config.php');
?>
     <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Projects</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="articles.php">Articles</a></li>
            <li><a href="category.php">Categorie d'article</a></li>
            <li><a href="album.php">Album</a></li>
            <li><a href="history.php">Histoires</a></li>
            <li><a href="videoos.php">Video</a></li>
            <li><a href="categoryAnnouncement.php">Categorie d'Annonce</a>
            <li><a href="announcement.php">Annonce</a>
             <li><a href="notif.php">Notification</a>
           <li><a href="index.php">D�connexion</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
 
<br/>
<br/>
    <div class="container">
 
      <div class="starter-template">
        <h1></h1>
      </div>
 
 		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"  style="color:#FFFFFF; background-color:#336600">
            Ajouter un nouvel album
        </button>
        <label id="nbRecords"></label>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAjout" 
                data-fv-framework="bootstrap"
            action="category.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel" style="color:#336600">
                                <strong>NOUVEL ALBUM</strong></h4>
                        </div>
 
                        <div class="modal-body">
 
                            <table width="590" style="border:0px; border-collapse:separate; border-spacing:0.5em;"id="news" cellspacing="0px">
 
                                <tr>
                                    <td  valign="top">Image</td>
                                    <td width="503"  colspan="4" valign="top">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                        <input name="image[]" type="file" multiple="multiple" />
                                        <input type="hidden" name="sendfiles" value="Send Files"</td>
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
<!-- affichage des enreg -->
<div class="table-responsive">
            <table width="98%" style="border: 1px solid #CCCCCC" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                   <tr style=" font-weight:700; color:#FFFFFF; background-color:#336600">
                        <td align="center">Libelle</td>
 
                        <td align="center">Image 1</td>
                        <td align="center">Etat </td>
                        <td COLSPAN=2 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
 
                <?php
	// Include confi.php
	include_once('db_config.php');
 
		$qur = $db->prepare('select idAlbum, libAlbum, pathImage1, status from Album order by idAlbum desc');			
		$qur->execute();
		$result =array();
                $nb = 0;
				$ligne = 1;
            $bg_color = "";
           $rootUrl = "http://dovene.coolpage.biz/images/";
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r)
 
		  ($ligne % 2 == 0) ? ($bg_color = '') : ($bg_color = '#E7E7E7');
                        ?>
                        <tr >
 
                            <td align="left">
                                <?php echo stripslashes($r->libAlbum) ?>
                            </td>    
                            <td align="left">
 
                          <?php echo  '<img name="myimage" src="'.$rootUrl.stripslashes($r->pathImage1).'" width="60" height="60" alt="word" />'; ?>
                              </td>      
                              <td align="left">
                                <?php echo stripslashes($r->status) ?>
                            </td>     
                        <?php
                        echo '<td>'.'<a href="album.php?del=1&id='.stripslashes($r->idAlbum).'">Supprimer</a></td>
                        <td><a href="album.php?del=0&id='.stripslashes($r->idAlbum).'">Mettre en avant</a></td>';
                         ?>
 
                        </tr>
                        <?php
                        $ligne++;
                        $nb++;                        
                    }
                    echo " il y a $nb albums ";
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
 
if(isset($_GET['idAlbum']) and is_numeric($_GET['idAlbum']) && ($_GET['del']==1)) {
$id = $_GET['idAlbum'];
  // here comes your delete query: use $_POST['deleteItem'] as your id
$stmt = $db->prepare("DELETE FROM Album WHERE idAlbum=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
//$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectu�e')</script>";
 
} else {
echo "<script> alert ('Suppression �chou�e')</script>";
}
 
echo "<script> window.location.href='album.php'</script>";
}
 
if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==0)) {
$id = $_GET['id'];
$param = 1;
$paramAll = 0;
 $dataTitle = "";
 
 //update home_data
 $qur = $db->prepare("select idAlbum, libAlbum, pathImage1, status from Album
                WHERE idAlbum=:id ");			
  $qur->bindValue(':id', $id, PDO::PARAM_STR);	
  $qur->execute();
  while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$title=$r->libAlbum;
			$image=$r->pathImage1;
			$dataTitle = $title;
			
$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET albumPicture=:picture, albumLabel=:label, albumId=:albumId");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':albumId', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();

	}
 
 
 
 
 
$stUpdateAll = $db->prepare("UPDATE Album SET status=:paramAll");
$stUpdateAll->bindValue(':paramAll', $paramAll, PDO::PARAM_STR);
$stUpdateAll->execute();
 
 
$stmt = $db->prepare("UPDATE Album SET status=:param WHERE idAlbum=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();
 
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Maj effectu�e')</script>";
 
$messageHistory = "Ne manquez pas votre album du moment, tout en images : ".$dataTitle;
$method="POST";
$data=array("message" => $messageHistory);
$url="http://dovene.coolpage.biz/gcm_inline_caller.php";
CallAPI($method, $url, $data);

} else {
echo "<script> alert ('Maj �chou�e')</script>";
}
 
echo "<script> window.location.href='album.php'</script>";
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
                echo "<script> alert ('envoi curl')</script>";
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
    </div>
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
    document.getElementById('nbRecords').innerHTML = 'Il y a '+nb + ' articles';
}
</script>
</body> 
</html>
