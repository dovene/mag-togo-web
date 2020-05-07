<?php
	// Include confi.php
	include_once('db_config.php');
	
// response json
$json = array();
$result =array();

if (isset($_GET['code_access'])){
 $code_access=$_GET['code_access'];
	   $qur = $db->prepare('select id, record_key, matricule, code_access, matiere, date, annee_scolaire, periode, note, school_name, classe 
                from APP_GOLD_SCHOOL_DATA
                Where code_access = :code_access
                order by date DESC');		
  $qur->bindValue(':code_access', $code_access, PDO::PARAM_STR);	
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("record_key" =>$r->record_key, "matricule" => $r->matricule, 'code_access' => $r->code_access,
			  'matiere' => $r->matiere, 'date' => $r->date, 
                          'annee_scolaire' => $r->annee_scolaire,'periode' => $r->periode,
                           'note' => $r->note,'school_name' => $r->school_name,
						  'classe' => $r-> classe); 
		}
		$qur->closeCursor(); // on ferme le curseur des rÃ©sultats
		$json = array("status" => 1, "message" => "Succès ", "info" => $result);
	$db = null;
	}else {
        // required user details are not received 
    echo "not received";
      $json = array("status" => -2,"message" => "Opération échouée données invalides ", "info" => $result);
    }
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>