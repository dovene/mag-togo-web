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
 
    <title>Administration des bases de données</title> 
 
    <link href="bootstrap.min.css" rel="stylesheet"> 
    <link href="bootstrap-datepicker.min.css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
 
  </head> 
 
  <body> 
 
 <?php
 include_once('db_config.php');
$req = $db->prepare('select idCategory, libCategory, imgCategory from Category order by idCategory desc');			
$req->execute();
 
?>
<?php
 include_once('nav.html');
?>
 
<br/>
<br/>
    <div class="container">
 
      <div class="starter-template">
        <h1>Gestion des annonces</h1>
      </div>
 
<br/>
<br/>
 
<!-- affichage des enreg -->
<div class="table-responsive">
            <table width="98%" style="border: 1px solid #CCCCCC" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                   <tr style=" font-weight:700; color:#FFFFFF; background-color:#336600">
                        <td align="center">Contenu</td>
                        <td COLSPAN=2 align="center">Actions</td>
                         <td align="center">Etat</td>
                        <td align="center">Utilisateur</td>
 
                        <td align="center">Categorie</td>
                        <td align="center">Date de creation</td>
 
                        <td align="center">Tel</td>
 
                        <td align="center">Email</td>   
                    </tr>
                </thead>
                <tbody>
 
                <?php
	// Include confi.php
	include_once('db_config.php');
 
 
 
		$qur = $db->prepare('select id, content, tel, email, status, created_at, username, libCategory 
		from ANNOUNCEMENTS order by id desc');			
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
                                <?php echo stripslashes($r->content) ?>
                            </td>
 
                             <?php
 
                        echo '<td>'.'<a href="announcement.php?del=1&id='.stripslashes($r->id).'">Supprimer</a></td>
                        <td><a href="announcement.php?del=0&id='.stripslashes($r->id).'">Activer</a></td>';
                         ?>
 
                            <td align="left">
                                <?php echo stripslashes($r->status) ?>
                            </td>
 
 
                           <td align="left">
                                <?php echo stripslashes($r->username) ?>
                            </td>
 
                            <td align="left">
                                <?php echo stripslashes($r->libCategory) ?>
                            </td>
 
                            <td align="left">
                                <?php echo stripslashes($r->created_at) ?>
                            </td>
 
                             <td align="left">
                                <?php echo stripslashes($r->tel) ?>
                            </td>
 
                             <td align="left">
                                <?php echo stripslashes($r->email) ?>
                            </td>
 
 
                        </tr>
                        <?php
                        $ligne++;
                        $nb++;
 
                    }
                    echo " il y a $nb annonces ";
 
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
 
if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==1)) {
$id = $_GET['id'];
  // here comes your delete query: use $_POST['deleteItem'] as your id
$stmt = $db->prepare("DELETE FROM ANNOUNCEMENTS WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectuée')</script>";
 
} else {
echo "<script> alert ('Suppression échouée')</script>";
}
 
echo "<script> window.location.href='announcement.php'</script>";
}
 
if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==0)) {
$id = $_GET['id'];
$param = "ok";
 
 
 //update home_data
 $qur = $db->prepare("select id, content, tel, email, status, created_at, username, libCategory, imageOne 
		from ANNOUNCEMENTS
                WHERE id=:id ");			
  $qur->bindValue(':id', $id, PDO::PARAM_STR);	
  $qur->execute();
  while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$title=$r->content;
			$image=$r->libCategory;
			
$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET announcePicture=:picture, announceLabel=:label, announceId=:id");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':id', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();
	}

 
$stmt = $db->prepare("UPDATE ANNOUNCEMENTS SET status=:param WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();
 
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Maj effectuée')</script>";
$messageHistory = "De nouvelles annonces sont disponibles dans votre magazine ";
$method="POST";
$data=array("message" => $messageHistory);
$url=$GCM_URL;
CallAPI($method, $url, $data);
 
} else {
echo "<script> alert ('Maj échouée')</script>";
}
 
echo "<script> window.location.href='announcement.php'</script>";
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
    document.getElementById('nbRecords').innerHTML = 'Il y a '+nb + ' annonces';
}
</script>
  </body> 
</html>