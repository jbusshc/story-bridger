<?php 
    session_start();
?>

<!DOCTYPE html>
  <html>
  <head>
    <title>Story Bridger: Resultados de la búsqueda</title>
    <link href="estilo.css" rel="stylesheet">
  </head>
  <body>

    <?php include 'barra_principal.php'; ?>

    <h1 align="center">Resultados de la búsqueda</h1>

    <div class="catalogo">
    <?php

    require_once 'config.php';

    // Obtener la palabra clave del formulario HTML
    $palabraClave = isset($_POST['palabra_clave']) ? $_POST['palabra_clave'] : '';
    $filtroCategoria = $_POST['categoria'];

    // Verificar la conexión
    if (!$conn) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    // Preparar la consulta SQL
    if (!empty($palabraClave)) {
        if (!empty($filtroCategoria)){

            $obra = NULL;
                foreach ($filtroCategoria as $categoria) { // Buscar coincidencia con cualquiera de los filtros seleccionados
                    $obra = $obra . "CATOBRA_IDC = $categoria OR ";
            }
            
            $obra = rtrim($obra, " OR ");

            $query = "SELECT DISTINCT OBRA_ID, OBRA_NOM, OBRA_ANIO, OBRA_DESC, OBRA_TIPO, OBRA_IMG 
                        FROM OBRA, CATOBRA WHERE  
                        OBRA_NOM LIKE '%$palabraClave%'
                        AND OBRA_ID = CATOBRA_IDO 
                        AND ($obra);";

            $result = $conn->query($query);

        }else{

            $query = "SELECT * FROM OBRA WHERE OBRA_NOM LIKE '%$palabraClave%'";
            $result = $conn->query($query);

        }
    }else{

        if (!empty($filtroCategoria)){
            
            $obra = NULL;
                foreach ($filtroCategoria as $categoria) {
                    $obra = $obra . "CATOBRA_IDC = $categoria OR ";
            }
            
            $obra = rtrim($obra, " OR ");

            $query = "SELECT DISTINCT OBRA_ID, OBRA_NOM, OBRA_ANIO, OBRA_DESC, OBRA_TIPO, OBRA_IMG 
                        FROM OBRA, CATOBRA WHERE  
                        OBRA_ID = CATOBRA_IDO 
                        AND ($obra);";

            $result = $conn->query($query);
            
        }else{

            $query = "SELECT * FROM OBRA";
            $result = $conn->query($query);

        } 

    }

    while ($row = $result->fetch_assoc()) {
        echo '<div class="catalogo">';
        echo '<a href="obra.php?id=' .$row['OBRA_ID'] . '">';
        echo '<h2>' . $row['OBRA_NOM'] . '</h2>';
        echo '<img class="obra" src="' . $row['OBRA_IMG'] . '" alt="' . $row['OBRA_TIPO'] . '">';
        echo '</a>';
        echo '</div>';
    }

    ?>

    </div>
</body>
</html>


