<?php
// response json
$json = array();
$result = array();
include_once 'pdo_db_config.php';
include 'apiCallHelperClass.php';

if (isset($_GET['test'])) {
    $test = $_GET['test'];
/*
    $data_array =  array(
        "customer"        => $user['User']['customer_id'],
        "payment"         => array(
              "number"         => $this->request->data['account'],
              "routing"        => $this->request->data['routing'],
              "method"         => $this->request->data['method']
        ),
  );
  
  $make_call = callAPI('POST', 'https://api.example.com/post_url/', json_encode($data_array));
  $response = json_decode($make_call, true);
  $errors   = $response['response']['errors'];
  $data     = $response['response']['data'][0];*/



    $method = "POST";
    $data = array("title" => "News", "content" => "Content");

    $url = "http://dovene.coolpage.biz/postNews.php";

    $call = new ApiCallHelper($method, $url, $data);
    echo ($call->url);
    $result = $call->callAPI();

    if ($result === false) {
        $json = array("status" => 0, "message" => "Echec", "info" => $result);
    } else {
        $json = array("status" => 1, "message" => "Success", "info" => $result);
    }

    $db = null;
} else {
    // required param details are not received
    $json = array("status" => -2, "message" => "Impossible de faire le test, param manquants", "info" => $result);
}
/* Output header */
header('Content-type: application/json');
echo json_encode($json);
