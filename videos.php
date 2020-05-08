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
 
    <title>Administration des bases de donnÃƒÂ©es</title> 
 
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
            Ajouter une nouvelle vidéo
        </button>
        <label id="nbRecords"></label>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAjout" 
                data-fv-framework="bootstrap"
            action="videos.php" method="post" enctype="multipart/form-data">
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
$query = $db->prepare("INSERT INTO History (title,videoId) 
                                  VALUES (:title, :code)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));


$query->execute(array(':title' => $title, ':code' => $code));
$affected_rows = $query->rowCount();

if($affected_rows>0){
echo "<script> alert ('Ajout effectuÃƒÂ©e')</script>";
} else {
echo "<script> alert ('Ajout ÃƒÂ©chouÃƒÂ©')</script>";
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
                
                        
                        <td COLSPAN=2 align="center">Actions</td>
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
                        <td><a href="videos.php?id='.stripslashes($r->id).'">Supprimer</a></td>';
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

if(isset($_GET['id']) and is_numeric($_GET['id']))
{

$id = $_GET['id'];
  // here comes your delete query: use $_POST['deleteItem'] as your id
$stmt = $db->prepare("DELETE FROM VideoList  WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectuÃƒÂ©e')</script>";

} else {
echo "<script> alert ('Suppression ÃƒÂ©chouÃƒÂ©e')</script>";
}

echo "<script> window.location.href='videos.php'</script>";

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