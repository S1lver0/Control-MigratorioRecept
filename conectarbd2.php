<?php
// Declaramos las variables de conexión
$ServerName = "bgyblvzwghogtp6sgesu-mysql.services.clever-cloud.com";
$Username = "uckozme169fkvhgr";
$Password ="CANF77o2GlqzmT1nTpZa";
$NameBD = "bgyblvzwghogtp6sgesu";

// Creamos la conexión con MySQL
$conex2 = new mysqli($ServerName, $Username, $Password, $NameBD);

// Revisamos la Conexión MySQL
if ($conex2->connect_error) {
    die("Ha fallado la conexión: " . $conex2->connect_error);
}
?>