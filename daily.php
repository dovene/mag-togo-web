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
 
    <title>Administration des bases de donnÃ©es</title> 
 
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
             <li><a href="articles.php">Articles</a></li>
            <li><a href="category.php">Categories</a></li>
            <li><a href="infos.php">Infos Utiles</a></li>
            <li><a href="history.php">Histoires</a></li>
            <li><a href="videos.php">Video</a></li>
            <li class="active"><a href="daily.php">Pensée du jour</a></li>
           <li><a href="index.php">Déconnexion</a></li>
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
            Ajouter une nouvelle pensée du jour
        </button>
        <label id="nbRecords"></label>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAjout" 
                data-fv-framework="bootstrap"
            action="daily.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel" style="color:#336600">
                                <strong>NOUVELLE PENSEE DU JOUR</strong></h4>
                        </div>
 
                        <div class="modal-body">
 
                            <table width="590" style="border:0px; border-collapse:separate; border-spacing:0.5em;"id="news" cellspacing="0px">
                               <tr>
                                    <td  valign="top">Libellé</td>
                                    
                                    
                                    
                            <td   valign="top">
                            
                             <textarea rows="10"  style="width:300px" type="text" required="required" name="libelle" value=""  class="form-control" required="required"
                                       onKeyDown="limitText(this.form.libelle,this.form.countdown1,150);" onKeyUp="limitText(this.form.libelle,this.form.countdown1,150);">
                                    </textarea>
                            <br>
                              <font size="1">(Maximum characters: 150)
                             <br>
                              You have <input readonly type="text" name="countdown1" size="4" value="150"> characters left.</font>
                              </td>
                              
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
if($_POST['libelle']){
// Get post data`
$lib = isset($_POST['libelle']) ? $_POST['libelle'] : "";
// Save data into database
$query = $db->prepare("INSERT INTO DAILY_THOUGHTS (content) 
                                  VALUES (:lib)");
 
$query->execute(array(':lib' => $lib));
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
                        <td align="center">Libelle</td>
                        <td COLSPAN=2 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
 
                <?php
	// Include confi.php
	include_once('db_config.php');
 
		$qur = $db->prepare('select id, content from DAILY_THOUGHTS order by id desc');			
		$qur->execute();
		$result =array();
                $nb = 0;
				$ligne = 1;
            $bg_color = "";
           $rootUrl = "http://dovene.coolpage.biz/";
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r)
 
		  ($ligne % 2 == 0) ? ($bg_color = '') : ($bg_color = '#E7E7E7');
                        ?>
                        <tr >
 
                            <td align="left">
                                <?php echo stripslashes($r->content) ?>
                            </td>
 
 
                    
                        <?php
 
                        echo '<td>'.'<a title="" onclick="functionNA()">Modifier</a></td>
                        <td><a href="daily.php?id='.stripslashes($r->id).'">Supprimer</a></td>';
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
$stmt = $db->prepare("DELETE FROM DAILY_THOUGHTS  WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
//$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Suppression effectuÃ©e')</script>";
 
} else {
echo "<script> alert ('Suppression Ã©chouÃ©e')</script>";
}
 
echo "<script> window.location.href='daily.php'</script>";
 
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