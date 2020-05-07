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
            <li><a href="#about">About</a></li>
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
        
        
         <div class="modal fade" id="myModal" tabnewsManager="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form_ajout" action="newsManager.php" method="post" enctype="multipart/form-data">

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
                                        <input style="width:150px" type="text" name="title"  class="a_voir" value="" required="required"/>	</td>
 								 </tr>
 								 <tr>
                                    <td  valign="top">Contenu</td>
                                    <td width="400"  valign="top">
                                        <textarea rows="10"  style="width:400px" type="text" name="content" value=""  class="a_voir" required="required">
                                        </textarea>	
                                    </td>
                                </tr>

                                <tr>
                                    <td  valign="top">Catégorie</td>
                                    <td width="503"  valign="top">	
                                        <select name="category" >
                                            <option  value="Sport"> Sport </option> 
                                            <option  value="Emploi"> Emploi </option>
                                            <option  value="Spectacle"> Spectacle </option>
                                             <option  value="Divers"> Divers </option>
                                        </select>	</td>
								</tr>
                                <tr>
                                    <td  valign="top">Date</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="publicationDate" id="publicationDate" class="a_voir" value="" required="required"/>	</td>
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

                        <td COLSPAN=2 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
                
                <?php
	// Include confi.php
	include_once('db_config.php');
	
		$qur = $db->prepare('select id, title, content, category, publicationDate, image from News');			
		$qur->execute();
		$result =array();
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
                        <?php

                        echo '<td>'.'<a title="" onclick="functionNA()">Modifier</a></td>
                        <td><a href="newsManager.php?id='.stripslashes($r->id).'">Supprimer</a></td>';
                         ?>
                        </tr>
                        <?php
                        $ligne++;
                    }
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
$stmt = $db->prepare("DELETE FROM News WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectuée')</script>";

} else {
echo "<script> alert ('Suppression échouée')</script>";
}

echo "<script> window.location.href='newsManager.php'</script>";

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

            });
        </script>
  </body> 
</html>