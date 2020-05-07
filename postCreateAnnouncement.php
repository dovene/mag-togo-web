<?php 
// response json
$json = array();
$result =array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */
 

function storeFile($img){
  define('UPLOAD_DIR', 'announces/');
//	$img = $_POST['img'];
	//$img = str_replace('data:image/png;base64,', '', $img);
	//$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.jpg';
	$success = file_put_contents($file, $data);
  //print $success ? $file : 'Unable to save the file.';
  return 	$file;
}



if (isset($_POST['content']) && isset($_POST['tel']) && isset($_POST['email'])
 && isset($_POST['libCategory'])&& isset($_POST['username'])) {
    $username = $_POST['username']; 
  $content = $_POST['content']; 
  $email = $_POST['email']; 
 $tel = $_POST['tel']; 
  $libCategory = $_POST['libCategory']; 
 
if (isset($_POST['imageOne'])) {
$imageOne = storeFile($_POST['imageOne']); }
else {
$imageOne ="";}


if (isset($_POST['imageTwo'])) {
$imageTwo = storeFile($_POST['imageTwo']);  }
else {
$imageTwo ="";}
  


$qur = $db->prepare("select content from ANNOUNCEMENTS where username=:username and content=:content");			
$qur->bindValue(':username', $username , PDO::PARAM_STR);
$qur->bindValue(':content', $content , PDO::PARAM_STR);
$qur->execute();
$rows = $qur->fetchAll(PDO::FETCH_ASSOC);
$count = (int) $qur->fetchColumn();
$nb=$qur->fetchColumn();      
 

$nbint= (int) $qur->rowCount();  

 
if ($nbint<1){
$stmt = $db->prepare("INSERT INTO ANNOUNCEMENTS(content,tel,email,libCategory, username, created_at,imageOnePath,imageTwoPath)
                                        VALUES(:content,:tel,:email,:libCategory,:username, NOW(),:imageOne,:imageTwo)");
$stmt->execute(array(':username' => $username, ':content' => $content, ':email' => $email, 
                                             ':tel' => $tel, ':libCategory' => $libCategory,':imageOne' => $imageOne,':imageTwo' => $imageTwo ));
 
$affected_rows = $stmt->rowCount();

	if ($affected_rows>0) {

      $json = array("status" => 1,"message" => "Annonce créée avec succès", "info" => $result);
	} else {
    
       $json = array("status" => 0,"message" => "Impossible de créer l'annonce, réessayer en modifiant vos données", "info" => $result);
	}
}else{
$json = array("status" => -1,"message" => "Vous avez déjà publié une annonce identique", "info" => $result);
}
 $db = null;  
} else {
    // required user details are not received 
    $json = array("status" => -2,"message" => "Impossible de créer l'annonce", "info" => $result);

}
/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			