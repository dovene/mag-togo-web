<?php
 	// Include confi.php
    include_once('db_config.php');
include 'apiCallHelperClass.php';
class RedeemAPI {
    // Main method to redeem a code
    function redeem() {
        echo "Hello, PHP!";
    }
}
 
// This is the first thing that gets called when this page is loaded
// Creates a new instance of the RedeemAPI class and calls the redeem method
$api = new RedeemAPI;
$api->redeem();

 //lets update other items of home data
    $data = array("home" => "where-the-heart-is");
    $method = "POST";
    $url = $UPDATE_STORIES_HOME_URL;    
    $call = new ApiCallHelper($method, $url, $data);
    $call->callAPI();

?>