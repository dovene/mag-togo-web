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
$reply = $_POST['reply'];
$from = $_POST['from'];
$nameFrom = $_POST['nameFrom'];
$log="enter";

//test($to);
mail_attachement($to, $sujet, $message, $fichier, $typemime, $nom, $reply, $from, $nameFrom );

}
 function mail_attachement($to, $subject, $message, $fichier, $typemime, $nom, $reply, $from, $nameFrom){ 
  
  $entetedate  = date("D, j M Y H:i:s -0600"); // Offset horaire
//$subject = 'the subject';
//$message = 'hello';
$headers .= "Reply-To: ".$nameFrom." <".$reply.">\r\n"; 
  $headers .= "Return-Path: ".$nameFrom." <".$from.">\r\n"; 
  $headers .= "From: ".$nameFrom." <".$from.">\r\n"; 
   $headers .= "Organization: ".$nameFrom."\r\n";
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