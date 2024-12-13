<?php

  include "config.php";

  session_start();

  $id = $_POST['catfav'];
  define ('RUTA_FAV', 'se_categoria_favorita.php');
  global $conn;

  if ($id == null) {
    header("Location: " . RUTA_FAV);
    exit();
  }else{

    $sql = "DELETE FROM CATEGORIAF WHERE CATEGORIAF_IDC = '$id' AND CATEGORIAF_IDU = {$_SESSION['usu_id']}";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $stmt->close();
    header("Location: " . RUTA_FAV);
    exit();

  }

?>