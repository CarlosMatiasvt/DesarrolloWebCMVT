<?php
  $servidor = "127.0.0.1";
  $usuario  = "root";
  $clave    = "";
  $bd       = "bd_elecciones26";
  $conn = new mysqli($servidor, $usuario, $clave, $bd, 3307);

  if ($conn->connect_error) {
      die("Error: " . $conn->connect_error);
  }
  $conn->set_charset("utf8"); // opcional para no tener problemas con acentos 
?>
