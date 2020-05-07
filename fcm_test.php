<html>
<head>
 <meta charset="utf-8"> 
 <title>GCM Demo application</title>
</head>
<body>

<?php

if(isset($_POST['submit']))
{ 
$message = $_POST['message'];
$key = $_POST['serverkey'];
$to = $_POST['to'];
$data = array('post_id'=>$message,'post_title'=>'A Blog post');
sendMessage($key,$data,$to);
}
/*  
Parameter Example
	$data = array('post_id'=>'12345','post_title'=>'A Blog post');
	$target = 'single tocken id or topic name';
	or
	$target = array('token1','token2','...'); // up to 1000 in one request
*/
function sendMessage($key,$data,$target){
//FCM api URL
$url = 'https://fcm.googleapis.com/fcm/send';
//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
$server_key = $key;
			
$fields = array();
$fields['data'] = $data;
if(is_array($target)){
	$fields['registration_ids'] = $target;
}else{
	$fields['to'] = $target;
}
//header with content_type api key
$headers = array(
	'Content-Type:application/json',
  'Authorization:key='.$server_key
);
			
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result = curl_exec($ch);
if ($result === FALSE) {
	die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
echo $result;
return $result;
}

?>


<center>
<div style="border:#26ce21 thick solid;padding:20px;margin-top:20%;width:70%;text-align:center;text-size:30px;">
 <form method="post" action="fcm_test.php">
<h2 style="color:#26ce21">GCM Demo</h2>
  <label>Insert Message: </label><input type="text" name="message" />
 <label>Insert to: </label><input type="Dest" name="to" />
 <label>Insert key: </label><input type="Key" name="serverkey" />
 
  <input type="submit" name="submit" value="Send" />
 </form>
</div>
</center>
</body>

<script src="https://www.gstatic.com/firebasejs/3.5.0/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCG1BhabiZ1g49fY_5hejJoremdUaFshe4",
    authDomain: "nofipedia-1b148.firebaseapp.com",
    databaseURL: "https://nofipedia-1b148.firebaseio.com",
    storageBucket: "nofipedia-1b148.appspot.com",
    messagingSenderId: "172151680499"
  };
  firebase.initializeApp(config);
</script>
</html>