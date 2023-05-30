<?php
// Declaramos las variables de conexión
$ServerName = "bgyblvzwghp6";
$Username = "uckozme1gr";
$Password ="CANF77o1nTpZa";
$NameBD = "bgyblvzwsgesu";

// Creamos la conexión con MySQL
$conex2 = new mysqli($ServerName, $Username, $Password, $NameBD);

// Revisamos la Conexión MySQL
if ($conex2->connect_error) {
    die("Ha fallado la conexión: " . $conex2->connect_error);
}
?>
