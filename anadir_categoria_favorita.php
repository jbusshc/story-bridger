<?php

  include "config.php";

  session_start();

  $id = $_POST['catfav'];
  define ('RUTA_FAV', 'sa_categoria_favorita.php');
  global $conn;

  if ($id == null) {
    header("Location: " . RUTA_FAV);
    exit();
  }else{

    $sql = "INSERT INTO CATEGORIAF VALUES ($id, {$_SESSION['usu_id']})";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $stmt->close();
    header("Location: " . RUTA_FAV);
    exit();

  }
  
?>