<?php
    session_start();
    if($_SESSION['usu_tipo'] != 2) {
        header("Location: denegado.php");
    }
    include "config.php";
    include "gestion_sugerencias_funciones.php";

    global $conn;

    $sql = "SELECT * FROM USUARIO, OBRA, CATEGORIA, SUGCATOBRA, SUGE WHERE OBRA_ID = SUGCATOBRA_IDO AND CATEGORIA_ID = SUGCATOBRA_IDC AND USUARIO_ID = SUGCATOBRA_IDU AND SUGCATOBRA_ESTADO = SUGE_ID AND SUGCATOBRA_ESTADO = 1";
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
    <title>Document</title>
    <style>
        td form {
            display: inline-block; /* Hace que los formularios se muestren en línea */
            margin-right: 10px; /* Añade un margen entre los formularios */
        }
    </style>
</head>
<body>
    <?php include 'barra_principal.php'; ?>
    <table>
            
            <tr>
                <th>Usuario</th>
                <th>Obra</th>
                <th>Categoría</th>
                <th></th>
                <th></th>
            </tr>
    
            <?php foreach($sug_categoria as $sug) { ?>
                <tr>
                    <td><?php echo $sug['USUARIO_NOM']; ?> </td>
                    <td><?php echo $sug['OBRA_NOM']; ?></td>
                    <td><?php echo $sug['CATEGORIA_NOM']; ?></td>

                    <td>
                        <form method="POST" action="gestion_sugerencias.php">
                            <input type="hidden" name="id_sug" value="<?php echo $sug['SUGCATOBRA_ID']; ?>">
                            <input type="hidden" name="tipo_sg" value="3">
                            <input type="hidden" name ="estado" value="2">
                            <input type="hidden" name="accion" value="2">
                            <input class="button-crear" type="submit" value="Aceptar">
                        </form>
                    </td>
                    <td>
                        
                        <form method="POST" action="gestion_sugerencias.php">
                            <input type="hidden" name="id_sug" value="<?php echo $sug['SUGCATOBRA_ID']; ?>">
                            <input type="hidden" name="tipo_sg" value="3">
                            <input type="hidden" name ="estado" value="3">
                            <input type="hidden" name="accion" value="2">
                            <input class="button-eliminar" type="submit" value="Rechazar">
                        </form>
                    </td>

                </tr>
            <?php } ?>
    </table>
</body>
</html>