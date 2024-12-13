<?php

  include "config.php";

  session_start();

  $id = $_GET['id'];
  global $conn;
  $sql = "SELECT * FROM OBRA WHERE OBRA_ID = $id";
  $result = $conn->query($sql);
  $obra = $result->fetch_assoc();

?>

<!DOCTYPE html>

<html>

  <head>  
    <title>Story Bridger: Obra</title>
    <link href="estilo.css" rel="stylesheet">
  </head>

  <body>
    <?php

      include 'barra_principal.php';
            
    ?>

    <div class="recuadro-obra">
    
    <?php if($_SESSION['usu_tipo'] != 4):

      global $conn;
      $sql1 = "SELECT OBRAF_IDO FROM OBRAF WHERE OBRAF_IDO = '$id' AND OBRAF_IDU = {$_SESSION['usu_id']}";
      $obraf = $conn->query($sql1); ?>

      <?php if($obraf->num_rows == 0): ?>

        <div align="right">
          <form action="anadir_obra_favorita.php" method="post" >
            <input type="submit" class="boton-desplegable" value="Me gusta" name="obrafav" style="font-size:25px;">
            <input type="hidden" value="<?php echo $id ?>" name="obrafav">
          </form>
        </div>

      <?php else: ?>

        <div align="right">
          <form action="eliminar_obra_favorita.php" method="post" >
            <input type="submit" class="boton-desplegable" value="No me gusta" name="obrafav" style="font-size:25px;">
            <input type="hidden" value="<?php echo $id ?>" name="obrafav">
          </form>
        </div>
      
      <?php endif; ?>
    <?php endif; ?>

    <h1 align="center"><?php echo $obra['OBRA_NOM']; ?></h1> <!--Manejar la consulta de la obra-->
      <img class="texto-izquierda imagen-obra"src="<?php echo $obra['OBRA_IMG']; ?>" alt="Imagen de la obra"> 
      <p><strong>Año de publicación:</strong> <?php echo $obra['OBRA_ANIO']; ?>
            <br>
            <strong>Descripción:</strong> <?php echo $obra['OBRA_DESC']; ?>
            <br>
            
            <?php if($obra['OBRA_TIPO'] == 1):

              $pelicula = "SELECT DIRECTOR_NOM, PELICULA_TIEMPO 
              FROM PELICULA, PDIRECTOR, DIRECTOR
              WHERE PELICULA_ID = PDIRECTOR_IDP 
              AND DIRECTOR_ID = PDIRECTOR_IDD
              AND PELICULA_ID = '$id'";
              $result = $conn->query($pelicula);
              $obra = $result->fetch_assoc();

            ?>
              <strong>Director:</strong> <?php echo $obra['DIRECTOR_NOM']; ?>.
              <br>
              <strong>Duración:</strong> <?php echo $obra['PELICULA_TIEMPO']; ?> minutos.
            <?php elseif($obra['OBRA_TIPO'] == 2):

              $serie = "SELECT DIRECTOR_NOM, SERIE_CAP, SERIE_TEMP
              FROM SERIE, SDIRECTOR, DIRECTOR
              WHERE SERIE_ID = SDIRECTOR_IDS
              AND DIRECTOR_ID = SDIRECTOR_IDD
              AND SERIE_ID = '$id';";
              $result = $conn->query($serie);
              $obra = $result->fetch_assoc();

            ?>
              <strong>Director:</strong> <?php echo $obra['DIRECTOR_NOM']; ?>.
              <br>
              <strong>Cantidad de capítulos:</strong> <?php echo $obra['SERIE_CAP']; ?>
              <br>
              <strong>Cantidad de temporadas:</strong> <?php echo $obra['SERIE_TEMP']; ?>
            <?php elseif($obra['OBRA_TIPO'] == 3): 

              $juego = "SELECT DESARROLLADOR_NOM, JUEGO_DURACION
              FROM JUEGO, JDESARROLLADOR, DESARROLLADOR
              WHERE JUEGO_ID = JDESARROLLADOR_IDJ
              AND DESARROLLADOR_ID = JDESARROLLADOR_IDD
              AND JUEGO_ID = '$id';";
              $result = $conn->query($juego);
              $obra = $result->fetch_assoc();
              
            ?>
              <strong>Desarrollador:</strong> <?php echo $obra['DESARROLLADOR_NOM']; ?>.
              <br> 
              <strong>Duración estimada:</strong> <?php echo $obra['JUEGO_DURACION']; ?> minutos.
              <br>
              <strong>Plataforma/s:</strong>
              <?php

                $sql = "SELECT JPLATAFORMA_IDP FROM JPLATAFORMA WHERE JPLATAFORMA_IDJ = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while($id_plat = $result->fetch_assoc()) {
                    $sql2 = "SELECT PLATAFORMA_NOM FROM PLATAFORMA WHERE PLATAFORMA_ID = " . $id_plat['JPLATAFORMA_IDP'];
                    $result2 = $conn->query($sql2);

                    if ($result2->num_rows > 0) {
                      while($nom_plat = $result2->fetch_assoc())
                        echo $nom_plat["PLATAFORMA_NOM"] . ", ";
                      
                    }
                  }
                }else
                  echo "Sin plataformas.";
        ?>
            <?php elseif($obra['OBRA_TIPO'] == 4): 

              $libro = "SELECT AUTOR_NOM, LIBRO_ISBN
              FROM LIBRO, LAUTOR, AUTOR
              WHERE LIBRO_ID = LAUTOR_IDL
              AND AUTOR_ID = LAUTOR_IDA
              AND LIBRO_ID = '$id';";
              $result = $conn->query($libro);
              $obra = $result->fetch_assoc();

            ?>
              <strong>Autor:</strong> <?php echo $obra['AUTOR_NOM']; ?>.
              <br>
              <strong>ISBN:</strong> <?php echo $obra['LIBRO_ISBN']; ?>
            <?php endif; ?>
      </p>
      <strong>Categorías:</strong>
      <ul style="margin-left: 320px;">
        <?php

          $sql = "SELECT CATOBRA_IDC FROM CATOBRA WHERE CATOBRA_IDO = $id";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($id_cat = $result->fetch_assoc()) {
              $sql2 = "SELECT CATEGORIA_NOM FROM CATEGORIA WHERE CATEGORIA_ID = " . $id_cat['CATOBRA_IDC'];
              $result2 = $conn->query($sql2);

              if ($result2->num_rows > 0) {
                while($nom_cat = $result2->fetch_assoc())
                  echo "<li>" . $nom_cat["CATEGORIA_NOM"] . "</li>";
                
              }
            }
          }else
            echo "Sin categorías.";
        ?>
      </ul>     
    </div>

  </body>


  <footer>
    <p align="center" style="font-style: italic;">Story Bridger, 2023</p>
  </footer>

</html>