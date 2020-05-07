<?php
   ob_start();
   session_start();
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
   
   <head>
     <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>Connexion</title> 
 
    <link href="bootstrap.min.css" rel="stylesheet"> 
    <link href="bootstrap-datepicker.min.css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

    
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
        <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style
    >
      
   </head>
	
   <body>
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
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
      <h2>Enter Username and Password</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
             include_once('db_config.php');
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) 
    {
				$login=$_POST['login'];
				$pass=$_POST['password'];
				
				$qur = $db->prepare('select id, login, pass from ADMIN 
				where login like :paramLogin AND pass like :paramPass');
                $qur->bindValue(':paramLogin', '%'.$login.'%', PDO::PARAM_STR);		
                $qur->bindValue(':paramPass', '%'.$pass.'%', PDO::PARAM_STR);		      		
		       $qur->execute();
		       
		       
		       $nbint= (int) $qur->rowCount();  

 
if ($nbint<1){
$msg = 'Wrong username or password';
}else{
 $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'tutorialspoint';
                  header("Location:articles.php");
                  exit();
                  echo 'You have entered valid use name and password';


}
 $db = null;  
 
 
 
				
				/*
               if ($_POST['username'] == 'Kachylia' &&  $_POST['password'] == '1234') 
                  {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'tutorialspoint';
                  header("Location:articles.php");
                  exit();
                  echo 'You have entered valid use name and password';
               }else {
                  $msg = 'Wrong username or password';
               }*/
               
               
               
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "username = tutorialspoint" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password = 1234" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
			
         Click here to clean <a href = "logout.php" tite = "Logout">Session.
         
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
   </body>
</html>