<?php
    session_start();
    if($_SESSION['usu_tipo'] != 3) {
        header("Location: denegado.php");
    }

    include "config.php";

    $sql = "SELECT * FROM PLATAFORMA";
    $result = $conn->query($sql);
    $plataformas = array();
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $plataformas[] = $row;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        //Verificar si existen las solicitudes get
        if(isset($_GET['error_anio'])) {
            $error_anio = $_GET['error_anio'];
            echo '<p class="texto-error" align="center">Error: El año debe ser un número.</p>';
        }

        if(isset($_GET['error_duracion'])) {
            $error_duracion = $_GET['error_duracion'];
            echo '<p class="texto-error" align="center">Error: La duración debe ser un número.</p>';
        }

        if(isset($_GET['error_capitulos'])) {
            $error_capitulos = $_GET['error_capitulos'];
            echo '<p class="texto-error" align="center">Error: Los capítulos deben ser un número.</p>';
        }

        if(isset($_GET['error_temporadas'])) {
            $error_temporadas = $_GET['error_temporadas'];
            echo '<p class="texto-error" align="center">Error: Las temporadas deben ser un número.</p>';
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Story Bridger: Crear sugerencia de obra</title>
    <style>
        /* Estilos para ocultar todos los textos por defecto */
        .texto {
            display: none;
        }

        /* Mostrar el texto específico cuando la opción está seleccionada */
        #selector1:checked ~ #texto1,
        #selector2:checked ~ #texto2,
        #selector3:checked ~ #texto3,
        #selector4:checked ~ #texto4 {
        display: block;
        }
    </style>
</head>
<body>

    <?php include 'barra_principal.php'; ?>
    

    <!-- SELECTOR -->
    <div align="center">
    <h1>Crear sugerencia de obra</h1>
    <input type="radio" name="selector" id="selector1">
    <label for="selector1">Pelicula</label>

    <input type="radio" name="selector" id="selector2">
    <label for="selector2">Serie</label>

    <input type="radio" name="selector" id="selector3">
    <label for="selector3">Juego</label>

    <input type="radio" name="selector" id="selector4">
    <label for="selector4">Libro</label>


    <!-- FORMULARIO -->
    <div id="texto1" class="texto">
        <form method = "POST" action="gestion_sugerencias.php"  enctype="multipart/form-data">
            <input class = "barra-formulario" type="text" name = "titulo" placeholder = "Título" required>
            <br>
            <input class = "barra-formulario" type="text" name = "anio"  placeholder="Año" required>
            <br>
            <input class = "barra-formulario" type="text" name = "descripcion" placeholder="Descripción" required>
            <input type="hidden" name ="tipo" value = "1" >
            <input type="hidden" name =tipo_sg value = "1" >
            <input type="hidden" name="accion" value = "1">
            <br>
            <input class = "barra-formulario" type="text" name = "duracion" placeholder= "Duración" required>
            <br>
            <input class = "barra-formulario" type="text" name = "director" placeholder= "Director" required>
            <br><br>
             Imagen
             <br>
            <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
            <br><br>
            <input class="boton-formulario" type="submit" value="Enviar">
        </form>
    </div> 
    <div id="texto2" class="texto">
        <form method = "POST" action="gestion_sugerencias.php"  enctype="multipart/form-data">

            <input class = "barra-formulario" type="text" name = "titulo" placeholder = "Título" required>
            <br>
            <input class = "barra-formulario" type="text" name = "anio"  placeholder="Año" required>
            <br>
            <input class = "barra-formulario" type="text" name = "descripcion" placeholder="Descripción" required>
            <br>
            <input type="hidden" name ="tipo" value = "2" >
            <input type="hidden" name =tipo_sg value = "1" >
            <input type="hidden" name="accion" value = "1">

            <input class = "barra-formulario" type="text" name = "director" placeholder= "Director" required>
            <br>
            <input class = "barra-formulario" type="text" name = "capitulos" placeholder= "Capitulos" required>
            <br>
            <input class = "barra-formulario" type="text" name = "temporadas" placeholder= "Temporadas" required>
            <br><br>
            Imagen
            <br>
            <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
            <br><br>
            <input class = "boton-formulario" type="submit" value="Enviar">
        </form>

    </div>
    <div id="texto3" class="texto">
        <form method = "POST" action="gestion_sugerencias.php"  enctype="multipart/form-data">
            <input class = "barra-formulario" type="text" name = "titulo" placeholder = "Título" required>
            <br>
            <input class = "barra-formulario" type="text" name = "anio"  placeholder="Año" required>
            <br>
            <input class = "barra-formulario" type="text" name = "descripcion" placeholder="Descripción" required>
            <br>
            <input type="hidden" name ="tipo" value = "3" >
            <input type="hidden" name =tipo_sg value = "1" >
            <input type="hidden" name="accion" value = "1">

            <input class = "barra-formulario" type="text" name = "duracion" placeholder= "Tiempo estimado" required>
            <br>
            <input class = "barra-formulario" type="text" name = "desarrollador" placeholder= "Desarrollador" required>
            <br><br>
            Imagen
            <br>
            <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
            <br><br>
            <div style="margin:10px;">
                <label>Plataformas</label> <br>
                <?php foreach ($plataformas as $plataforma) { ?>
                    <input type="checkbox" name="plataforma[]" value="<?php echo $plataforma['PLATAFORMA_ID']; ?>" id="plataforma_<?php echo $plataforma['PLATAFORMA_ID']; ?>">
                    <label for="plataforma_<?php echo $plataforma['PLATAFORMA_ID']; ?>"><?php echo $plataforma['PLATAFORMA_NOM']; ?></label>
                    <br>
                <?php } ?>
            </div>
            <br>
            <input class = "boton-formulario" type="submit" value="Enviar">

            


        </form> 
    </div>
    <div id="texto4" class="texto">
        <form method = "POST" action="gestion_sugerencias.php"  enctype="multipart/form-data">
            <input class = "barra-formulario" type="text" name = "titulo" placeholder = "Título" required>
            <br>
            <input class = "barra-formulario" type="text" name = "anio"  placeholder="Año" required>
            <br>
            <input class = "barra-formulario" type="text" name = "descripcion" placeholder="Descripción" required>
            <br>
            <input type="hidden" name ="tipo" value = "4" >
            <input type="hidden" name =tipo_sg value = "1" >
            <input type="hidden" name="accion" value = "1">

            <input class = "barra-formulario" type="text" name = "autor" placeholder= "Autor" required>
            <br>
            <input class = "barra-formulario" type="text" name = "isbn" placeholder= "ISBN" required>
            <br><br>
            Imagen
            <br>
            <input type="file" name = "imagen" id="imagen" accept=".png, .jpg, .jpeg" >
            <br><br>
            <input class = "boton-formulario" type="submit" value="Enviar">
        </form>
    </div>
                </div>

</body>
</html>
