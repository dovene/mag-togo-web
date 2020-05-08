<?php
// response json
$json = array();
$result = array();
include_once 'pdo_db_config.php';
include 'apiCallHelperClass.php';

if (isset($_GET['criteria'])) {
    $criteria = $_GET['criteria'];

    $call = new ApiCallHelper('GET', $CHECK_METEO_API_HELPER, false);
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

            $callNewsApi = new ApiCallHelper('GET',
                'https://newsapi.org/v2/everything?q='.$criteria.'&language=fr&sortBy=publishedAt&pageSize=5&apiKey=3c64229b4fe0482ea8cf241bcf910ac6', false);
            $resNewsApi = $callNewsApi->callAPI();
            if ($resNewsApi === false) {
                $json = array("status" => 0, "message" => "Echec", "info" => $result);
            } else {

                //parse and save data
                $responseNewsApi = json_decode($resNewsApi, true);
                //print_r($responseNewsApi);
                $inc = 0;    
                foreach ($responseNewsApi['articles'] as $article) {

                   /* echo ("Title" . $article['title']);
                    echo ("Desc" . $article['description']);
                    echo ("urlToImage" . $article['urlToImage']);
                    echo ("author" . $article['author']);
                    echo ("Url" . $article['url']);
                    echo ("publishedAt" . $article['publishedAt']);

                    echo ("SourceId" . $article['source']['id']);
                    echo ("SourceName" . $article['source']['name']);*/

                    //save into our database
                  
                    $sendPush = "0";
                    if($inc==0){
                        $sendPush = "1";     
                    }

                    $method = "POST";
                    $data = array("title" => $article['title'], 
                    "content" => $article['description']." ".$article['author'],
                    "category" => "Divers",
                    "image" => $article['urlToImage'],
                    "sourceUrl" => $article['url'],
                    "publicationDate" => $article['publishedAt'],
                    "source" => $article['source']['name'],
                    "newsOrigin" => "external",
                    "sendPush" => $sendPush, 
                    "imageOrigin" => "external");

                    $url = $NEWS_POST_URL;

                    $callPostNewsApi = new ApiCallHelper($method, $url, $data);
                    $resPostNewsApi = $callPostNewsApi->callAPI();

                    $inc++;

                }
                //save api_call_info

                $dataPostApiInfo = array("api_name" => "news");
                $callPostInfo = new ApiCallHelper('POST',$METEO_POST_API, $dataPostApiInfo);
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
