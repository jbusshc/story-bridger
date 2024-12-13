<?php
session_start();
if($_SESSION['usu_tipo'] != 3) {
    header("Location: denegado.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Story Bridger: Crear sugerencia de categoría</title>
</head>
<body>
    <?php include 'barra_principal.php' ?>
    <div align="center">
    <h1>Crear sugerencia de categoría</h1>
    <form action="gestion_sugerencias.php" method="post">
        <input class="barra-formulario" type="text" name="nombre" placeholder="Nombre categoría">
        <input type="hidden" name =tipo_sg value = "2" >
        <input type="hidden" name="accion" value = "1">

        <button class="boton-desplegable" type="submit">Enviar</button>
    </form>
</div>
    
</body>
</html>

