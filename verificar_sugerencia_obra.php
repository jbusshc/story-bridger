<?php

    include "config.php";
    include "gestion_sugerencias_funciones.php";
    session_start();
    if($_SESSION['usu_tipo'] != 2) {
        header("Location: denegado.php");
    }
    

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $error = $_GET['error_anio'];
    }


    global $conn;

    $sql = "SELECT * FROM USUARIO, SUGOBRA, TOBRA WHERE USUARIO_ID = SUGOBRA_IDU AND SUGOBRA_TIPO = TOBRA_ID AND SUGOBRA_ESTADO = 1";
    $result = $conn->query($sql);
    $sug_categoria = array();
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sug_categoria[] = $row;
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Bridger: Verificar sugerencias de obra</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        td form {
            display: inline-block; /* Hace que los formularios se muestren en línea */
            margin-right: 10px; /* Añade un margen entre los formularios */
        }
    </style>
</head>
<body>
    <?php include 'barra_principal.php'; ?>
    <div align="center">
        <h1>Verificar sugerencias de obra</h1>
    <table>
            
            <tr>
                <th>Usuario</th>
                <th>Obra</th>
                <th>Tipo</th>
                <th>ID</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
    
            <?php foreach($sug_categoria as $sug) { ?>
                <tr>
                    <td><?php echo $sug['USUARIO_NOM']; ?> </td>
                    <td><?php echo $sug['SUGOBRA_NOM']; ?></td>
                    <td><?php echo $sug['TOBRA_NOM']; ?></td>
                    <td><?php echo $sug['SUGOBRA_ID']; ?></td>

                    <div align="center">
                        <td>

                        <form method="POST" action="editar_sugerencia.php">
                            <input type="hidden" name="id_sug" value="<?php echo $sug['SUGOBRA_ID']; ?>">
                            <input type="hidden" name="tipo_sg" value="1">
                            <input type="hidden" name="tobra" value="<?php echo $sug['SUGOBRA_TIPO']; ?>">
                            <input type="hidden" name ="estado" value="1">
                            <input class="button-actualizar" type="submit" value="Ver/editar sugerencia">
                        </form>

                        </td>
                        <td>   

                        <form method="POST" action="gestion_sugerencias.php">
                            <input type="hidden" name="id_sug" value="<?php echo $sug['SUGOBRA_ID']; ?>">
                            <input type="hidden" name="tipo_sg" value="1">
                            <input type="hidden" name ="estado" value="2">
                            <input type="hidden" name="accion" value="2">
                            <input class="button-crear" type="submit" value="Aceptar">
                        </form>

                        </td>
                        <td>
                        
                        <form method="POST" action="gestion_sugerencias.php">
                            <input type="hidden" name="id_sug" value="<?php echo $sug['SUGOBRA_ID']; ?>">
                            <input type="hidden" name="tipo_sg" value="1">
                            <input type="hidden" name ="estado" value="3">
                            <input type="hidden" name="accion" value="2">
                            <input class="button-eliminar" type="submit" value="Rechazar">
                        </form>

                        </td>

                    </div>

                </tr>
            <?php } ?>
    </table>
            </div>
</body>
</html>