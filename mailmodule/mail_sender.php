<?php
	// Include confi.php
	include_once('db_config.php');
  
  

 
//checking if form was submitted
if(isset($_POST['message']) &&  isset($_POST['to']) && isset($_POST['from'])  && isset($_POST['sujet']) )
{  
	// connection to mysql
	$con = mysql_connect("localhost", "1046480","DOM2001free2001");
	if(!$con)
	{
		die('MySQL connection failed');
	}
 
	//connection to mysql database
	$db = mysql_select_db("1046480");
	if(!$db)
	{
		die('Database selection failed');
	}
$to = $_POST['to'];
$sujet = $_POST['sujet'];
$message = $_POST['message'];
$fichier = $_POST['fichier'];
$typemime = $_POST['typemime'];
$nom = $_POST['nom'];
$reply = $_POST['from'];
$from = $_POST['from'];
$log="enter";

//test($to);
mail_attachement($to, $sujet, $message, $fichier, $typemime, $nom, $reply, $from);

}
 function mail_attachement($to, $subject, $message, $fichier, $typemime, $nom, $reply, $from){ 
  
  $entetedate  = date("D, j M Y H:i:s -0600"); // Offset horaire
//$subject = 'the subject';
//$message = 'hello';
$headers .= "Reply-To: Expediteur <adovene@gmail.com>\r\n"; 
  $headers .= "Return-Path: Expediteur <adovene@gmail.com>\r\n"; 
  $headers .= "From: Expediteur <adovene@gmail.com>\r\n"; 
   $headers .= "Organization: Expediteur\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
  $headers .= "Date: $entetedate \n";
  
 $result= mail($to, $subject, $message, $headers); 
  
$json = array("status" => 1, "info" => $result);
	
header('Content-type: application/json');
echo json_encode($json);
return $result;
}

?>