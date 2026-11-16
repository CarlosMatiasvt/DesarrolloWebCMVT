<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "bd_recetas.sql";
$puerto = 3306;
$conn =  new mysqli($servidor,$usuario,$clave,$bd,$puerto);

if ($conn -> connect_error){
    die("error:" $conn->connect_error);

}

?>
