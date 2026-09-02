<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Pizarra</title>
</head>
<body>
    <form action="menu3.php" method="POST">
        <label for="palabra">Palabra:</label>
        <input type="text" name="palabra" id="palabra" required>
        <br><br>
        <label for="color">Color de texto:</label>
        <input type="text" name="color" id="color" placeholder="ej: white o #FFFFFF" required>
        <br><br>
        <label for="color_fondo">Color de fondo:</label>
        <input type="text" name="color_fondo" id="color_fondo" placeholder="ej: blue o #0000FF" required>
        <br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>