<?php
/*$db_host = 'localhost'; //hostname
$db_user = 'root'; // username
$db_password = ''; // password
$db_name = 'test'; //database name
$conn = mysqli_connect($db_host, $db_user, $db_password );
//mysql_select_db($db_name, $conn);
define('DB_HOST', 'localhost');
define('DB_SCHEMA', 'test');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_ENCODING', 'utf8');
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA;
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
);
if( version_compare(PHP_VERSION, '5.3.6', '<') ){
    if( defined('PDO::MYSQL_ATTR_INIT_COMMAND') ){
        $options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . DB_ENCODING;
    }
}else{
    $dsn .= ';charset=' . DB_ENCODING;
}
$db = @new PDO($dsn, DB_USER, DB_PASSWORD, $options);
if( version_compare(PHP_VERSION, '5.3.6', '<') && !defined('PDO::MYSQL_ATTR_INIT_COMMAND') ){
    $sql = 'SET NAMES ' . DB_ENCODING;
    $db->exec($sql);}*/
    
$PARAM_hote='fdb6.awardspace.net'; // le chemin vers le serveur
$PARAM_port='3306';
$PARAM_nom_bd='1936384_news'; // le nom de votre base de données
$PARAM_utilisateur='1936384_news'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe='DOM2001free2001'; // mot de passe de l'utilisateur pour se connecter

try {
$db = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
//$db -> exec("SET CHARACTER SET utf8");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    some_logging_function($ex->getMessage());
}
?>