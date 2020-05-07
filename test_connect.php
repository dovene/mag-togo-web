<?php

include_once('config.php');
 $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);  
        
if (!$link) {
   die('Impossible de se connecter : ' . mysql_error());
}

// Rendre la base de données foo, la base courante
$db_selected = mysql_select_db(DB_DATABASE, $link);
if (!$db_selected) {
   die ('Impossible de sélectionner la base de données : ' . mysql_error());
}
?>