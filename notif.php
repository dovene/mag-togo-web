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
 
    <title>Mag Togo Notification</title>
 
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
        
        <html>
<form action="sendgcmmessage.php" method="post">
<label for="name">Ecran</label>
<select name="ecran">
<option value="fnDEF">Par Defaut</option>
 <option value="fnIMG">Images</option>
 <option value="fnHIS">Histoires</option>
<option value="fnART">Articles</option>
<option value="fnMUS">Musique</option> 
<option value="fnUNI">Article unique</option>  
</select>
</br></br>
Message : <textarea rows="2"  style="width:400px" type="text" required="required" name="message" value=""  class="form-control" required="required">
Nouvelle publication d'articles dans votre magazine. 
Excellente lecture !!!</textarea>
</br></br>
<input type="submit" value="Send Notification"/>
</form>


        
      </div>
      

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