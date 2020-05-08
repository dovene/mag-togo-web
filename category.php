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
            Ajouter une nouvelle catégorie
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
                                <strong>NOUVELLE CATEGORIE</strong></h4>
                        </div>

                        <div class="modal-body">
                            
                            <table width="590" style="border:0px; border-collapse:separate; border-spacing:0.5em;"id="news" cellspacing="0px">
                               <tr>
                                    <td  valign="top">Libellé</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="libelle" id="libelle" class="a_voir" value="" required="required"/>	</td>
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
                            <input type="submit" name="add" value="Valider" class="btn btn-primary"/>

                        </div>
                    </div></form>
            </div>
        </div>


<?php
if($_POST['libelle']){
// Get post data`
$lib = isset($_POST['libelle']) ? $_POST['libelle'] : "";
$image = isset($_POST['image']) ? $_POST['image'] : "";
// Save data into database
$query = $db->prepare("INSERT INTO Category (libCategory,imgCategory) 
                                  VALUES (:lib, :image)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));

$dossier='images/';

//$dossier=dirname(__FILE__);
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
{$data64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
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

$query->execute(array(':lib' => $lib, ':image' => $dossier.$fichier));
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
                        <td align="center">Libelle</td>

                        <td align="center">Image</td>
                        
                        <td COLSPAN=2 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
                
                <?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select idCategory, libCategory, imgCategory from Category order by idCategory desc');			
		$qur->execute();
		$result =array();
                $nb = 0;
				$ligne = 1;
            $bg_color = "";
           $rootUrl = $BASE_URL;
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r)
            
		  ($ligne % 2 == 0) ? ($bg_color = '') : ($bg_color = '#E7E7E7');
                        ?>
                        <tr >

                            <td align="left">
                                <?php echo stripslashes($r->libCategory) ?>
                            </td>

                            
                            <td align="left">
                           
                          <?php echo  '<img name="myimage" src="'.$rootUrl.stripslashes($r->imgCategory).'" width="60" height="60" alt="word" />';     ?>
          
    
                              </td>          
                        <?php

                        echo '<td>'.'<a title="" onclick="functionNA()">Modifier</a></td>
                        <td><a href="category.php?id='.stripslashes($r->idCategory).'">Supprimer</a></td>';
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

if(isset($_GET['id']) and is_numeric($_GET['id']))
{

$id = $_GET['id'];
  // here comes your delete query: use $_POST['deleteItem'] as your id
$stmt = $db->prepare("DELETE FROM Category  WHERE idCategory=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
//$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectuée')</script>";

} else {
echo "<script> alert ('Suppression échouée')</script>";
}

echo "<script> window.location.href='category.php'</script>";

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