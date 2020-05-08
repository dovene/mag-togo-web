<?php
   ob_start();
   session_start();
if (!isset($_SESSION['username'])) {
  header("Location:index.php");
}?>
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
            Ajouter une nouvelle histoire
        </button>
        <label id="nbRecords"></label>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAjout" 
                data-fv-framework="bootstrap"
            action="history.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel" style="color:#336600">
                                <strong>NOUVELLE HISTOIRE</strong></h4>
                        </div>
 
                        <div class="modal-body">
 
                            <table width="590" style="border:0px; border-collapse:separate; border-spacing:1.5em;"id="news" cellspacing="0px">
                               <tr>
                                    <td  valign="top">Titre</td>
                                    <td   valign="top">
                                        <input style="width:200px" type="text" name="title" id="libelle" class="a_voir" value="" required="required"/>	</td>
 			                   </tr>
                                 <tr>
 
                                <tr>
                                    <td  valign="top">Page 1</td>
                                    <td width="400"  valign="top">
                                        <textarea rows="10"  style="width:400px" type="text" required="required" name="page1" value=""  class="form-control" required="required"
                                       onKeyDown="limitText(this.form.page1,this.form.countdown1,4000);" onKeyUp="limitText(this.form.page1,this.form.countdown1,4000);">
                                    </textarea>
                             <br>
                              <font size="1">(Maximum characters: 4000)
                             <br>
                              You have <input readonly type="text" name="countdown1" size="4" value="4000"> characters left.</font>
 
                                    </td>
                                </tr>
 
 			          <tr>
                                    <td  valign="top">Page 2</td>
                                    <td width="400"  valign="top">
                                        <textarea rows="10"  style="width:400px" type="text" required="required" name="page2" value=""  class="form-control" required="required"
                                         onKeyDown="limitText(this.form.page2,this.form.countdown2,4000);" onKeyUp="limitText(this.form.page2,this.form.countdown2,4000);">
                             </textarea>	
                             <br>
                              <font size="1">(Maximum characters: 4000)
                             <br>
                              You have <input readonly type="text" name="countdown2" size="4" value="4000"> characters left.</font>
 
                                    </td>
                                </tr>
 			                    <tr>
                                    <td  valign="top">Page 3</td>
                                    <td width="400"  valign="top">
                                        <textarea rows="10"  style="width:400px" type="text" required="required" name="page3" value=""  class="form-control" required="required"
                                          onKeyDown="limitText(this.form.page3,this.form.countdown3,4000);" onKeyUp="limitText(this.form.page3,this.form.countdown3,4000);">
                                     </textarea>	
                             <br>
                              <font size="1">(Maximum characters: 4000)
                             <br>
                              You have <input readonly type="text" name="countdown3" size="4" value="4000"> characters left.</font>
 
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
if($_POST['title']){
// Get post data`
$title = isset($_POST['title']) ? $_POST['title'] : "";
$page1 = isset($_POST['page1']) ? $_POST['page1'] : "";
$page2 = isset($_POST['page2']) ? $_POST['page2'] : "";
$page3 = isset($_POST['page3']) ? $_POST['page3'] : "";
 
// Save data into database
$query = $db->prepare("INSERT INTO History (title,contentPage1,contentPage2,contentPage3) 
                                  VALUES (:title, :page1, :page2, :page3)");
//$query->execute(array(':firstName' => $_POST['firstname'], ':lastName' =>$_POST['lastname'], ':email' => $_POST['email'], ':password' => $_POST['password'], ':status' => $_POST['status']));
 
 
$query->execute(array(':title' => $title, ':page1' => $page1, ':page2' => $page2, ':page3' => $page3));
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
 
                        <td align="center">Page 1</td>
                         <td align="center">Page 2</td>
                          <td align="center">Page 3</td>
                          <td align="center">Status</td>
                        <td COLSPAN=3 align="center">Actions</td>
                    </tr>
                </thead>
                <tbody>
 
                <?php
	// Include confi.php
	include_once('db_config.php');
 
		$qur = $db->prepare('select id, title, contentPage1, contentPage2, contentPage3, status from History order by id desc');			
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
                                <?php echo stripslashes($r->contentPage1) ?>
                            </td>
                             <td align="left">
                                <?php echo stripslashes($r->contentPage2) ?>
                            </td>
                             <td align="left">
                                <?php echo stripslashes($r->contentPage3) ?>
                            </td>        
                             <td align="left">
                                <?php echo stripslashes($r->status) ?>
                            </td>        
                        <?php
 
                        echo '<td>'.'<a title="" onclick="displayAlert()">Modifier</a></td>
                        <td><a href="history.php?del=1&id='.stripslashes($r->id).'">Supprimer</a></td>
                        <td><a href="history.php?del=0&id='.stripslashes($r->id).'">Mettre en avant</a></td>';
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
function displayAlert()
{
   echo "<script> alert ('Fonction Indisponible')</script>";
}
?>
 
<?php
 
if(isset($_GET['id']) and is_numeric($_GET['id']) && ($_GET['del']==1)) {
$id = $_GET['id'];
  // here comes your delete query: use $_POST['deleteItem'] as your id
$stmt = $db->prepare("DELETE FROM History WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
//$stmt->execute();
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
$paramAll = 0;
$historyTitle = "";
 
 
//update home_data
 $qur = $db->prepare("select id, title, contentPage1, contentPage2, contentPage3, status, image from History
                WHERE id=:id ");			
  $qur->bindValue(':id', $id, PDO::PARAM_STR);	
  $qur->execute();
  while($r = $qur->fetch(PDO::FETCH_OBJ)){
			echo "<script> alert ('Selection ok')</script>";
			//extract($r);
			$title=$r->title;
			$image=$r->image;
			$historyTitle = $title;
			
$stUpdateHomeData = $db->prepare("UPDATE HOME_DATA SET historyPicture=:picture, historyLabel=:label, historyId=:historyId");
$stUpdateHomeData->bindValue(':picture', $image, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':label', $title, PDO::PARAM_STR);
$stUpdateHomeData->bindValue(':historyId', $id, PDO::PARAM_INT);
$stUpdateHomeData->execute();

	}
 
 
 //update history
 
 $stUpdateAll = $db->prepare("UPDATE History SET status=:paramAll");
$stUpdateAll->bindValue(':paramAll', $paramAll, PDO::PARAM_STR);
$stUpdateAll->execute();
 
 
$stmt = $db->prepare("UPDATE History SET status=:param WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':param', $param, PDO::PARAM_STR);
$stmt->execute();
 
$affected_rows = $stmt->rowCount();
if($affected_rows>0){
echo "<script> alert ('Maj effectu�e')</script>";

$messageHistory = "Du nouveau dans votre rubrique histoire : ".$historyTitle;
$method="POST";
$data=array("message" => $messageHistory);
$url=$GCM_URL;
CallAPI($method, $url, $data);

 
} else {
echo "<script> alert ('Maj �chou�e')</script>";
}
 
echo "<script> window.location.href='history.php'</script>";
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