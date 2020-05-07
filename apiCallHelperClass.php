<?php
 
class ApiCallHelper {

   var $method;
   var $url;
   var $data = false;
  
   function __construct($pMethod, $pUrl, $pData){
    $this->method = $pMethod;
    $this->url = $pUrl;
    $this->data = $pData;
    }

    function getMethod(){
        return $this->method;
    }

    function setMethod($pMethod){
         $this->method = $pMethod;
    }

    function getUrl(){
        return $this->url;
    }

    function setUrl($pUrl){
         $this->url = $pUrl;
    }

    function getData(){
        return $this->data;
    }

    function setData($pData){
         $this->data = $pData;
    }

    function CallAPI() {
    $curl = curl_init();

    switch ($this->getMethod()){
        case "POST":
           curl_setopt($curl, CURLOPT_POST, 1);
           if ($this->getData())
              curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getData());
           break;
        case "PUT":
           curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
           if ($this->getData())
              curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getData());			 					
           break;
        default:
           if ($this->getData())
              $url = sprintf("%s?%s", $url, http_build_query($this->getData()));
     }
  

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $this->getUrl());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($curl));
    }

    curl_close($curl);

    return $result;
}


public function call() {
        
    include_once './config.php';

    // Set POST request variable
    //$url = 'https://android.googleapis.com/gcm/send';

    $fields = array(
        'registration_ids' => $registatoin_ids,
        'data' =>$message,
    );

    $headers = array(
      //  'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    // Open connection
    $ch = curl_init();

    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $this->getUrl());


//newly added
   curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
   
   

//
   // curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // disable SSL certificate support
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  //  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    // execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    // Close connection
    curl_close($ch);
    return $result;  
}


public function callWithGetContents(){
$response = file_get_contents($this->getUrl());
$response = json_decode($response);
return $response;
}


function callAPIOther(){
    $curl = curl_init();
 
    switch ($this->getMethod()){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($this->getData())
             curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getData());
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($this->getData())
             curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getData());			 					
          break;
       default:
          if ($this->getData())
             $url = sprintf("%s?%s", $url, http_build_query($this->getData()));
    }
 
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $this->getUrl());
    /*curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json',
    ));*/
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
 }

}
 
?>