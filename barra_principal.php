<?php 

  session_start();

  if($_SESSION['usu_tipo'] == 4){
    include 'barra_principal_visitante.php';
  }elseif($_SESSION['usu_tipo'] == 3){
    include 'barra_principal_usuario.php';
  }elseif($_SESSION['usu_tipo'] == 2){
    include 'barra_principal_mod.php';
  }elseif($_SESSION['usu_tipo'] == 1){
    include 'barra_principal_admin.php';
  } 
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Bridger</title>
    <link rel="stylesheet" href="estilo.css"> 
</head>
</html>
