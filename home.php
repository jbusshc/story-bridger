<?php

    session_start();

    if(!isset($_SESSION['usu_id']))
        $_SESSION['usu_tipo'] = 4;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Bridger</title>
    <link rel="stylesheet" href="estilo.css"> 
</head>
<body>

    <?php 
        if($_SESSION['usu_tipo'] == 4){
            include 'barra_principal_visitante.php';
        }elseif($_SESSION['usu_tipo'] == 3){
            include 'barra_principal_usuario.php';
        }elseif($_SESSION['usu_tipo'] == 2){
            include 'barra_principal_mod.php';
        }elseif($_SESSION['usu_tipo'] == 1){
            include 'barra_principal_admin.php';
        } 
    ?>

    <main>

        <h1 align="center">Algunas obras del catálogo...</h1>
        <div class="catalogo">
            <!-- Obras a mostrar -->
            <?php
            include "config.php";

            //Realizar consulta para obtener obras desde la base de datos
            $query = "SELECT * FROM OBRA ORDER BY RAND() LIMIT 9";
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
    </main>

    <!-- pie de pagina -->
    <footer>
        <p align="center" style="font-style: italic;">Story Bridger, 2023</p>
    </footer>
</body>
</html>
