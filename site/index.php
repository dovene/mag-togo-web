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
            <li class="active"><a href="#">Gestionnaire des articles</a></li>
            <li><a href="category.php">Category</a></li>
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
            action="index.php" method="post" enctype="multipart/form-data">
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
                                        <textarea rows="10"  style="width:400px" type="text" required="required" name="content" value=""  class="form-control" required="required">
                                        </textarea>	
                                    </td>
                                </tr>

                                <tr>
                                    <td  valign="top">Catégorie</td>
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



//$dossier='upload/';
$dossier=dirname(__FILE__);
$fichier = basename($_FILES['image']['name']);
$taille_maxi = 5000000;
$taille = filesize($_FILES['image']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
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
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['image']['tmp_name'],$fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
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








// Save data into database
$query = $db->prepare("INSERT INTO News (title,content,category,publicationDate,image,source,sourceUrl) 
                                  VALUES (:title, :content, :category, :publicationDate, :image, :source, :sourceUrl)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));
$query->execute(array(':title' => $title, ':content' =>$content, ':category' => $category,
 ':publicationDate' => $publicationDate, ':image' => $fichier, ':source' => $source, ':sourceUrl' => $sourceUrl));
$affected_rows = $query->rowCount();
if($affected_rows>0){
echo "<script> alert ('Ajout effectuée')</script>";
} else {
echo "<script> alert ('Ajout échoué')</script>";
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

                        <td align="center">Catégorie</td>
                        
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
	
		$qur = $db->prepare('select id, title, content, category, publicationDate, image, source, sourceUrl from News order by id desc');			
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
                        <td><a href="index.php?del=1&id='.stripslashes($r->id).'">Supprimer</a></td>
                        <td><a href="index.php?del=0&id='.stripslashes($r->id).'">A La Une</a></td>';
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
echo "<script> alert ('Suppression effectuée')</script>";

} else {
echo "<script> alert ('Suppression échouée')</script>";
}

echo "<script> window.location.href='index.php'</script>";
}

if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==0)) {
$id = $_GET['id'];
$param = 1;

$stmt = $db->prepare("UPDATE News SET isMainNews=:param WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();

$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Maj effectuée')</script>";

} else {
echo "<script> alert ('Maj échouée')</script>";
}

echo "<script> window.location.href='index.php'</script>";
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
    document.getElementById('nbRecords').innerHTML = 'Il y a '+nb + ' articles';
}
</script>
  </body> 
</html>