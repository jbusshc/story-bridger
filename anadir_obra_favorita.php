<?php

  include "config.php";

  session_start();

  $id = $_POST['obrafav'];
  define ('RUTA_FAV', 'obra.php?id='.$id.'');
  global $conn;

  if ($id == null) {
    header("Location: " . RUTA_FAV);
    exit();
  }else{

    $sql = "INSERT INTO OBRAF VALUES ($id, {$_SESSION['usu_id']})";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $stmt->close();
    header("Location: " . RUTA_FAV);
    exit();

  }
  
?>