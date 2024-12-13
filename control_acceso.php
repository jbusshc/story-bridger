<?php

session_start();

include "config.php";   

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // Consulta preparada para evitar inyección SQL
    $sql = "SELECT USUARIO_ID, USUARIO_CLAVE, USUARIO_TIPO FROM USUARIO WHERE USUARIO_NOM = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $entered_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hash = $row['USUARIO_CLAVE'];
        $type = $row['USUARIO_TIPO'];

        if (password_verify($entered_password, $stored_hash)) {
            // Contraseña válida, permitir acceso
            echo "Inicio de sesión exitoso";
            $_SESSION['usu_id'] = $row['USUARIO_ID'];
            $_SESSION['usu_nom'] = $entered_username;
            $_SESSION['usu_tipo'] = $type;
            header("Location: home.php");
            exit;
            // Redirigir a la página de éxito o mostrar contenido protegido
        } else {
            // Contraseña inválida, mostrar mensaje de error
            echo '<p class="texto-error" align="center">Error: Contraseña incorrecta.</p>';
        }
    } else {
        // Usuario no encontrado, mostrar mensaje de error
        echo '<p class="texto-error" align="center">Error: El usuario no existe.</p>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>  
        <title>Story Bridger: Ingreso</title>
        <link href="estilo.css" rel="stylesheet">
    </head>
    <body>

        <?php include 'barra_principal_visitante.php'; ?>

        <div class="login">

        <div class="register recuadro-obra" align="center" style="margin: 100px 25vw 50px 25vw;">
        <h1 style="margin-bottom: 60px;">Ingreso</h1>
        <form method="post" action="control_acceso.php">
            <div class="registro-grupo">
                <input type="text" placeholder="Nombre de usuario" name="username" required>
            </div>
            <div class="registro-grupo">
                <input type="password" placeholder="Contraseña" name="password" required>
            </div>
            <div class="registro-grupo">
                <a href="#">¿Olvidó su contraseña?</a>    
            </div>
            <input style="font-size:large;" class="registro-grupo boton-desplegable" type="submit" value="Iniciar sesión">
            
            <div class="registro-grupo">
            <label>¿Nuevo en Story Bridger?</label> <a href="auto_registro.php"> Registrarse</a>
            </div>
        </form>
        </div>
    </div>
</body>
</html>