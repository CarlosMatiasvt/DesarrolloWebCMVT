<?php

$operacion = $_POST["operacion"];
$n = $_POST["n"];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tabla</title>

<style>

body{
font-family: Arial;
text-align:center;
}

table{
margin:auto;
border-collapse:collapse;
}

td,th{
border:1px solid #ccc;
padding:8px;
width:40px;
}

th{
background:#F79646;
color:white;
}

</style>

</head>

<body>

<h2>Tabla de <?php echo ucfirst($operacion); ?></h2>

<table>

<tr>
<th></th>

<?php
for($i=1;$i<=$n;$i++){
echo "<th>$i</th>";
}
?>

</tr>

<?php

for($fila=1;$fila<=$n;$fila++){

echo "<tr>";
echo "<th>$fila</th>";

for($col=1;$col<=$n;$col++){

switch($operacion){

case "suma":
$resultado = $fila + $col;
break;

case "resta":
$resultado = $fila - $col;
break;

case "multiplicacion":
$resultado = $fila * $col;
break;

case "division":
$resultado = $col!=0 ? round($fila/$col,2) : 0;
break;

}

echo "<td>$resultado</td>";

}

echo "</tr>";

}

?>

</table>

</body>
</html>