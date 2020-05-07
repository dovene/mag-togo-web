<?php 
// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */

    if (isset($_POST["message"])) {
    $gcm_msg = $_POST["message"]; 
    
    include_once './db_functions.php';
    include_once './gcm_sendmsg.php';
 
    $db = new DB_Functions();
    $gcm = new GCM_SendMsg();
    $users = $db->getAllUsers();
    $message = array("message" => $gcm_msg);
    
        if ($users != false)
            $no_of_users = mysql_num_rows($users);
        else
            $no_of_users = 0;
        
    if ($no_of_users > 0) {
    $n = 0;
     while ($row = mysql_fetch_array($users)) {
     $n++;
     echo $n, $row["gcm_regid"];
     
     $registatoin_ids = array($row["gcm_regid"]);
     
     $result = $gcm->send_notification($registatoin_ids, $message);
    } 
    }  else {
    echo 'no user registered';
    }
    
} else {
    echo 'no message sent';
}
    
?>