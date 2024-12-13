<?php

    include "config.php";

    session_start();
    if($_SESSION['usu_tipo'] != 2) {
        header("Location: denegado.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        global $conn;
        $accion = 0;
        if(isset($_POST['accion'])) {

            $id_sug = $_POST['id_sug'];
            $accion = $_POST['accion'];
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

            $sql = "SELECT SUGOBRA_IMG FROM SUGOBRA WHERE SUGOBRA_ID = $id_sug";
            $result = $conn->query($sql);
            $sug_obra = $result->fetch_assoc();
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                if($sug_obra['SUGOBRA_IMG'] != NULL) {
                    $rutaCompleta = $sug_obra['SUGOBRA_IMG'];
                    if(file_exists($rutaCompleta)) {
                        unlink($rutaCompleta);
                    }
                }
                else {
                    $rutaCompleta = "IMG/".$id_sug.".jpg";                    
                }
                echo $rutaCompleta;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta);
                $sql = "UPDATE SUGOBRA SET SUGOBRA_IMG = '$rutaCompleta' WHERE SUGOBRA_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();
            }
            else 
                echo "No se subió imagen";

            //por eliminar cuando se rechaa nota para dsp

            if($tipo == 1) {
                $duracion = $_POST['duracion'];
                $director = $_POST['director'];


                $sql = "UPDATE SUGPELICULA SET SUGPELICULA_DURACION = $duracion, SUGPELICULA_DIRECTOR = '$director' WHERE SUGPELICULA_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();

                $sql = "UPDATE SUGOBRA SET SUGOBRA_NOM = '$titulo', SUGOBRA_ANIO = $anio, SUGOBRA_DESC = '$descripcion' WHERE SUGOBRA_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();
            }   
            else if($tipo == 2) {
                $director = $_POST['director'];
                $capitulos = $_POST['capitulos'];
                $temporadas = $_POST['temporadas'];

                $sql = "UPDATE SUGSERIE SET SUGSERIE_TEMP = $temporadas, SUGSERIE_CAP = $capitulos, SUGSERIE_DIRECTOR = '$director' WHERE SUGSERIE_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();

                $sql = "UPDATE SUGOBRA SET SUGOBRA_NOM = '$titulo', SUGOBRA_ANIO = $anio, SUGOBRA_DESC = '$descripcion' WHERE SUGOBRA_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();
            }
            else if($tipo == 3) {
                $desarrollador = $_POST['desarrollador'];
                $duracion = $_POST['duracion'];
                
                $plataformas = isset($_POST['plataforma']) ? $_POST['plataforma'] : array();

                if (!empty($plataformas)) {
                    $plat = NULL;
                    $plat2 = NULL;
                
                    foreach ($plataformas as $plataforma) {
                        $plat = $plat . "SUGJPLATAFORMA_IDP = $plataforma OR ";
                        $plat2 = $plat2 . "PLATAFORMA_ID = $plataforma OR ";
                    }
                
                    // QUITAR EL ULTIMO OR
                    $plat = rtrim($plat, " OR ");
                    $plat2 = rtrim($plat2, " OR ");
                
                    //Elimina las plataformas que ya no están seleccionadas
                    $sql = "DELETE FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $id_sug AND SUGJPLATAFORMA_IDP NOT IN (SELECT SUGJPLATAFORMA_IDP FROM SUGJPLATAFORMA WHERE ($plat))";
                    $smtm = $conn->prepare($sql);
                    $smtm->execute();
                
                    //Inserta las plataformas que no estaban antes seleccionadas
                    $sql = "INSERT INTO SUGJPLATAFORMA (SUGJPLATAFORMA_IDS, SUGJPLATAFORMA_IDP) SELECT $id_sug, PLATAFORMA_ID FROM PLATAFORMA WHERE ($plat2) AND PLATAFORMA_ID NOT IN (SELECT SUGJPLATAFORMA_IDP FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $id_sug)";
                    $smtm = $conn->prepare($sql);
                    $smtm->execute();
                }
                else {
                    //Elimina todas las plataformas
                    $sql = "DELETE FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $id_sug";
                    $smtm = $conn->prepare($sql);
                    $smtm->execute();
                }

                //Actualizar datos del formulario
                $sql = "UPDATE SUGJUEGO SET SUGJUEGO_TIEMPO = $duracion, SUGJUEGO_DESARROLLADOR = '$desarrollador' WHERE SUGJUEGO_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();

                $sql = "UPDATE SUGOBRA SET SUGOBRA_NOM = '$titulo', SUGOBRA_ANIO = $anio, SUGOBRA_DESC = '$descripcion' WHERE SUGOBRA_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();

            }
            else if($tipo == 4) {
                $autor = $_POST['autor'];
                $isbn = $_POST['isbn'];

                $sql = "UPDATE SUGLIBRO SET SUGLIBRO_AUTOR = '$autor', SUGLIBRO_ISBN = '$isbn' WHERE SUGLIBRO_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();

                $sql = "UPDATE SUGOBRA SET SUGOBRA_NOM = '$titulo', SUGOBRA_ANIO = $anio, SUGOBRA_DESC = '$descripcion' WHERE SUGOBRA_ID = $id_sug";
                $smtm = $conn->prepare($sql);
                $smtm->execute();
            }
            else {
                echo "Error en el tipo de obra";
            }  
            header("Location: sugerencia_exito.php");
        }

        else {
            $id_sug = $_POST['id_sug'];
            $tipo_sg = $_POST['tipo_sg'];
            $estado = $_POST['estado'];
            $tobra = $_POST['tobra'];
    
            if($tobra == 1) {
                $sql = "SELECT * FROM SUGOBRA, SUGPELICULA WHERE SUGOBRA_ID = SUGPELICULA_ID AND SUGOBRA_ID = $id_sug";
                $result = $conn->query($sql);
                $sug_obra = $result->fetch_assoc();
            } 
            else if($tobra == 2) {
                $sql = "SELECT * FROM SUGOBRA, SUGSERIE WHERE SUGOBRA_ID = SUGSERIE_ID AND SUGOBRA_ID = $id_sug";
                $result = $conn->query($sql);
                $sug_obra = $result->fetch_assoc();
            }
            else if($tobra == 3) {
                $sql = "SELECT * FROM SUGOBRA, SUGJUEGO WHERE SUGOBRA_ID = SUGJUEGO_ID AND SUGOBRA_ID = $id_sug";
                $result = $conn->query($sql);
                $sug_obra = $result->fetch_assoc();
                

                

                $sql = "SELECT * FROM PLATAFORMA";
                $result = $conn->query($sql);
                $plataformas = array();
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $plataformas[] = $row;
                    }
                }
    
                $sql = "SELECT * FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $id_sug";
                $result = $conn->query($sql);
                $plataformas_sug = array();
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $plataformas_sug[] = $row;
                    }
                }
            }
            else if($tobra == 4) {
                $sql = "SELECT * FROM SUGOBRA, SUGLIBRO WHERE SUGOBRA_ID = SUGLIBRO_ID AND SUGOBRA_ID = $id_sug";
                $result = $conn->query($sql);
                $sug_obra = $result->fetch_assoc();
            }
            else {
                echo "Error en el tipo de obra";
            
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Bridger: Editar sugerencia de obra</title>
</head>
<body>

        <?php include 'barra_principal.php'; ?>
        <div align="center">
        <h1> Editar sugerencia de obra</h1>

        <?php if($accion != 1) { ?>
            <img class= "obra" src="<?php echo $sug_obra['SUGOBRA_IMG'];?>" alt="El usuario no ha proporcionado una imagen para la obra"><br>
            <?php if($tobra == 1) { ?>
                <form method = "POST" action="" enctype="multipart/form-data">
                    Título: <input class="barra-formulario" type="text" name = "titulo" placeholder = "Título" value = "<?php echo $sug_obra['SUGOBRA_NOM']; ?>" required>
                    <br>Año:
                    <input class="barra-formulario" type="text" name = "anio" placeholder = "Año" value="<?php echo $sug_obra['SUGOBRA_ANIO']; ?>" required>
                    <br>Descripción:
                    <input class="barra-formulario" type="text" name = "descripcion" placeholder = "Descripción" value="<?php echo $sug_obra['SUGOBRA_DESC']; ?>" required>
                    <br>
                    <input class="barra-formulario" type="hidden" name ="tipo" value = "1" >
                    <input class="barra-formulario" type="hidden" name =tipo_sg value = "1" >
                    <input class="barra-formulario" type="hidden" name="accion" value = "1">
                    Duración: <input class="barra-formulario" type="text" name = "duracion" placeholder = "Duración" value= "<?php echo $sug_obra['SUGPELICULA_DURACION']; ?>" required>
                    <br>Director: 
                    <input class="barra-formulario" type="text" name = "director" placeholder = "Director" value= "<?php echo $sug_obra['SUGPELICULA_DIRECTOR']; ?>" required>
                    <br><br>
                    <input type="hidden" name="id_sug" value = "<?php echo "$id_sug"; ?>">
                    Cambiar imagen
                    <br>
                    <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
                    <br><br>
                    <input class="boton-formulario" type="submit" value="Enviar">
                </form>
        <?php } else if($tobra == 2) { ?>
                <form method = "POST" action="" enctype="multipart/form-data">

                    Título: <input class="barra-formulario" type="text" name = "titulo" placeholder ="Título" value = "<?php echo $sug_obra['SUGOBRA_NOM']; ?>" required>
                    <br>Año: 
                    <input class="barra-formulario" type="text" name = "anio" placeholder ="Año"  value="<?php echo $sug_obra['SUGOBRA_ANIO']; ?>" required>
                    <br>Descripción: 
                    <input class="barra-formulario" type="text" name = "descripcion" placeholder ="Descripción" value="<?php echo $sug_obra['SUGOBRA_DESC']; ?>" required>
                    <br>
                    <input type="hidden" name ="tipo" value = "2" >
                    <input type="hidden" name =tipo_sg value = "1" >
                    <input type="hidden" name="accion" value = "1">
                    Temporadas: <input class="barra-formulario" type="text" name = "temporadas" placeholder ="Temporadas" value= "<?php echo $sug_obra['SUGSERIE_TEMP']; ?>" required>
                    <br> Capítulos: 
                    <input class="barra-formulario" type="text" name = "capitulos" placeholder ="Capítulos" value= "<?php echo $sug_obra['SUGSERIE_CAP']; ?>" required>
                    <br> Director: 
                    <input class="barra-formulario" type="text" name = "director" placeholder = "Director" value= "<?php echo $sug_obra['SUGSERIE_DIRECTOR']; ?>" required>
        
                    <input type="hidden" name="id_sug" value = "<?php echo "$id_sug"; ?>">
                    <br><br>
                    Cambiar imagen
                    <br>
                    <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
                    <br><br>
                    <input class="boton-formulario" type="submit" value="Enviar">
                </form>
        <?php } else if($tobra == 3) { ?>
            <form method = "POST" action="" enctype="multipart/form-data">

                    Título: <input class="barra-formulario" type="text" name = "titulo" placeholder = "Título" value = "<?php echo $sug_obra['SUGOBRA_NOM']; ?>" required>
                    <br>Año: 
                    <input class="barra-formulario" type="text" name = "anio" placeholder = "Año" value="<?php echo $sug_obra['SUGOBRA_ANIO']; ?>" required>
                    <br>Descripción: 
                    <input class="barra-formulario" type="text" name = "descripcion" placeholder = "Descripción" value="<?php echo $sug_obra['SUGOBRA_DESC']; ?>" required>
                    <br>Duración: 
                    <input class="barra-formulario" type="text" name = "duracion" placeholder = "Duración" value ="<?php echo $sug_obra['SUGJUEGO_TIEMPO']; ?>" required >
                    <br> Desarrollador: 
                    <input class="barra-formulario" type="text" name = "desarrollador" placeholder = "Desarrollador" value ="<?php echo $sug_obra['SUGJUEGO_DESARROLLADOR']; ?>" required >
                    <br>
                    <input type="hidden" name ="tipo" value = "3" >
                    <input type="hidden" name =tipo_sg value = "1" >
                    <input type="hidden" name="accion" value = "1">
                    <input type="hidden" name="id_sug" value = "<?php echo "$id_sug"; ?>">
                    <br>
                    Cambiar imagen
                    <br>
                    <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
                    <br><br>
                    <div>
                        <label>Plataformas</label> <br>
                        <?php foreach ($plataformas as $plataforma) { ?>
                            <?php
                            $isChecked = false;
                            foreach ($plataformas_sug as $plataforma_sug) {
                                if ($plataforma['PLATAFORMA_ID'] == $plataforma_sug['SUGJPLATAFORMA_IDP']) {
                                    $isChecked = true;
                                    break;
                                }
                            }
                            ?>
                            <input type="checkbox" name="plataforma[]" value="<?php echo $plataforma['PLATAFORMA_ID']; ?>" id="plataforma_<?php echo $plataforma['PLATAFORMA_ID']; ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                            <label for="plataforma_<?php echo $plataforma['PLATAFORMA_ID']; ?>"><?php echo $plataforma['PLATAFORMA_NOM']; ?></label>
                            <br>
                        <?php } ?>
                    </div>
                    <br>
                    <input class="boton-formulario" type="submit" value="Enviar">
                </form>
        <?php } else if($tobra == 4) { ?>
            <form method = "POST" action="" enctype="multipart/form-data">

                    Título: <input class="barra-formulario" type="text" name = "titulo" placeholder ="Título" value = "<?php echo $sug_obra['SUGOBRA_NOM']; ?>" required>
                    <br>Año: 
                    <input class="barra-formulario" type="text" name = "anio" placeholder ="Año"  value="<?php echo $sug_obra['SUGOBRA_ANIO']; ?>" required>
                    <br>Descripción: 
                    <input class="barra-formulario" type="text" name = "descripcion" placeholder ="Descripción" value="<?php echo $sug_obra['SUGOBRA_DESC']; ?>" required>
                    <br>
                    <input type="hidden" name ="tipo" value = "4" >
                    <input type="hidden" name =tipo_sg value = "1" >
                    <input type="hidden" name="accion" value = "1">
                    Autor: <input class="barra-formulario" type="text" name = "autor" placeholder ="Autor" value= "<?php echo $sug_obra['SUGLIBRO_AUTOR']; ?>" required>
                    <br>ISBN: 
                    <input class="barra-formulario" type="text" name = "isbn" placeholder ="ISBN" value= "<?php echo $sug_obra['SUGLIBRO_ISBN']; ?>" required>
                    
                    <input type="hidden" name="id_sug" value = "<?php echo "$id_sug"; ?>">
                    <br><br>
                    Cambiar imagen
                    <br>
                    <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
                    <br><br>
                    <input class="boton-formulario" type="submit" value="Enviar">
                </form>
        <?php } ?>
    <?php } ?>
        </div>
</body>
</html>