<?php 
// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */


if (isset($_POST["regId"])) {
    $gcm_regid = $_POST["regId"]; 
    
    if($gcm_regid==='BLACKLISTED' || $gcm_regid === ''){
            //Do nothing
    }else{
        include_once('config.php');


        // Create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        // for testing purpose use gcm_users_test
        $sql = "INSERT INTO gcm_users (gcm_regid, created_at)
        VALUES ('$gcm_regid', NOW())";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }

   
} else {
    // required user details are not received 
}
?>		