<?php 
// response json
$json = array();
 include_once('pdo_db_config.php');
/**
 * Registering a user device
 * Store reg id in users table
 */

if (isset($_GET['espacecommercial'])) {
    $solde = $_GET['solde'];
    $factureclient = $_GET['factureclient'];
    $reglementhorsfactureclient = $_GET['reglementhorsfactureclient'];
    $reglementfactureclient = $_GET['reglementfactureclient'];
    $facturefour = $_GET['facturefour'];
    $reglementfacturefour = $_GET['reglementfacturefour'];
    $reglementhorsfacturefour = $_GET['reglementhorsfacturefour'];
    $tvaclient = $_GET['tvaclient'];
    $tvafour = $_GET['tvafour'];
    $compte = $_GET['compte'];
    $encaissement = $_GET['encaissement']; 
    $decaissement = $_GET['decaissement']; 
    $datedebut = $_GET['datedebut']; 
    $datefin = $_GET['datefin']; 
    $espacecommercial = $_GET['espacecommercial']; 

$stmt = $db->prepare("DELETE FROM gold WHERE espacecommercial=:espacecommercial");
$stmt->bindValue(':espacecommercial', $espacecommercial, PDO::PARAM_STR);
$stmt->execute();
      
$st = $db->prepare("INSERT INTO gold(solde, totalfactureclient, totalreglementclient, totalreglementhorsclient, totaltvaclient, totaltvafour, totalreglementfour, totalreglementhorsfacturefour, totalfacturefour, comptetresorerie, encaissement, decaissement, datedebut, datefin, espacecommercial )
                   VALUES(:solde, :totalfactureclient, :totalreglementclient, :totalreglementhorsclient, :totaltvaclient, :totaltvafour, :totalreglementfour, :totalreglementhorsfacturefour, :totalfacturefour, :comptetresorerie, :encaissement, :decaissement, :datebut, :datefin, :espacecommercial)");

$st->execute(array(':solde' => $solde, ':totalfactureclient' => $factureclient,':totalreglementclient' => $reglementfactureclient,':totalreglementhorsclient' => $reglementhorsfactureclient,':totaltvaclient' => $tvaclient,':totaltvafour' => $tvafour,':totalreglementfour' => $reglementfacturefour,':totalreglementhorsfacturefour' => $reglementhorsfacturefour,':totalfacturefour' => $facturefour,':comptetresorerie' => $compte,':encaissement' => $encaissement,':decaissement' => $decaissement,':datebut' => $datedebut,':datefin' => $datefin,':espacecommercial' => $espacecommercial));

$affected_rows = $st->rowCount();
echo "$affected_rows";
	if ($affected_rows>0) {
    echo "New record created successfully";
	} else {
    echo "Error: " ; //. $query . "<br>" . $db->error;
	}

 
 $db = null;  
        
   
} else {
    // required user details are not received 
echo "not received";
}
?>			