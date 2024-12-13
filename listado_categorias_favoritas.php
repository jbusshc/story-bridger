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
    <title>Story Bridger: Categorías favoritas</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

    <?php include 'barra_principal.php';?>
    <h1 align="center">Tus categorías favoritas</h1>

    <div class="catalogo">
            <!-- Categorías a mostrar -->
            <?php
            require_once "config.php";
            global $conn;

            //Realizar consulta para obtener categorías desde la base de datos

            $query = "SELECT CATEGORIA_NOM
            FROM CATEGORIA, CATEGORIAF
            WHERE CATEGORIA_ID = CATEGORIAF_IDC
            AND CATEGORIAF_IDU = {$_SESSION['usu_id']};";

            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                echo '<div class="catalogo">';
                echo '<ul>';
                echo '<li style="font-size: larger;">' . $row['CATEGORIA_NOM'] . '</li>';
                echo '<ul>';
                echo '</div>';
            }

            //Cerrar conexión a la base de datos
            $conn->close();
            ?>
        </div>
    
</body>
</html>


