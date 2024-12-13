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
    <title>Story Bridger: Añadir obra favorita</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

  <?php include 'barra_principal.php'; ?>

    <div align="center">
      <h1>Añadir obra favorita</h1>
    </div>

  <?php 
      require_once "config.php";
      global $conn;

      $query = "SELECT * FROM OBRA WHERE OBRA_ID NOT IN (SELECT OBRAF_IDO FROM OBRAF WHERE OBRAF_IDU = {$_SESSION['usu_id']})";

      $result = $conn->query($query);
      ?>
      <div align="center" style="margin-top:10vw;">
        <form method="post" action="anadir_obra_favorita.php">
        <label for="obras">Selecciona una obra: </label>
        <select id="opciones" name="obrafav">

      <?php while ($row = $result->fetch_assoc()): ?>
          <option id="obrafav" value="<?php echo $row['OBRA_ID']; ?>" style="font-size: larger;"> <?php echo $row['OBRA_NOM']; ?> </option>';
      <?php endwhile; ?>
        </select>
        <input type="submit" value="Añadir" class="boton-desplegable">
        </form>
        </div>
    
</body>
</html>
