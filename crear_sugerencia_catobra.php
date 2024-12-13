<?php
    session_start();
    if($_SESSION['usu_tipo'] != 3) {
        header("Location: denegado.php");
    }
    include "config.php";
    global $conn;

    //mostrar errores
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    $paso = NULL;
    //Si no hay post
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        $sql = "SELECT * FROM OBRA";
        $result = $conn->query($sql);
        $obras = array();
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $obras[] = $row;
            }
        } 
        $paso = 1;
    } else {
        //Si hay post
        $paso = 2;
        $idobra = $_POST['idobra'];
        $sql = "SELECT * FROM CATEGORIA WHERE CATEGORIA_ID NOT IN (SELECT CATOBRA_IDC FROM CATOBRA WHERE CATOBRA_IDO = $idobra);";
        $result = $conn->query($sql);
        $categorias = array();
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $categorias[] = $row;
            }
        } 
        $paso = 2;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Story Bridger: Crear sugerencia de categoría en obra</title>
</head> 
<body>
    
<?php include 'barra_principal.php';?>

    <div align="center">
    <h1> Crear sugerencia de categoría en obra </h1>

    <?php if($paso == 1) { ?>
        <h3>Paso 1: Elegir obra</h3>
        <form action="" method="post">

        <select name="idobra">
        <?php foreach($obras as $obra) { ?>
            <option value="<?php echo $obra['OBRA_ID']; ?>"><?php echo $obra['OBRA_NOM']; ?></option>
        <?php } ?>
        </select>
            <button class="boton-desplegable" type="submit">Siguiente</button>
        </form>
    <?php } else if($paso == 2) { ?>
        <h3>Paso 2: Elegir categoría</h3>
        <form action="gestion_sugerencias.php" method="post">

        <select name="idcategoria">
        <?php foreach($categorias as $categoria) { ?>
            <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOM']; ?></option>
        <?php } ?>
        </select>
            <input type="hidden" name="idobra" value="<?php echo $idobra; ?>">
            <input type="hidden" name =tipo_sg value = "3" >
            <input type="hidden" name="accion" value = "1">

            <button class="boton-desplegable" type="submit">Enviar</button>
        </form>
    <?php } else {;} ?>
        </div>
</body>
</html>
