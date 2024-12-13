<?php
    // Conexión a la base de datos (suponiendo que estás usando XAMPP localmente)
    include "config.php";
    global $conn;

    session_start();

    // Procesamiento del formulario de registro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username']; // Nombre de usuario enviado desde el formulario
        $email = $_POST['email']; // Correo electrónico enviado desde el formulario
        $password = $_POST['password']; // Contraseña enviada desde el formulario 
        $password2 = $_POST['password2'];
        $fecha_nacimiento = date('d-m-Y', strtotime($_POST['Fecha']));

        if(strlen($password) >= 8 and strlen($password) <= 40){
            if($password != $password2){
                echo '<p class="texto-error" align="center">Error: Las contraseñas no coinciden.</p>';
            }else {

                $sql = "SELECT USUARIO_ID FROM USUARIO WHERE USUARIO_NOM = '$username' OR USUARIO_CORREO = '$email'";
                $result = $conn->query($sql);
                
                if($result->num_rows > 0){
                    echo '<p class="texto-error" align="center">Error: El usuario ya existe, pruebe con un nombre de usuario o correo diferente.</p>';
                }else{
                    // Aplica el hash a la contraseña
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    // Inserta los datos en la base de datos
                    $sql = "INSERT INTO USUARIO (USUARIO_NOM, USUARIO_CORREO, USUARIO_CLAVE, USUARIO_FECHANAC, USUARIO_TIPO) VALUES ('$username', '$email', '$hashed_password', '$fecha_nacimiento', 3)";

                    if ($conn->query($sql) === TRUE) {
                        echo 'Registro exitoso';
                        $_SESSION['usu_id'] = $conn->insert_id;
                        $_SESSION['usu_nom'] = $username;
                        $_SESSION['usu_tipo'] = 3;
                        header('Location: home.php');
                        exit;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }else{
            echo '<p class="texto-error" align="center">Error: La contraseña debe tener de entre 8 a 40 caracteres.</p>';
        }

    }

    $conn->close();
?>
<!DOCTYPE html>
<html lang="es">

  <head>  
      <title>Story Bridger: Registro</title>
    	<link href="estilo.css" rel="stylesheet">
  </head>

  <body>

  		<?php include 'barra_principal_visitante.php'; ?>    

        <div class="register recuadro-obra" align="center" style="margin: 100px 25vw 50px 25vw;">
            <h1 style="margin-bottom: 60px;">Registro</h1>
            <form method="post" action="auto_registro.php">
                <div class="registro-grupo">
                    <label for="username">Nombre de usuario: </label>
                    <input type="text" name="username" placeholder="Nombre de usuario" required>
                </div>
                <div class="registro-grupo">
                    <label for="email">Correo electrónico: </label>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>
                <div class="registro-grupo">
                    <label for="date">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha" name="Fecha" value="00-00-00" min="1920-01-01" max="2025-12-31">
                </div>
                <div class="registro-grupo">
                    <label for="password1">Contraseña: </label>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <div class="registro-grupo">
                    <label for="password2">Confirmar contraseña: </label>
                    <input type="password" name="password2" placeholder="Contraseña" required>
                </div>
                <input class="boton-desplegable" type="submit" value="Registrarse" style="margin-top: 30px; font-size:large;">
            </form>
        </div>
    </body>
</html>