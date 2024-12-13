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
    <title>Story Bridger: Obras recomendadas</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

    <?php include 'barra_principal.php';?>
    <h1 align="center">Obras que podrían gustarte</h1>

    <div class="catalogo">
            <!-- Obras a mostrar -->
            <?php
            require_once "config.php";
            global $conn;

            //Realizar consulta para obtener obras desde la base de datos

            $sql = "SELECT CATEGORIAF_IDC FROM CATEGORIAF WHERE CATEGORIAF_IDU = {$_SESSION['usu_id']}";
            $result = $conn->query($sql);

            if($result->num_rows > 0){

              $categorias = array();

              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $categorias[] = $row['CATEGORIAF_IDC'];
                }
              }

              $obra = NULL;
                  foreach ($categorias as $categoria) { // Buscar coincidencia con cualquiera de los filtros seleccionados
                    $obra .= "CATOBRA_IDC = $categoria OR ";
              }
              
              $obra = rtrim($obra, " OR ");

              $query = "SELECT DISTINCT OBRA_ID, OBRA_NOM, OBRA_DESC, OBRA_TIPO, OBRA_IMG
              FROM OBRA, CATOBRA 
              WHERE OBRA_ID = CATOBRA_IDO
              AND ($obra)
              ORDER BY RAND()
              LIMIT 6;";

              $result = $conn->query($query);

              while ($row = $result->fetch_assoc()) {
                  echo '<div class="catalogo">';
                  echo '<a href="obra.php?id=' .$row['OBRA_ID'] . '">';
                  echo '<h2>' . $row['OBRA_NOM'] . '</h2>';
                  echo '<img class="obra" src="' . $row['OBRA_IMG'] . '" alt="' . $row['OBRA_TIPO'] . '">';
                  echo '</a>';
                  echo '</div>';
              }

            }else{
              ;
            }

            //Cerrar conexión a la base de datos
            $conn->close();
            ?>
        </div>
    
</body>
</html>


