<?php
	// Include confi.php
	include_once('db_config.php');
	include 'apiCallHelperClass.php';

	
if (isset($_GET['city'])){
	$city=$_GET['city'];

	if($city=="Strasbourg"){
        $cityForExtApi="Strasbourg,FR";       
    }else if($city=="Lome"){
		$cityForExtApi="Lome,TG";
    }else {
		$cityForExtApi="";
    }

	$callWeatherExtApi = new ApiCallHelper('GET',
	'http://dovene.coolpage.biz/getMeteoFromExtApi.php?city='.$cityForExtApi, false);
    $callWeatherExtApi->callAPI();



	   $qur = $db->prepare('select id, city, country, imageUrl, description, tempMin, 
				tempMax,temp, wind, clouds, rain, dateMeteo
                from METEO
                Where city=:city
                order by id DESC
                Limit 1
               ');		
           
  $qur->bindValue(':city', $city, PDO::PARAM_STR);				
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("city" =>stripslashes($r->city), "country" => $r->country,
			 'description' => stripslashes($r->description),
			  'imageUrl' => stripslashes($r->imageUrl), 'tempMax' => $r->tempMax, 
                          'tempMin' => $r->tempMin,'temp' => $r->temp,
                           'wind' => $r->wind,'clouds' => $r->clouds,
						  'rain' => $r-> rain,'dateMeteo' => $r-> dateMeteo); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃ©sultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	} else {
        // required param details are not received
        $json = array("status" => -2, "message" => "Requête annulée, param manquants", "info" => $result);
    }
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>