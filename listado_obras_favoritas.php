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
    <title>Story Bridger: Obras favoritas</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

    <?php include 'barra_principal.php';?>
    <h1 align="center">Tus obras favoritas</h1>

    <div class="catalogo">
            <!-- Obras a mostrar -->
            <?php
            require_once "config.php";
            global $conn;

            //Realizar consulta para obtener obras desde la base de datos

            $query = "SELECT DISTINCT OBRA_ID, OBRA_NOM, OBRA_IMG, OBRA_TIPO 
            FROM OBRA, OBRAF 
            WHERE OBRA_ID = OBRAF_IDO
            AND OBRAF_IDU = {$_SESSION['usu_id']};";

            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                echo '<div class="catalogo">';
                echo '<a href="obra.php?id=' .$row['OBRA_ID'] . '">';
                echo '<h2>' . $row['OBRA_NOM'] . '</h2>';
                echo '<img class="obra" src="' . $row['OBRA_IMG'] . '" alt="' . $row['OBRA_TIPO'] . '">';
                echo '</a>';
                echo '</div>';
            }

            //Cerrar conexión a la base de datos
            $conn->close();
            ?>
        </div>
    
</body>
</html>


