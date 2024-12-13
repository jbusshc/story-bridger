<?php
  session_start();
  if($_SESSION['usu_tipo'] != 2){
    header('Location: denegado.php');
    exit;
  }
?>

<div class="barra-principal">
      <a href="home.php"><img class= "texto-izquierda" width="5%" src="IMG/logo1.png" alt="Logo de la página"><h2 id="texto-storybridger" style="display:inline-block;">Story Bridger</h2></a>

    <span id="saludo-usuario">Hola, <?php echo $_SESSION['usu_nom']; ?>!</span>
      
      <div class="desplegable">
        <button class="boton-desplegable" style="font-size:larger">Menú</button>
        <div class="contenido-desplegable">
          <a href="perfil.php" id="simple"><span>Mi perfil</span></a><br>
          <a href="gestion_sugerencias.php" id="simple" ><span>Sugerencias</span></a><br>
          <a href="logout.php" id="simple"><span>Cerrar sesión</span></a>
        </div>
       </div>
      <hr id="linea-locura">
    </div>

    <div align="center" class="busqueda">
      <form action="listado_busqueda_obra.php" method="POST" style="z-index: 1;"> <!--Manejar la búsqueda-->
        <input id = "barra-busqueda" type="text" name="palabra_clave" placeholder="Buscar obras...">
        
        <div class="desplegable">
          <button class="boton-desplegable">Filtro por categorías</button>
          <div class="contenido-desplegable">

          <?php

            include 'config.php';

            $sql = "SELECT * FROM CATEGORIA";
            $result = $conn->query($sql);
            $categorias = array();
            if($result->num_rows > 0) {
              while($row = $result->fetch_assoc())
                $categorias[] = $row;
              
            }
            
          ?>

          <?php foreach ($categorias as $categoria) { ?>
                    <input type="checkbox" name="categoria[]" value="<?php echo $categoria['CATEGORIA_ID']; ?>" id="categoria<?php echo $categoria['CATEGORIA_ID']; ?>">
                    <label for="categoria<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOM'];?></label>
                    <br>
          <?php } ?>

          </div>
         </div>
      </form>
    </div>

    <br>