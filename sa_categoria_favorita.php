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
    <title>Story Bridger: Añadir categoría favorita</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

  <?php include 'barra_principal.php'; ?>

    <div align="center">
      <h1>Añadir categoría favorita</h1>
    </div>

  <?php 
      require_once "config.php";
      global $conn;

      $query = "SELECT * FROM CATEGORIA WHERE CATEGORIA_ID NOT IN (SELECT CATEGORIAF_IDC FROM CATEGORIAF WHERE CATEGORIAF_IDU = {$_SESSION['usu_id']})";

      $result = $conn->query($query);
      ?>
      <div align="center" style="margin-top:10vw;">
        <form method="post" action="anadir_categoria_favorita.php">
        <label for="categorias">Selecciona una categoría: </label>
        <select id="opciones" name="catfav">

      <?php while ($row = $result->fetch_assoc()): ?>
          <option id="catfav" value="<?php echo $row['CATEGORIA_ID']; ?>" style="font-size: larger;"> <?php echo $row['CATEGORIA_NOM']; ?> </option>';
      <?php endwhile; ?>
        </select>
        <input type="submit" value="Añadir" class="boton-desplegable">
        </form>
        </div>
    
</body>
</html>
