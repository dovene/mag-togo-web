<?php
// response json
$json = array();
$result = array();
include_once 'pdo_db_config.php';
include 'apiCallHelperClass.php';

if (isset($_GET['city'])) {
    $criteria = $_GET['city'];
    $city = $_GET['city'];


/**
 *  "name": "Strasbourg",
  *  "country": "FR",
 *  "name": "Lome",
  *  "country": "TG",
 */

    $date = date('d/m/Y-H:i'); 

    $api_name="Meteo-".$city."-".$date;
    $api_key="";
    if($city=="Strasbourg,FR"){
        $api_key="04668aae9d95ba1ca4cfab76ef29987a";
    }else if($city=="Lome,TG"){
        $api_key="949ced6f614c36c4725caff9f4577b29";
    }else if($city=="Paris,FR"){
        $api_key="8d99bafcd65fe76c46dd9aa54684e079";
    }


   
    $call = new ApiCallHelper('GET', 'http://dovene.coolpage.biz/checkApiCall.php?api_name='.$api_name, false);
    echo ($call->url);

    $result = $call->callAPI();
    $response = json_decode($result, true);
    print_r($response);
    if ($result = $call->callAPI() === false) {
        die("call unsuccessful");
        $json = array("status" => 0, "message" => "Echec", "info" => $result);
    } else {
        $json = array("status" => 1, "message" => "Success", "info" => $result);
        echo ($response['status']);

        if ($response['status'] == "0") {
            echo ("we cool we can make the call");

            // make the call

            $urlApi="http://api.openweathermap.org/data/2.5/weather?q=".$city."&lang=fr&units=metric"."&APPID=".$api_key;

            $callNewsApi = new ApiCallHelper('GET',$urlApi, false);
            $resNewsApi = $callNewsApi->callAPI();
            if ($resNewsApi === false) {
                $json = array("status" => 0, "message" => "Echec", "info" => $result);
            } else {

                //parse and save data
                $responseNewsApi = json_decode($resNewsApi, true);
                //print_r($responseNewsApi);
                $imageUrl = "";
                $description = "";
                foreach ($responseNewsApi['weather'] as $weather) {
                    $imageUrl = $weather['icon'];
                    $description = $weather['description'];
                }

                $imageRoot = "http://openweathermap.org/img/w/";    
                $method = "POST";
                $data = array("city" => $responseNewsApi['name'], 
                "country" => $responseNewsApi['sys']['country'],
                "imageUrl" =>  $imageRoot.$imageUrl.".png" ,
                "description" =>  $description ,
                "tempMin" => $responseNewsApi['main']['temp_min'],
                "tempMax" => $responseNewsApi['main']['temp_max'],
                "temp" => $responseNewsApi['main']['temp'],
                "wind" => $responseNewsApi['wind']['speed'],
                "clouds" => $responseNewsApi['clouds']['all'], 
                "rain" => $responseNewsApi['rain']['3h']);

                echo("tempMin".$responseNewsApi['main']['temp_min']) ;  
                echo("tempMax".$responseNewsApi['main']['temp_max']) ;  
                echo("temp".$responseNewsApi['main']['temp']) ;  
                echo("rain".$responseNewsApi['rain']['3h']) ;  
                echo("clouds".$responseNewsApi['clouds']['all']) ;  
                echo("wind".$responseNewsApi['wind']['speed']) ;      
                

                $url = "http://dovene.coolpage.biz/postMeteo.php";

                $callPostNewsApi = new ApiCallHelper($method, $url, $data);
                $resPostNewsApi = $callPostNewsApi->callAPI();







                //save api_call_info

                $dataPostApiInfo = array("api_name" => $api_name);
                $callPostInfo = new ApiCallHelper('POST', 'http://dovene.coolpage.biz/postApiCallInfo.php', $dataPostApiInfo);
                echo ($call->url);
                $res = $callPostInfo->callAPI();
                if ($res === false) {
                    $json = array("status" => 0, "message" => "Echec", "info" => $result);
                } else {
                    $json = array("status" => 1, "message" => "Success", "info" => $result);
                }

                $json = array("status" => 1, "message" => "Success", "info" => $result);
            }

        } else {
            die($response['status'] . "forget the call");
        }
    }
    die("end");
    $db = null;
} else {
    // required param details are not received
    $json = array("status" => -2, "message" => "Impossible de faire le test, param manquants", "info" => $result);
}
/* Output header */
header('Content-type: application/json');
echo json_encode($json);
