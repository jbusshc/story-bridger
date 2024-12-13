<?php
    include "gestion_sugerencias_funciones.php";


    //Verificar credenciales
    session_start();
    if($_SESSION['usu_tipo'] == 4) {
        header("Location: denegado.php");
    }
    /* MÓDULO DE GESTION DE SUGERENCIAS */
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tipo_sg = $_POST['tipo_sg']; //Tipo de sugerencia (OBRA, CATEGORIA, CAT-OBRA)
        $accion = $_POST['accion']; //Tipo de accion (CREAR, VERIFICAR, AÑADIR)
        $flag_error = false;
        $string_error = "?";
        if($accion == 1) { //Crear
        
            if($tipo_sg == 1) { //Obra
                $titulo = $_POST['titulo'];
                $anio = $_POST['anio'];

                $descripcion = $_POST['descripcion'];
                $tipo = $_POST['tipo'];
                $duracion = NULL;
                $director = NULL;
                $capitulos = NULL;
                $temporadas = NULL;
                $desarrollador = NULL;
                $autor = NULL;
                $isbn = NULL;
                if($tipo == 1) {
                    $duracion = $_POST['duracion'];
                    $director = $_POST['director'];

                    if(ctype_digit($anio) == false){
                        $string_error = $string_error . "error_anio=1";
                        $flag_error = true;
                    }
                    if(ctype_digit($duracion) == false){
                        if($flag_error){
                            $string_error = $string_error . "&error_duracion=1";
                        }
                        else{
                            $string_error = $string_error . "error_duracion=1";
                            $flag_error = true;
                        }
                    }

                    $directorio = "IMGSUG/";
                    $time = date("H_i_s");
                    $id = $_SESSION['usu_id']. "_" . $time; 
                    $rutaCompleta = $directorio .$id . "." .pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta);
                    $array = array($titulo, $anio, $descripcion, $tipo, $director ,$duracion, $rutaCompleta);
                    if($flag_error) {
                        header("Location: crear_sugerencia_obra.php" . $string_error);
                    }
                    else {
                        crear_sugerencias($_SESSION['usu_id'], $array ,$tipo_sg);
                        header("Location: sugerencia_exito.php");
                    }
                    
                }
                else if($tipo == 2) {
                    $director = $_POST['director'];
                    $capitulos = $_POST['capitulos'];
                    $temporadas = $_POST['temporadas'];
                    //$array = array($titulo, $anio, $descripcion, $tipo, $director, $capitulos, $temporadas);
                    
                    if(ctype_digit($anio) == false){
                        $string_error = $string_error . "error_anio=1";
                        $flag_error = true;
                    }
                    if(ctype_digit($capitulos) == false){
                        if($flag_error){
                            $string_error = $string_error . "&error_capitulos=1";
                        }
                        else{
                            $string_error = $string_error . "error_capitulos=1";
                            $flag_error = true;
                        }
                    }
                    if(ctype_digit($temporadas) == false){
                        if($flag_error){
                            $string_error = $string_error . "&error_temporadas=1";
                        }
                        else{
                            $string_error = $string_error . "error_temporadas=1";
                            $flag_error = true;
                        }
                    }

                    $directorio = "IMGSUG/";
                    $time = date("H_i_s");
                    $id = $_SESSION['usu_id']. "_" . $time;
                    $rutaCompleta = $directorio .$id . "." .pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta);
                    $array = array($titulo, $anio, $descripcion, $tipo, $director ,$capitulos, $temporadas, $rutaCompleta);

                    if($flag_error) {
                        header("Location: crear_sugerencia_obra.php" . $string_error);
                    }
                    else {
                        crear_sugerencias($_SESSION['usu_id'], $array ,$tipo_sg);
                        header("Location: sugerencia_exito.php");
                    }
            
                }
                else if($tipo == 3) {
                    $desarrollador = $_POST['desarrollador'];
                    $duracion = $_POST['duracion'];
                    $plataformas = $_POST['plataforma'];
                    //$array = array($titulo, $anio, $descripcion, $tipo, $desarrollador, $duracion, $plataformas);

                    if(ctype_digit($anio) == false){
                        $string_error = $string_error . "error_anio=1";
                        $flag_error = true;
                    }

                    if(ctype_digit($duracion) == false){
                        if($flag_error){
                            $string_error = $string_error . "&error_duracion=1";
                        }
                        else{
                            $string_error = $string_error . "error_duracion=1";
                            $flag_error = true;
                        }
                    }

                    $directorio = "IMGSUG/";
                    $time = date("H_i_s");
                    $id = $_SESSION['usu_id']. "_" . $time;
                    $rutaCompleta = $directorio .$id . "." .pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta);
                    $array = array($titulo, $anio, $descripcion, $tipo, $desarrollador, $duracion, $plataformas, $rutaCompleta);


                    if($flag_error) {
                        header("Location: crear_sugerencia_obra.php" . $string_error);
                    }
                    else {
                        crear_sugerencias($_SESSION['usu_id'], $array ,$tipo_sg);
                        header("Location: sugerencia_exito.php");
                    }
            
                }
                else if($tipo == 4) {
                    $autor = $_POST['autor'];
                    $isbn = $_POST['isbn'];
                    //$array = array($titulo, $anio, $descripcion, $tipo, $autor, $isbn);

                    if(ctype_digit($anio) == false){
                        $string_error = $string_error . "error_anio=1";
                        $flag_error = true;
                    }

                    $directorio = "IMGSUG/";
                    $time = date("H_i_s");
                    $id = $_SESSION['usu_id']. "_" . $time;
                    $rutaCompleta = $directorio .$id . "." .pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta);
                    $array = array($titulo, $anio, $descripcion, $tipo, $autor, $isbn, $rutaCompleta);

                    
                    if($flag_error) {
                        header("Location: crear_sugerencia_obra.php" . $string_error);
                    }

                    else {
                        crear_sugerencias($_SESSION['usu_id'], $array ,$tipo_sg);
                        header("Location: sugerencia_exito.php");
                    }

                }
            }
            else if($tipo_sg == 2) { //Categoria
                $nombre = $_POST['nombre'];
                crear_sugerencias($_SESSION['usu_id'], $nombre ,$tipo_sg);
                header("Location: sugerencia_exito.php");
            }
            else if($tipo_sg == 3) { //Obra-Categoria
                $idobra = $_POST['idobra'];
                $idcategoria = $_POST['idcategoria'];
                $array = array($idobra, $idcategoria);
                crear_sugerencias($_SESSION['usu_id'], $array ,$tipo_sg);
                header("Location: sugerencia_exito.php");
            }
            else {
                echo "Error en el tipo de sugerencia";
            }
        }
        else if($accion == 2) { //Verificar
            if($tipo_sg == 1) {
                $id_obra = $_POST['id_sug'];
                $estado = $_POST['estado'];
                verificacion_sugerencias($tipo_sg, $estado, $id_obra);
                header("Location: sugerencia_exito.php");
            }            
            else if($tipo_sg == 2) {
                $id_categoria = $_POST['id_sug'];
                $estado = $_POST['estado'];
                $nombre_categoria = $_POST['nombre_categoria'];
                if($estado == 1) {
                    $sql = "UPDATE SUGCATEGORIA SET SUGCATEGORIA_NOM = '$nombre_categoria' WHERE SUGCATEGORIA_ID = $id_categoria";
                    $conn->query($sql);
                } 
                else {
                    verificacion_sugerencias($tipo_sg, $estado, $id_categoria);
                }
                header("Location: sugerencia_exito.php");
            }
            else if($tipo_sg == 3) {
                $id_catobra = $_POST['id_sug'];
                $estado = $_POST['estado'];
                verificacion_sugerencias($tipo_sg, $estado, $id_catobra);
                header("Location: sugerencia_exito.php");
            }
            else {
                echo "Error en el tipo de sugerencia";
            }
        }   
        else if($accion == 3) { //Añadir

            $tipo_sg = $_POST['tipo_sg']; //Tipo de sugerencia (OBRA, CATEGORIA, CAT-OBRA)
            if($tipo_sg == 1) {
                $sql = "SELECT * FROM SUGOBRA";
                $result = $conn->query($sql); 
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $id = $row['SUGOBRA_ID'];
                        aniadir_sugerencia_obra($id);
                    }
                }
            }
            else if($tipo_sg == 2) {
                $sql = "SELECT * FROM SUGCATEGORIA";
                $result = $conn->query($sql); 
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $id = $row['SUGCATEGORIA_ID'];
                        aniadir_sugerencia_categoria($id);
                    }
                }

            }
            else if($tipo_sg == 3) {
                $sql = "SELECT * FROM SUGCATOBRA";
                $result = $conn->query($sql); 
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $id = $row['SUGCATOBRA_ID'];
                        aniadir_sugerencia_categoria_obra($id);
                    }
                }
            }
            else {
                echo "Error en el tipo de sugerencia";
            }
            
        }
    }


 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Story Bridger: Gestión de sugerencias</title>
</head>
<body>
    <?php include 'barra_principal.php'; ?>
    <div align="center">
    <h1>Gestión de sugerencias</h1>

    <?php if($_SESSION['usu_tipo'] == 3) { ?>
    <h2>Crear sugerencias</h2>
      <div align="center">
        <form action="crear_sugerencia_obra.php">
          <button class="boton-desplegable" style="font-size:25px;">Crear sugerencia de obra
        </form>
      </div>
      <br> 
      <div align="center">
        <form action="crear_sugerencia_categoria.php">
          <button class="boton-desplegable" style="font-size:25px;">Crear sugerencia de categoría
        </form>
      </div>
      <br> 
      <div align="center">
        <form action="crear_sugerencia_catobra.php">
          <button class="boton-desplegable" style="font-size:25px;">Crear sugerencia de categoría en obra
        </form>
      </div>
    <?php } else if($_SESSION['usu_tipo'] == 1) { ?>
    
            <label for="sugerencia" class="styled-link">
                <form id="formSugerencias" action="gestion_sugerencias.php" method="post">
                    <input type="hidden" name="accion" value="3">
                    <input type="hidden" name="tipo_sg" value="1">
                    <input class="boton-desplegable" type="submit" id="sugerencia" style="font-size: 25px;" value="Añadir sugerencias obra">
                </form>
            </label>    
          <br>
            <label for="sugerencia" class="styled-link">
                <form id="formSugerencias" action="gestion_sugerencias.php" method="post">
                    <input type="hidden" name="accion" value="3">
                    <input type="hidden" name="tipo_sg" value="2">
                    <input class="boton-desplegable" type="submit" id="sugerencia" style="font-size: 25px;" value="Añadir sugerencias categorías">
                </form>
            </label>
            <br>
            <label for="sugerencia" class="styled-link">
                <form id="formSugerencias" action="gestion_sugerencias.php" method="post">
                    <input type="hidden" name="accion" value="3">
                    <input type="hidden" name="tipo_sg" value="3">
                    <input class="boton-desplegable" type="submit" id="sugerencia" style="font-size: 25px;" value="Añadir sugerencias categorías en obra">
                </form>
            </label>
       
    <?php } else if($_SESSION['usu_tipo'] == 2) { ?>

      <div align="center">
        <form action="verificar_sugerencia_obra.php">
          <button class="boton-desplegable" style="font-size:25px;">Verificar sugerencias de obras
        </form>
      </div>
      <br>
      <div align="center">
        <form action="verificar_sugerencia_categoria.php">
          <button class="boton-desplegable" style="font-size:25px;">Verificar sugerencias de categorías
        </form>
      </div>
      <br>
      <div align="center">
        <form action="verificar_sugerencia_catobra.php">
          <button class="boton-desplegable" style="font-size:25px;">Verificar sugerencias de categorías en obras
        </form>
      </div>
      <br>
    <?php } ?>
    </div>
</body>
</html>

