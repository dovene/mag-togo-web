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
$req = $db->prepare('select idCategory, libCategory, imgCategory from Category order by idCategory desc');			
$req->execute();
 
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
            <li class="active"><a href="#">Articles</a></li>
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
            Ajouter un nouvel article
        </button>
        <label id="nbRecords"></label>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAjout" 
                data-fv-framework="bootstrap"
            action="articles.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel" style="color:#336600">
                                <strong>NOUVEL ARTICLE</strong></h4>
                        </div>
 
                        <div class="modal-body">
 
                            <table width="590" style="border:0px; border-collapse:separate; border-spacing:0.5em;"id="news" cellspacing="0px">
                                <tr>
                                    <td  valign="top">Titre</td>
                                    <td   valign="top">
                                        <input style="width:150px" type="text" name="title"  
                                        class="form-control" value="" required="required"
                                       />
 
                                       </td>
 				</tr>
 			       <tr>
                                    <td  valign="top">Contenu</td>
                                    <td width="400"  valign="top">
                                        <textarea rows="10"  style="width:400px" type="text" required="required" name="content" value=""  class="form-control" required="required"
                                        onKeyDown="limitText(this.form.content,this.form.countdown3,4800);" onKeyUp="limitText(this.form.content,this.form.countdown3,4800);">
                                        </textarea>	
 
                                                                     <br>
                              <font size="1">(Maximum characters: 4800)
                             <br>
                              You have <input readonly type="text" name="countdown3" size="4" value="4800"> characters left.</font>
 
                                    </td>
                                </tr>
 
                                <tr>
                                    <td  valign="top">Cat�gorie</td>
                                    <td width="503"  valign="top">	
 
 
                                        <select name="category" >
                                            <?php
while($r = $req->fetch(PDO::FETCH_OBJ))
echo '<option value="'.$r->libCategory.'">'.$r->libCategory.'</ option>';
 
?>
                                        </select>	
                                        </td>
 
                                      </tr>
                                <tr>
                                    <td  valign="top">Date</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="publicationDate" id="publicationDate" class="a_voir" value="" required="required"/>	</td>
 			       </tr>
 
			       <tr>
                                    <td  valign="top">Source</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="source" id="source" class="a_voir" value="" required="required"/>	</td>
 			       </tr>
 
                               <tr>
                                    <td  valign="top">Lien</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="sourceUrl" id="sourceUrl" class="a_voir" value="" required="required"/>	</td>
 			       </tr>
 
                                <tr>
                                    <td  valign="top">Image</td>
                                    <td width="503"  colspan="4" valign="top">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                        <input type="file"  name="image" /></td>
                                </tr>
								 <tr>
								 <td  valign="top">Type</td>
                                    <td width="503" valign="top">
                                <select name="newsType">
								 <option value="article">Article</option>
								 <option value="video">Article Video</option>
								</select>
								    </td>
                                </tr>
								<tr>
                                    <td  valign="top">Ajouter la vid�o</td>
                                    <td width="503"  colspan="4" valign="top">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                        <input type="file"  name="video" /></td>
                                </tr>
								
								
                            </table>
 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <input type="submit" name="envoi1" value="Valider" class="btn btn-primary"/>
 
                        </div>
                    </div></form>
            </div>
        </div>
 
 
<?php
/* include db.config.php */
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['title'])){
// Get post data`
$title = isset($_POST['title']) ? $_POST['title'] : "";
$content = isset($_POST['content']) ? $_POST['content'] : "";
$category = isset($_POST['category']) ? $_POST['category'] : "";
$image = isset($_POST['image']) ? $_POST['image'] : "";
$publicationDate = isset($_POST['publicationDate']) ? $_POST['publicationDate'] : "";
$source = isset($_POST['source']) ? $_POST['source'] : "";
$sourceUrl = isset($_POST['sourceUrl']) ? $_POST['sourceUrl'] : "";
$newsType = isset($_POST['newsType']) ? $_POST['newsType'] : ""; 
$video = isset($_POST['video']) ? $_POST['video'] : "";

//$dossier='upload/';
$dossier='images/';

 //upload de l'image 
//$dossier=dirname(__FILE__);
$fichier = basename($_FILES['image']['name']);
$taille_maxi = 5000000;
$taille = filesize($_FILES['image']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.3gp', '.mp4');
$extension = strrchr($_FILES['image']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{$data64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝ� áâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['image']['tmp_name'],$dossier.$fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
 
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
 
if ($fichier!="") {
     $fichier=$dossier.$fichier;
}
 
//upload de la video 
 $dossierVideo='videos/';
$fichierVideo = basename($_FILES['video']['name']);
$tailleVideo = filesize($_FILES['video']['tmp_name']);
$extensionsVideo = array('.3gp', '.mp4');
$extensionsVideo = strrchr($_FILES['video']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreurVideo = 'Vous devez uploader un fichier de type mp4 ou 3gp';
}
if($tailleVideo>$taille_maxi)
{
     $erreurVideo = 'Le fichier est trop gros...';
}
if(!isset($erreurVideo)) //S'il n'y a pas d'erreur, on upload
{$data64 = base64_encode(file_get_contents($_FILES['video']['tmp_name']));
     //On formate le nom du fichier ici...
     $fichierVideo = strtr($fichierVideo, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝ� áâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichierVideo = preg_replace('/([^.a-z0-9]+)/i', '-', $fichierVideo);
     if(move_uploaded_file($_FILES['video']['tmp_name'],$dossierVideo.$fichierVideo)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !'.$dossierVideo.$fichierVideo;
 
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
 
if ($fichierVideo!="") {
     $fichierVideo=$dossierVideo.$fichierVideo;
}

 
 
 
 
 
$nbClicks=rand(25, 50);
 
// Save data into database
$query = $db->prepare("INSERT INTO News (title,content,category,publicationDate,image,source,sourceUrl,nbClicksReadMore,newsType,videoPath) 
                                  VALUES (:title, :content, :category, :publicationDate, :image, :source, :sourceUrl, :nbClicksReadMore, :newsType, :videoPath)");

$query->execute(array(':title' => $title, ':content' =>$content, ':category' => $category,
 ':publicationDate' => $publicationDate, ':image' => $fichier, ':source' => $source,
 ':sourceUrl' => $sourceUrl,':nbClicksReadMore' => $nbClicks, ':newsType' => $newsType , ':videoPath' => $fichierVideo));
$affected_rows = $query->rowCount();
if($affected_rows>0){
echo "<script> alert ('Ajout effectu�e')</script>";
 if ($newsType<>"video"){
$method="POST";
$data=array("message" => $title);
$url="http://dovene.coolpage.biz/gcm_inline_caller.php";
CallAPI($method, $url, $data);
 }

} else {
echo "<script> alert ('Ajout �chou�')</script>";
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
 
                        <td align="center">Contenu</td>
 
                        <td align="center">Cat�gorie</td>
 
                        <td align="center">Image</td>
 
                        <td align="center">Date de publication</td>
 
                        <td align="center">Source</td>
 
                        <td align="center">Lien</td>
 
                        <td COLSPAN=3 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
 
                <?php
	// Include confi.php
	include_once('db_config.php');
 
		$qur = $db->prepare('select id, title, content, category, publicationDate, image, source, sourceUrl from News order by id desc limit 30');			
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
                                <?php echo stripslashes($r->content) ?>
                            </td>
 
 
                           <td align="left">
                                <?php echo stripslashes($r->category) ?>
                            </td>
 
                            <td align="left">
                                <?php echo stripslashes($r->image) ?>
                            </td>
 
                            <td align="left">
                                <?php echo stripslashes($r->publicationDate) ?>
                            </td>
 
                             <td align="left">
                                <?php echo stripslashes($r->source) ?>
                            </td>
 
                             <td align="left">
                                <?php echo stripslashes($r->sourceUrl) ?>
                            </td>
                        <?php
 
                        echo '<td>'.'<a title="" onclick="functionNA()">Modifier</a></td>
                        <td><a href="articles.php?del=1&id='.stripslashes($r->id).'">Supprimer</a></td>
                        <td><a href="articles.php?del=0&id='.stripslashes($r->id).'">A La Une</a></td>';
                         ?>
 
                        </tr>
                        <?php
                        $ligne++;
                        $nb++;
 
                    }
                    echo " il y a $nb articles ";
 
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
$stmt = $db->prepare("DELETE FROM News WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectu�e')</script>";
 
} else {
echo "<script> alert ('Suppression �chou�e')</script>";
}
 
echo "<script> window.location.href='articles.php'</script>";
}
 
if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==0)) {
$id = $_GET['id'];
$param = 1;
 
 
 
 $qur = $db->prepare("select id, title, content, category, publicationDate, source, sourceUrl,
  				image, imgCategory, nbClicksReadMore
  				from News, Category
                Where News.category=Category.libCategory
                And News.id = :id
                Limit 1
                ");			
  $qur->bindValue(':id', $id, PDO::PARAM_STR);	
  $qur->execute();
  while($r = $qur->fetch(PDO::FETCH_OBJ)){
 
			//extract($r);
			$title=$r->title;
			$image='';
			if (($r->image=='') || (strlen($r->image)==0)){
			$image=$r->imgCategory;
			}else{
			$image=$r->image;
			}
 
$stmt1 = $db->prepare("UPDATE HOME_DATA SET newsPicture=:picture, newsLabel=:label, newsId=:newsId ");
$stmt1->bindValue(':picture', $image, PDO::PARAM_STR);
$stmt1->bindValue(':label', $title, PDO::PARAM_STR);
$stmt1->bindValue(':newsId', $id, PDO::PARAM_INT);
$stmt1->execute();
	}
 
 
 
$stmt = $db->prepare("UPDATE News SET isMainNews=:param WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();
 
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Maj effectu�e')</script>";
 
} else {
echo "<script> alert ('Maj �chou�e')</script>";
} 
echo "<script> window.location.href='articles.php'</script>";
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
 
    <script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>
 
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