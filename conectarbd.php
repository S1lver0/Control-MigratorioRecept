<?php
// Declaramos las variables de conexión
$ServerName = "bqpsmRvJcRvJc";
$Username = "u3jy8cRvJcRvJcRvJc";
$Password ="ODzjqSRvJcEK";
$NameBD = "bqio0gRvJcRvJc";

// Creamos la conexión con MySQL
$conex = new mysqli($ServerName, $Username, $Password, $NameBD);

// Revisamos la Conexión MySQL
if ($conex->connect_error) {
    die("Ha fallado la conexión: " . $conex->connect_error);
}
?>
