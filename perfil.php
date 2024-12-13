<?php
  session_start();
  if($_SESSION['usu_tipo'] == 4){
    header('Location: denegado.php');
    exit;
  }
?>

<!DOCTYPE html>
  <html>
  <head>
    <title>Story Bridger: Mis favoritos</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

    <?php include 'barra_principal.php'; ?>
    <br>
    <div align="center">
    
      <form action="listado_obras_recomendadas.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Ver obras recomendadas
      </form>
    </div>
    <br>
    <div align="center">

      <form action="listado_obras_favoritas.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Ver obras favoritas
      </form>
    </div>
    <br>
    <div align="center">
      <form action="listado_categorias_favoritas.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Ver categorías favoritas
      </form>
    </div>
    <br>
    <div align="center">
      <form action="sa_obra_favorita.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Añadir obra favorita
      </form>
    </div>
    <br>
    <div align="center">
      <form action="se_obra_favorita.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Eliminar obra favorita
      </form>
    </div>
    <br>
    <div align="center">
      <form action="sa_categoria_favorita.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Añadir categoría favorita
      </form>
    </div>
    <br>
    <div align="center" class="boton-perfil">
      <form action="se_categoria_favorita.php" method="post">
        <button class="boton-desplegable" style="font-size:25px;">Eliminar categoría favorita
      </form>
    </div>


    
  </body>

    <footer>
        <p align="center" style="font-style: italic;">Story Bridger, 2023</p>
    </footer>
</html>


