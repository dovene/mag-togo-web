<?php 
// response json
$json = array();
$result =array();

 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * 
 */

if (isset($_POST['record_key']) && isset($_POST['matricule'])) {
    $record_key = $_POST['record_key'];
    $matricule = $_POST['matricule'];
    $matiere = $_POST['matiere'];
    $date = $_POST['date'];
    $periode = $_POST['periode'];
    $annee_scolaire = $_POST['annee_scolaire'];
    $note = $_POST['note'];
    $school_name = $_POST['school_name'];
    $classe = $_POST['classe'];
    $code_access = $_POST['code_access'];

$stmt = $db->prepare("DELETE FROM APP_GOLD_SCHOOL_DATA WHERE record_key=:record_key");
$stmt->bindValue(':record_key', $record_key, PDO::PARAM_STR);
$stmt->execute();
      
$st = $db->prepare("INSERT INTO APP_GOLD_SCHOOL_DATA(record_key, matricule, matiere, date, periode, annee_scolaire, note, school_name, classe, code_access)
                   VALUES(:record_key, :matricule, :matiere, :date, :periode, :annee_scolaire, :note, :school_name, :classe, :code_access)");

$st->execute(array(':record_key' => $record_key, ':matricule' => $matricule,':matiere' => $matiere,':date' => $date,':periode' => $periode,':annee_scolaire' => $annee_scolaire,
':note' => $note,':school_name' => $school_name,':classe' => $classe,':code_access' => $code_access));

$affected_rows = $st->rowCount();
echo "$affected_rows";
	if ($affected_rows>0) {
    echo "New record created successfully";
    $json = array("status" => -1,"message" => "Opération réussie", "info" => $result);
	} else {
    echo "Error: " ; //. $query . "<br>" . $db->error;
      $json = array("status" => -1,"message" => "Opération échouée : cause inconnue", "info" => $result);
	}

 
 $db = null;  
        
   
} else {
    // required user details are not received 
echo "not received";
  $json = array("status" => -2,"message" => "Opération échouée données invalides ", "info" => $result);
}

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>			