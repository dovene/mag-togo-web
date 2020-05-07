<?php
// response json
$json = array();
$result = array();
include_once 'pdo_db_config.php';
include 'apiCallHelperClass.php';
/**
 * Registering a user device
 * Store reg id in users table
 */

if (isset($_POST['city'])) {

    
    $city = isset($_POST['city']) ? $_POST['city'] : "";
    $country = isset($_POST['country']) ? $_POST['country'] : "";
    $imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : "";
    $description = isset($_POST['description']) ? $_POST['description'] : "";
    $tempMin = isset($_POST['tempMin']) ? $_POST['tempMin'] : 0;
    $tempMax = isset($_POST['tempMax']) ? $_POST['tempMax'] : 0;
    $temp = isset($_POST['temp']) ? $_POST['temp'] : 0;
    $wind = isset($_POST['wind']) ? $_POST['wind'] : 0;
    $clouds = isset($_POST['clouds']) ? $_POST['clouds'] : 0;
    $rain = isset($_POST['rain']) ? $_POST['rain'] : 0;
    $date = date('Y-m-d H:i:s'); 
     


    $nbClicks = rand(25, 50);
    
    // Save data into database
    $query = $db->prepare("INSERT INTO METEO (city,country,imageUrl,description,tempMin,tempMax,temp,wind,clouds,rain,dateMeteo)
                                      VALUES (:city,:country,:imageUrl,:description,:tempMin,:tempMax,:temp,:wind,:clouds,:rain,:dateMeteo)");

    $query->execute(array(':city' => $city, ':country' => $country, ':description' => $description,
        ':imageUrl' => $imageUrl, ':tempMin' => $tempMin, ':tempMax' => $tempMax,
        ':temp' => $temp, ':wind' => $wind, ':clouds' => $clouds, ':rain' => $rain,
        ':dateMeteo' => $date));
    $affected_rows = $query->rowCount();
    if ($affected_rows > 0) {
        $json = array("status" => 1, "message" => "Insertion réussie", "info" => $result);

    } else {
        $json = array("status" => 0, "message" => "Insertion échouée", "info" => $result);

    }

    $db = null;
} else {
    // required param details are not received
    $json = array("status" => -2, "message" => "Impossible de faire l'insertion, param manquants", "info" => $result);
}
/* Output header */
header('Content-type: application/json');
echo json_encode($json);
