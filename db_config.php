<?php
include_once 'config_urls.php';
$PARAM_hote='localhost'; // le chemin vers le serveur
$PARAM_port='3306';
$PARAM_nom_bd='1046480'; // le nom de votre base de données
$PARAM_utilisateur='1046480'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe='DOM2001free2001'; // mot de passe de l'utilisateur pour se connecter

try {
$db = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
//$db -> exec("SET CHARACTER SET utf8");
$db -> exec('SET NAMES utf8'); // METHOD #3
$db -> exec('SET CHARACTER SET utf8'); // METHOD #4
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    some_logging_function($ex->getMessage());
}
?>