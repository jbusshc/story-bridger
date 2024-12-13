<?php

//RUTA de regreso al mantenedor
define ('RUTA_MANTENEDOR', 'mantenedor.php');

//Función para agregar un registro de plataforma
function agregar_plataforma($p_reg_plataforma) {

    global $conn;
    $query = "SELECT PLATAFORMA_ID FROM PLATAFORMA 
            WHERE PLATAFORMA_NOM = '$p_reg_plataforma'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }else{
        $sql = "INSERT INTO PLATAFORMA (PLATAFORMA_NOM) VALUES ('$p_reg_plataforma')";
        $query = mysqli_query($conn, $sql);
    
        if($query) {
            $conn->close();
            header("Location: ".RUTA_MANTENEDOR);
            exit();
        }
    }

}

// Función para eliminar un registro de plataforma
function eliminar_plataforma($p_id) {
    global $conn;
    $sql = "DELETE FROM PLATAFORMA WHERE PLATAFORMA_ID = $p_id";
    echo '<p class="texto-error" align="center">Error: Respete la integridad referencial por favor, tenga más cuidado para la próxima...</p>';
    $query = mysqli_query($conn, $sql);

    if($query) {
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

// Función para actualizar un registro de plataforma
function actualizar_plataforma($p_id, $p_reg_plataforma) {
    global $conn;
    $sql = "UPDATE PLATAFORMA SET PLATAFORMA_NOM = '$p_reg_plataforma' WHERE PLATAFORMA_ID = $p_id";
    $query = mysqli_query($conn, $sql);

    if($query) {
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

// Ejecutar función según el flag de control
function mantener_plataformas($p_reg_plataforma, $p_flag) {
    switch ($p_flag) {    
        case 1:
            agregar_plataforma($p_reg_plataforma[1]);
            break;

        case 2:
            actualizar_plataforma($p_reg_plataforma[0], $p_reg_plataforma[1]);
            break;
        case 3:
            eliminar_plataforma($p_reg_plataforma[0]);
            break;
        default:
            echo "Flag de control inválido";
            echo $p_flag;
            break;
    }
}

// Función para agregar un registro de tipo de usuario
function agregar_tusuario($p_reg_tusuario) {

    global $conn;
    $query = "SELECT TUSUARIO_ID FROM TUSUARIO 
            WHERE TUSUARIO_NOM = '$p_reg_tusuario'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }else{
        $sql = "INSERT INTO TUSUARIO (TUSUARIO_NOM) VALUES ('$p_reg_tusuario')";
        $query = mysqli_query($conn, $sql);
        
        if($query) {
            $conn->close();
            header("Location: ".RUTA_MANTENEDOR);
            exit();
        }
    }
}

// Función para actualizar un registro de tipo de usuario
function actualizar_tusuario($p_id, $p_reg_suge) {
    global $conn;
    $sql = "UPDATE TUSUARIO SET TUSUARIO_NOM = '$p_reg_suge' WHERE TUSUARIO_ID = $p_id";
    $query = mysqli_query($conn, $sql);

    if($query) {
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

// Función para eliminar un registro de tipo de usuario
function eliminar_tusuario($p_id) {
    global $conn;
    $sql = "DELETE FROM TUSUARIO WHERE TUSUARIO_ID = $p_id";
    echo '<p class="texto-error" align="center">Error: Respete la integridad referencial por favor, tenga más cuidado para la próxima...</p>';
    $query = mysqli_query($conn, $sql);

    if($query) {
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

// Ejecutar función según el flag de control
function mantener_tipos_usuario($p_reg_tusuario, $p_flag) {
    switch ($p_flag) {    
        case 1:
            agregar_tusuario($p_reg_tusuario[1]);
            break;

        case 2:
            actualizar_tusuario($p_reg_tusuario[0], $p_reg_tusuario[1]);
            break;
        case 3:
            eliminar_tusuario($p_reg_tusuario[0]);
            break;
        default:
            echo "Flag de control inválido";
            echo $p_flag;
            break;
    }
}

// Ejecutar funcion según el flag de control
function mantener_estados_sugerencia($p_reg_suge, $p_flag) {
    global $conn;
    switch ($p_flag) {    
        case 1:
            agregar_suge($p_reg_suge[1]);
            break;

        case 2:
            actualizar_suge($p_reg_suge[0], $p_reg_suge[1]);
            break;
        case 3:
            eliminar_suge($p_reg_suge[0]);
            break;
        default:
            echo "Flag de control inválido";
            echo $p_flag;
            break;
    }
}

//Función para agregar un registro de estado de sugerencia
function agregar_suge($p_reg_suge) {
    global $conn;
    $query = "SELECT SUGE_ID FROM SUGE 
            WHERE SUGE_NOM = '$p_reg_suge'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }else{
        $sql = "INSERT INTO SUGE (SUGE_NOM) VALUES ('$p_reg_suge')";
        $query = mysqli_query($conn, $sql);
        
        if($query) {
            $conn->close();
            header("Location: ".RUTA_MANTENEDOR);
            exit();
        }
    }
}

//Funcion para actualizar un registro de estado de sugerencia
function actualizar_suge($p_id, $p_reg_suge) {
    global $conn;
    $sql = "UPDATE SUGE SET SUGE_NOM = '$p_reg_suge' WHERE SUGE_ID = $p_id";
    $query = mysqli_query($conn, $sql);

    if($query) {
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

//Funcion para eliminar un registro de estado de sugerencia
function eliminar_suge($p_id) {
    global $conn;
    $sql = "DELETE FROM SUGE WHERE SUGE_ID = $p_id";
    echo '<p class="texto-error" align="center">Error: Respete la integridad referencial por favor, tenga más cuidado para la próxima...</p>';
    $query = mysqli_query($conn, $sql);

    if($query) {
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

//Funcion para ejecutar funcion según el flag de control
function mantener_tipos_obra($p_reg_tobra, $p_flag) {
    global $conn;
    switch ($p_flag) {    
        case 1:
            agregar_tobra($p_reg_tobra[1]);
            break;

        case 2:
            actualizar_tobra($p_reg_tobra[0], $p_reg_tobra[1]);
            break;
        case 3:
            eliminar_tobra($p_reg_tobra[0]);
            break;
        default:
            echo "Flag de control inválido";
            echo $p_flag;
            break;
    }
}

//Funcion para agregar un registro de tipo de obra
function agregar_tobra($p_reg_tobra) {
    global $conn;
    $query = "SELECT TOBRA_ID FROM TOBRA 
            WHERE TOBRA_NOM = '$p_reg_tobra'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }else{
        $sql = "INSERT INTO TOBRA (TOBRA_NOM) VALUES ('$p_reg_tobra')";
        $query = mysqli_query($conn, $sql);
        
        if($query) {
            $conn->close();
            header("Location: ".RUTA_MANTENEDOR);
            exit();
        }
    }
}

//Funcion para actualizar un registro de tipo de obra
function actualizar_tobra($p_id, $p_reg_tobra) {
    global $conn;
    $sql = "UPDATE TOBRA SET TOBRA_NOM = '$p_reg_tobra' WHERE TOBRA_ID = $p_id";
    $query = mysqli_query($conn, $sql);

    if($query) {
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

//Funcion para eliminar un registro de tipo de obra
function eliminar_tobra($p_id) {
    global $conn;
    $sql = "DELETE FROM TOBRA WHERE TOBRA_ID = $p_id";
    echo '<p class="texto-error" align="center">Error: Respete la integridad referencial por favor, tenga más cuidado para la próxima...</p>';
    $query = mysqli_query($conn, $sql);

    if($query) {
        $conn->close();
        header("Location: ".RUTA_MANTENEDOR);
        exit();
    }
}

//Función general de mantención de tablas básicas
function mantencion_tablas_basicas($p_reg_tabla, $p_tabla, $p_flag) {
        if ($p_tabla == TABLA_TUSUARIO) { // TUSUARIO
            mantener_tipos_usuario($p_reg_tabla, $p_flag);
        } else if ($p_tabla == TABLA_PLATAFORMA) { // PLATAFORMA
            mantener_plataformas($p_reg_tabla, $p_flag);
        } else if ($p_tabla == TABLA_SUGE) { // SUGE
            mantener_estados_sugerencia($p_reg_tabla, $p_flag);
        } else if ($p_tabla == TABLA_TOBRA) { // TOBRA
            mantener_tipos_obra($p_reg_tabla, $p_flag);
        }
}



?>

<!DOCTYPE html>
<html lang="es">

  <head>
    <link rel="stylesheet" href="estilo.css">
  </head>

</html>