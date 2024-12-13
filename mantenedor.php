<?php
  session_start();

    if ($_SESSION['usu_tipo'] != 1) {
      header("Location: denegado.php");
      exit();
    }

  include "config.php";
  include "mantenedor_funciones.php";
  include "constantes.php";

  $sql = "SELECT * FROM PLATAFORMA";
  $query = mysqli_query($conn, $sql);

  $sql2 = "SELECT * FROM TUSUARIO";
  $query2 = mysqli_query($conn, $sql2);

  $sql3 = "SELECT * FROM TOBRA";
  $query3 = mysqli_query($conn, $sql3);

  $sql4 = "SELECT * FROM SUGE";
  $query4 = mysqli_query($conn, $sql4);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = NULL;
    $name = NULL;

    if (isset($_POST['name']) && !empty($_POST['name'])) {
      // El valor de 'name' existe y no está vacío
      $name = $_POST['name'];
    }

    if (isset($_POST['nuevo_nombre']) && !empty($_POST['nuevo_nombre'])) {
      $name = $_POST['nuevo_nombre'];
    }

    if (isset($_POST['id']) && !empty($_POST['id'])) {
      // El valor de 'id' existe y no está vacío
      $id = $_POST['id'];
    }

    $reg = array($id, $name);
    $tabla = $_POST['tabla'];
    $accion = $_POST['accion'];

    mantencion_tablas_basicas($reg, $tabla, $accion); // Agregado el punto y coma al final de esta línea
  }
?>

<!DOCTYPE html>
<html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Bridger: Mantenedor</title>
    <link rel="stylesheet" href="estilo.css">
  </head>

  <body>
    <?php include 'barra_principal.php'; ?>

    <div align="center">
      <div class="test">
        <h1>Mantención de tablas base</h1>
        <h2>Plataformas</h2>
      </div>

      <div class="table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_array($query)) :  ?>
              <tr>
                <th> <?= $row['PLATAFORMA_ID'] ?> </th>
                <th> <?= $row['PLATAFORMA_NOM'] ?> </th>
                <th>
                  <form method="POST" action="" class="mantenedor">
                    <input type="hidden" name="id" value="<?= $row['PLATAFORMA_ID'] ?>">
                    <input type="hidden" name="tabla" value="<?= TABLA_PLATAFORMA ?>">
                    <input type="hidden" name="accion" value="<?= ACCION_ACTUALIZAR ?>">
                    <input class="barra-formulario" type="text" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                    <button type="submit" class="button-actualizar">Editar</button>
                  </form>
                </th>
                <th>
                  <form method="POST" action="" class="mantenedor">
                    <input type="hidden" name="id" value="<?= $row['PLATAFORMA_ID'] ?>">
                    <input type="hidden" name="tabla" value="<?= TABLA_PLATAFORMA ?>">
                    <input type="hidden" name="accion" value="<?= ACCION_ELIMINAR ?>">
                    <button type="submit" class="button-eliminar">Eliminar</button>
                  </form>
                </th>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <form method="POST" action="">
          <h3>Crear plataforma</h3>
          <div class="Nombre">
            <input class="barra-formulario" type="text" placeholder="Nombre" name="name" required>
            <input type="hidden" name="tabla" value="<?= TABLA_PLATAFORMA ?>">
            <input type="hidden" name="accion" value="<?= ACCION_CREAR ?>">
            <input type="submit" class="button-crear" value="Crear">
          </div>
        </form>
      <br>

      <h2>Tipos de usuario</h2>

      <div class="table">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($query2)) :  ?>
            <tr>
              <th> <?= $row['TUSUARIO_ID'] ?> </th>
              <th> <?= $row['TUSUARIO_NOM'] ?> </th>
              <th>
                <form method="POST" action="" class="mantenedor">
                  <input type="hidden" name="id" value="<?= $row['TUSUARIO_ID'] ?>">
                  <input type="hidden" name="tabla" value="<?= TABLA_TUSUARIO ?>">
                  <input type="hidden" name="accion" value="<?= ACCION_ACTUALIZAR ?>">
                  <input class="barra-formulario" type="text" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                  <button type="submit" class="button-actualizar">Editar</button>
                </form>
              </th>
              <th>
                <form method="POST" action="">
                  <input type="hidden" name="id" value="<?= $row['TUSUARIO_ID'] ?>">
                  <input type="hidden" name="tabla" value="<?= TABLA_TUSUARIO ?>">
                  <input type="hidden" name="accion" value="<?= ACCION_ELIMINAR ?>">
                  <button type="submit" class="button-eliminar">Eliminar</button>
                </form>
              </th>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <form method="POST" action="">
        <h3>Crear tipo de usuario</h3>
        <div class="Nombre">
          <input class="barra-formulario" type="text" placeholder="Nombre" name="name" required>
          <input type="hidden" name="tabla" value="<?= TABLA_TUSUARIO ?>">
          <input type="hidden" name="accion" value="<?= ACCION_CREAR ?>">
          <input type="submit" class="button-crear" value="Crear">
        </div>
      </form>
      </div>
    
      <br>
      <h2>Tipos de Obra</h2>


      <div class="table">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($query3)) :  ?>
            <tr>
              <th> <?= $row['TOBRA_ID'] ?> </th>
              <th> <?= $row['TOBRA_NOM'] ?> </th>
              <th>
                <form method="POST" action="" class="mantenedor">
                  <input type="hidden" name="id" value="<?= $row['TOBRA_ID'] ?>">
                  <input type="hidden" name="tabla" value="<?= TABLA_TOBRA ?>">
                  <input type="hidden" name="accion" value="<?= ACCION_ACTUALIZAR ?>">
                  <input class="barra-formulario" type="text" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                  <button type="submit" class="button-actualizar">Editar</button>
                </form>
              </th>
              <th>
                <form method="POST" action="">
                  <input type="hidden" name="id" value="<?= $row['TOBRA_ID'] ?>">
                  <input type="hidden" name="tabla" value="<?= TABLA_TOBRA ?>">
                  <input type="hidden" name="accion" value="<?= ACCION_ELIMINAR ?>">
                  <button type="submit" class="button-eliminar">Eliminar</button>
                </form>
              </th>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <form method="POST" action="">
        <h3>Crear tipo de Obra</h3>
        <div class="Nombre">
          <input class="barra-formulario" type="text" placeholder="Nombre" name="name" required>
          <input type="hidden" name="tabla" value="<?= TABLA_TOBRA ?>">
          <input type="hidden" name="accion" value="<?= ACCION_CREAR ?>">
          <input type="submit" class="button-crear" value="Crear">
        </div>
      </form>
      </div>
      <br>
      <h2>Estado de Sugerencia</h2>

      <div class="table">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($query4)) :  ?>
            <tr>
              <th> <?= $row['SUGE_ID'] ?> </th>
              <th> <?= $row['SUGE_NOM'] ?> </th>
              <th>
                <form method="POST" action="" class="mantenedor">
                  <input type="hidden" name="id" value="<?= $row['SUGE_ID'] ?>">
                  <input type="hidden" name="tabla" value="<?= TABLA_SUGE ?>">
                  <input type="hidden" name="accion" value="<?= ACCION_ACTUALIZAR ?>">
                  <input class="barra-formulario" type="text" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                  <button type="submit" class="button-actualizar">Editar</button>
                </form>
              </th>
              <th>
                <form method="POST" action="">
                  <input type="hidden" name="id" value="<?= $row['SUGE_ID'] ?>">
                  <input type="hidden" name="tabla" value="<?= TABLA_SUGE ?>">
                  <input type="hidden" name="accion" value="<?= ACCION_ELIMINAR ?>">
                  <button type="submit" class="button-eliminar">Eliminar</button>
                </form>
              </th>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <form method="POST" action="">
        <h3>Crear estado de Sugerencia</h3>
        <div class="Nombre">
          <input class="barra-formulario" type="text" placeholder="Nombre" name="name" required>
          <input type="hidden" name="tabla" value="<?= TABLA_SUGE ?>">
          <input type="hidden" name="accion" value="<?= ACCION_CREAR ?>">
          <input type="submit" class="button-crear" value="Crear">
        </div>
      </form>
      </div>

    </div>
  </body>

    <footer>
        <p align="center" style="font-style: italic;">Story Bridger, 2023</p>
    </footer>

</html>
