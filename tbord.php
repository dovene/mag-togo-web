<?php
	// Include confi.php
	include_once('pdo_db_config.php');
	
	
		$qur = $db->prepare('select id, solde, totalfactureclient, totalreglementclient, totalreglementhorsclient, 
		totaltvaclient, totaltvafour, totalreglementfour, totalreglementhorsfacturefour, totalfacturefour, comptetresorerie, 
		encaissement, decaissement, datedebut, datefin, espacecommercial from gold');			
		$qur->execute();
		$result =array();
		while($r = $qur->fetch(PDO::FETCH_OBJ)){
			//extract($r);
			$result[] = array("solde" =>$r->solde, "totalfactureclient" => $r->totalfactureclient, 'totalreglementclient' => $r->totalreglementclient,
			  'totalreglementhorsclient' => $r->totalreglementhorsclient, 'totaltvaclient' => $r->totaltvaclient,'totaltvafour' => $r->totaltvafour, 
              'totalreglementfour' => $r->totalreglementfour,'totalreglementhorsfacturefour' => $r->totalreglementhorsfacturefour,'totalfacturefour' => $r->totalfacturefour,
	          'comptetresorerie' => $r->comptetresorerie,'encaissement' => $r->encaissement,'decaissement' => $r->decaissement, 'espacecommercial' => $r->espacecommercial,
	          'datedebut' => $r->datedebut,'datefin' => $r->datefin,'id' => $r->id); 
		}
		$qur->closeCursor(); // on ferme le curseur des résultats
		$json = array("status" => 1, "info" => $result);
	$db = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>