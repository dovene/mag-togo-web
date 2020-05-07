<html>
<head>
 <meta charset="utf-8"> 
 <title>GCM Demo application</title>
</head>
<body>
 <?php 
 
//checking if form was submitted
if(isset($_POST['submit']))
{  
	// connection to mysql
	$con = mysqli_connect("localhost", "1046480","DOM2001free2001");
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
$message = $_POST['message'];
 
//This Wont Send Notification to Device but gives you response to remove canonical ids
$dry_run = true;
SendGcmNotification($message, $dry_run);
 
// Finally Get updated Registration Ids from table and send to GCM Server with
$dry_run = false;
SendGcmNotification($message, $dry_run);
}
 
// Method to send Notification to GCM Server
function SendGcmNotification($message, $dry_run)
{
	// New empty Array for storing registration ids
	$registration_ids = array();
	// Query to select all the registered users from table
	$sql = "SELECT * FROM gcm_users_test";
	// Perform Query
	$result = query($sql);
	// Use the result to add the registration ids to the registration_ids array
	while($row = mysqli_fetch_assoc($result))
	{   
		array_push($registration_ids, $row['gcm_regid']);
		echo "SELECTED ID".$row['gcm_regid'];
	}
 
	// default link from the Google to send the notification
	//$url = 'https://android.googleapis.com/gcm/send';
	$url = 'https://fcm.googleapis.com/fcm/send';
 
    $message = array("message" => $_POST['message']);
	$fields = array(
	 'registration_ids' => $registration_ids,
	 'data' => $message,
	);
 
	$headers = array(
	 //'Authorization: key=AIzaSyCzG3bKCaG_g3mwBPDZc1-qjoibeEE3v0M',
	 'Authorization: key=AAAAX6W8Dbc:APA91bGFZFiw3qHzSqHOkP8FPPbC4K_FDg6mqEG-rykGNGMeD7OwIldH6zt1gGgF3952tzl9nKqLt9JOsba7yX_xLnV7hyQ37fn8WU0TTcf33Sh3B206wQXlLcfkp7t81iIRRpRl-dBC',
	 'Content-Type: application/json'
	);
	// Open connection
	$ch = curl_init();
 
	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
 
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
	// Disabling SSL Certificate support temporarly
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
 
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
	// Execute post
	$result = curl_exec($ch);
	if ($result === FALSE) {
	 die('Curl failed: ' . curl_error($ch));
	}
 
	// Close connection
	curl_close($ch);
 
	if($dry_run)
	{
		// Remove or Update Ids if possible
		checkForErrors($result, $registration_ids);
	} 
	else
	{
	echo "affichage des resultats succees";
		// Displaying results
		echo $result;
	}
}
 
function checkForErrors($result, $registration_ids)
{
echo "checkForErrors".$result."-".$registration_ids;	
	// decoding the json array from the result
	$jsonArray = json_decode($result);
 
	if($jsonArray->canonical_ids != 0 || $jsonArray->failure != 0)
	{
		if(!empty($jsonArray->results))
		{
			for($i = 0 ; $i<count($jsonArray->results) ; $i++)
			{
				$result = $jsonArray->results[$i];
				if(isset($result->message_id) && isset($result->registration_id))
				{
					// You should replace the original ID with the new value (canonical ID) in your server database
					$sql = "UPDATE gcm_users_test SET gcm_regid = '$result->registration_id' WHERE gcm_regid = '$registration_ids[$i]'";  	
                    echo "MySQL Reports: UPDATE".$registration_ids[$i];			
				}
				else
				{
					if(isset($result->error))
					{
						switch ($result->error)
						{
							case "NotRegistered":
							case "InvalidRegistration":
								// You should remove the registration ID from your server database
								$sql = "DELETE FROM gcm_users_test WHERE gcm_regid = '$registration_ids[$i]'"; 
                                echo "MySQL Reports: DELETE".$registration_ids[$i];
								break;
							case "Unavailable":
							case "InternalServerError":
								// You could retry to send it late in another request.
								break;
							case "MissingRegistration":
								// Check that the request contains a registration ID
								break;
							case "InvalidPackageName":
								// Make sure the message was addressed to a registration ID whose package name matches the value passed in the request.
								break;
							case "MismatchSenderId":
								// Invalid SENDER_ID
								break;
							case "MessageTooBig":
								// Check that the total size of the payload data included in a message does not exceed 4096 bytes
								break;
							case "InvalidDataKey":
								// Check that the payload data does not contain a key that is used internally by GCM.
								break;
							case "InvalidTtl":
								// Check that the value used in time_to_live is an integer representing a duration in seconds between 0 and 2,419,200.
								break;
							case "DeviceMessageRateExceed":
								// Reduce the number of messages sent to this device
								break;
 
						}
					}
				}
 
				if (!empty($sql)) 
				{
					query($sql);
                   echo "Appel sql: " . $sql;
				} 
			}
		}
	}	  
}
function query($sql) 
{
	global $con;
	if(!($result = mysqli_query($sql, $con)))
	{
		die ( "MySQL Reports: " . mysqli_error());
	}else{
		echo "Appel effectu� " . $result;
	}
	return $result;
}
 
 ?>
 
<center>
<div style="border:#26ce21 thick solid;padding:20px;margin-top:20%;width:70%;text-align:center;text-size:30px;">
 <form method="post" action="gcm_helper.php">
<h2 style="color:#26ce21">GCM Demo</h2>
  <label>Insert Message: </label><input type="text" name="message" />
 
  <input type="submit" name="submit" value="Send" />
 </form>
</div>
</center>
</body>
</html>
