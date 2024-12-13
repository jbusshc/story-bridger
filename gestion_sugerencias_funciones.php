<?php
define('titulo', 0);
define('anio', 1);
define('descripcion', 2);
define('tipo', 3);
define('director', 4);
define('duracion', 5);
define('capitulos', 5);
define('temporadas', 6);
define('desarrollador', 4);
define('plataformas', 6);
define('autor', 4);
define('isbn', 5);
define('idobra', 0);
define('idcategoria', 1);

include "config.php";

//CREAR SUGERENCIAS

//Función para crear sugerencia de categoría de obra
function crear_sugerencia_categoria_obra($p_sugerencia_categoria_obra, $p_usu_usuario) {

    global $conn;
    $sql = "INSERT INTO SUGCATOBRA (SUGCATOBRA_IDU, SUGCATOBRA_ESTADO, SUGCATOBRA_IDC, SUGCATOBRA_IDO) VALUES (?, 1, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $p_usu_usuario, $p_sugerencia_categoria_obra[idcategoria], $p_sugerencia_categoria_obra[idobra]);
    $stmt->execute();
    $stmt->close();
}

//Función para crear sugerencia de categoría
function crear_sugerencia_categoria($p_sugerencia_categoria, $p_usu_usuario) {

    global $conn;
    $sql = "INSERT INTO SUGCATEGORIA (SUGCATEGORIA_IDU, SUGCATEGORIA_ESTADO, SUGCATEGORIA_NOM) VALUES (?, 1, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $p_usu_usuario, $p_sugerencia_categoria);
    $stmt->execute();
    $stmt->close();
}

//Función para verificar existencia de autoría
function verificar_existencia_autoria($p_id_sug, $p_tobra) {

    global $conn;
    if ($p_tobra == 1) {
        $sql = "SELECT DIRECTOR_ID
                FROM DIRECTOR, SUGPELICULA
                WHERE DIRECTOR_NOM = SUGPELICULA_DIRECTOR AND SUGPELICULA_ID = $p_id_sug";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_dir = $row['DIRECTOR_ID'];

            $insertSql = "INSERT INTO SUGPDIRECTOR (SUGPDIRECTOR_IDP, SUGPDIRECTOR_IDD)
                          VALUES (?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("ii", $p_id_sug, $id_dir);
            $stmt->execute();
            $stmt->close();
        } else {
            $insertSql = "INSERT INTO SUGPDIRECTOR (SUGPDIRECTOR_IDP, SUGPDIRECTOR_IDD)
                          VALUES (?, NULL)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("i", $p_id_sug);
            $stmt->execute();
            $stmt->close();
        }
    }
    else if($p_tobra == 2) {
        //Serie
        $sql = "SELECT DIRECTOR_ID
                FROM DIRECTOR, SUGSERIE
                WHERE DIRECTOR_NOM = SUGSERIE_DIRECTOR AND SUGSERIE_ID = $p_id_sug";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_dir = $row['DIRECTOR_ID'];

            $insertSql = "INSERT INTO SUGSDIRECTOR (SUGSDIRECTOR_IDS, SUGSDIRECTOR_IDD)
                          VALUES (?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("ii", $p_id_sug, $id_dir);
            $stmt->execute();
            $stmt->close();
        } else {
            $insertSql = "INSERT INTO SUGSDIRECTOR (SUGSDIRECTOR_IDS, SUGSDIRECTOR_IDD)
                          VALUES (?, NULL)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("i", $p_id_sug);
            $stmt->execute();
            $stmt->close();
        }
        
    }
    else if($p_tobra == 3) {
        //Videojuego
        $sql = "SELECT DESARROLLADOR_ID
                FROM DESARROLLADOR, SUGJUEGO
                WHERE DESARROLLADOR_NOM = SUGJUEGO_DESARROLLADOR AND SUGJUEGO_ID = $p_id_sug";
        
        $result = $conn->query($sql); 

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_des = $row['DESARROLLADOR_ID'];

            $insertSql = "INSERT INTO SUGDESARROLLADOR (SUGDESARROLLADOR_IDJ, SUGDESARROLLADOR_IDD)
                          VALUES (?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("ii", $p_id_sug, $id_des);
            $stmt->execute();
            $stmt->close();
        } else {
            $insertSql = "INSERT INTO SUGDESARROLLADOR (SUGDESARROLLADOR_IDJ, SUGDESARROLLADOR_IDD)
                          VALUES (?, NULL)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("i", $p_id_sug);
            $stmt->execute();
            $stmt->close();
        }
    }
    else if($p_tobra == 4) {
        //Libro
        $sql = "SELECT AUTOR_ID
                FROM AUTOR, SUGLIBRO
                WHERE AUTOR_NOM = SUGLIBRO_AUTOR AND SUGLIBRO_ID = $p_id_sug";

        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_aut = $row['AUTOR_ID'];

            $insertSql = "INSERT INTO SUGAUTOR (SUGAUTOR_IDS, SUGAUTOR_IDA)
                          VALUES (?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("ii", $p_id_sug, $id_aut);
            $stmt->execute();
            $stmt->close();
        } else {
            $insertSql = "INSERT INTO SUGAUTOR (SUGAUTOR_IDS, SUGAUTOR_IDA)
                          VALUES (?, NULL)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("i", $p_id_sug);
            $stmt->execute();
            $stmt->close();
        }
    }
}

//Función para crear sugerencia de obra
function crear_sugerencia_obra($p_sugerencia_obra, $p_usu_usuario) {
    if($p_sugerencia_obra[tipo] == 1) {
        global $conn;
        $sql = "INSERT INTO SUGOBRA (SUGOBRA_IDU, SUGOBRA_ESTADO, SUGOBRA_NOM, SUGOBRA_ANIO, SUGOBRA_DESC, SUGOBRA_TIPO, SUGOBRA_IMG) VALUES (?, 1, ?, ?, ?, 1, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $p_usu_usuario, $p_sugerencia_obra[titulo], $p_sugerencia_obra[anio], $p_sugerencia_obra[descripcion], $p_sugerencia_obra[duracion+1]);
        $stmt->execute();

        $SUGOBRA_ID = $stmt->insert_id;
        $sql = "INSERT INTO SUGPELICULA (SUGPELICULA_ID, SUGPELICULA_DURACION, SUGPELICULA_DIRECTOR) VALUES ($SUGOBRA_ID, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $p_sugerencia_obra[duracion], $p_sugerencia_obra[director]);
        $stmt->execute();

        //verificar_existencia_autoria($SUGOBRA_ID, 1);
        $stmt->close();
    }
    else if($p_sugerencia_obra[tipo] == 2) {
        //Serie
        global $conn;
        $sql = "INSERT INTO SUGOBRA (SUGOBRA_IDU, SUGOBRA_ESTADO, SUGOBRA_NOM, SUGOBRA_ANIO, SUGOBRA_DESC, SUGOBRA_TIPO, SUGOBRA_IMG) VALUES (?, 1, ?, ?, ?, 2, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $p_usu_usuario, $p_sugerencia_obra[titulo], $p_sugerencia_obra[anio], $p_sugerencia_obra[descripcion], end($p_sugerencia_obra));
        $stmt->execute();

        $SUGOBRA_ID = $stmt->insert_id;


        $sql = "INSERT INTO SUGSERIE (SUGSERIE_ID, SUGSERIE_CAP, SUGSERIE_TEMP, SUGSERIE_DIRECTOR) VALUES ($SUGOBRA_ID, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $p_sugerencia_obra[capitulos], $p_sugerencia_obra[temporadas], $p_sugerencia_obra[director]);
        $stmt->execute();

        //verificar_existencia_autoria($SUGOBRA_ID, 2);
        $stmt->close();
   }
   else if($p_sugerencia_obra[tipo] == 3) {
        //Juego
        global $conn;
        $sql = "INSERT INTO SUGOBRA (SUGOBRA_IDU, SUGOBRA_ESTADO, SUGOBRA_NOM, SUGOBRA_ANIO, SUGOBRA_DESC, SUGOBRA_TIPO, SUGOBRA_IMG) VALUES (?, 1, ?, ?, ?, 3, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $p_usu_usuario, $p_sugerencia_obra[titulo], $p_sugerencia_obra[anio], $p_sugerencia_obra[descripcion], end($p_sugerencia_obra));
        $stmt->execute();

        $SUGOBRA_ID = $stmt->insert_id;


        $sql = "INSERT INTO SUGJUEGO (SUGJUEGO_ID, SUGJUEGO_TIEMPO, SUGJUEGO_DESARROLLADOR) VALUES ($SUGOBRA_ID, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $p_sugerencia_obra[duracion], $p_sugerencia_obra[desarrollador]);
        $stmt->execute();
        //verificar_existencia_autoria($SUGOBRA_ID, 3);

        foreach($p_sugerencia_obra[plataformas] as $plataforma) {
            $sql = "INSERT INTO SUGJPLATAFORMA (SUGJPLATAFORMA_IDS, SUGJPLATAFORMA_IDP) VALUES ($SUGOBRA_ID, $plataforma)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        $stmt->close();
    }
    else if($p_sugerencia_obra[tipo] == 4) {
    //LIBRO 
        global $conn;
        $sql = "INSERT INTO SUGOBRA (SUGOBRA_IDU, SUGOBRA_ESTADO, SUGOBRA_NOM, SUGOBRA_ANIO, SUGOBRA_DESC, SUGOBRA_TIPO, SUGOBRA_IMG) VALUES (?, 1, ?, ?, ?, 4, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $p_usu_usuario, $p_sugerencia_obra[titulo], $p_sugerencia_obra[anio], $p_sugerencia_obra[descripcion], end($p_sugerencia_obra));
        $stmt->execute();

        $SUGOBRA_ID = $stmt->insert_id;


        $sql = "INSERT INTO SUGLIBRO (SUGLIBRO_ID, SUGLIBRO_AUTOR, SUGLIBRO_ISBN) VALUES ($SUGOBRA_ID, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $p_sugerencia_obra[autor], $p_sugerencia_obra[isbn]);
        $stmt->execute();
        //verificar_existencia_autoria($SUGOBRA_ID, 4);
        $stmt->close();
   }
}

//Función de control para crear sugerencias
function crear_sugerencias($p_usu_usuario, $p_sugerencia, $p_flag_tipo_sg) {

    if($p_flag_tipo_sg == 1) { //OBRA
        crear_sugerencia_obra($p_sugerencia, $p_usu_usuario);
    }
    else if($p_flag_tipo_sg == 2) { //CATEGORIA
        crear_sugerencia_categoria($p_sugerencia, $p_usu_usuario);
    }
    else if($p_flag_tipo_sg == 3) { //CATEGORIA_OBRA
        crear_sugerencia_categoria_obra($p_sugerencia, $p_usu_usuario);
    }
}

//VERIFICAR SUGERENCIAS

function verificar_sugerencia_obra($p_id_sug, $p_estado_sug) {

    global $conn;
    $sql = "UPDATE SUGOBRA SET SUGOBRA_ESTADO = $p_estado_sug WHERE SUGOBRA_ID = $p_id_sug";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->close();
}

function verificar_sugerencia_categoria($p_id_sug, $p_estado_sug) {
    
    global $conn;
    $sql = "UPDATE SUGCATEGORIA SET SUGCATEGORIA_ESTADO = $p_estado_sug WHERE SUGCATEGORIA_ID = $p_id_sug";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->close();
}

function verificar_sugerencia_categoria_obra($p_id_sug, $p_estado_sug) {
        
        global $conn;
        $sql = "UPDATE SUGCATOBRA SET SUGCATOBRA_ESTADO = $p_estado_sug WHERE SUGCATOBRA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
}

function verificacion_sugerencias($p_flag_tipo_sg, $p_estado_sug, $p_id_sug) {

    if($p_flag_tipo_sg == 1) { //OBRA
        verificar_sugerencia_obra($p_id_sug, $p_estado_sug);
    }
    else if($p_flag_tipo_sg == 2) { //CATEGORIA
        verificar_sugerencia_categoria($p_id_sug, $p_estado_sug);
    }
    else if($p_flag_tipo_sg == 3) { //CATEGORIA_OBRA
        verificar_sugerencia_categoria_obra($p_id_sug, $p_estado_sug);
    }
}


//AÑADIR SUGERENCIAS

function aniadir_sugerencia_obra($p_id_sug) {
    
    global $conn;
    $sql = "SELECT * FROM SUGOBRA WHERE SUGOBRA_ID = $p_id_sug";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $estado = $row['SUGOBRA_ESTADO'];
    $tipo = $row['SUGOBRA_TIPO'];
    $ruta_completa_archivo_original = $row['SUGOBRA_IMG'];

    if($estado == 2) {

        $sql2 = "SELECT OBRA_ID FROM OBRA ORDER BY OBRA_ID DESC LIMIT 1";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        $id_obra = $row2['OBRA_ID'] + 1;
        $directorio_destino = "IMG/";
        $nuevo_nombre = $id_obra . ".jpg";
        rename($ruta_completa_archivo_original, $directorio_destino . $nuevo_nombre);
        $ruta_completa_archivo_nuevo = $directorio_destino . $nuevo_nombre;
        $sql = "INSERT INTO OBRA (OBRA_NOM, OBRA_ANIO, OBRA_DESC, OBRA_TIPO, OBRA_IMG) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisis", $row['SUGOBRA_NOM'], $row['SUGOBRA_ANIO'], $row['SUGOBRA_DESC'], $row['SUGOBRA_TIPO'],$ruta_completa_archivo_nuevo);
        $stmt->execute();
        $id_obra = $stmt->insert_id;
        $stmt->close();
        if($tipo == 1) { //Pelicula

            verificar_existencia_autoria($p_id_sug, 1);
            $sql = "SELECT * FROM SUGPELICULA WHERE SUGPELICULA_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $director = $row['SUGPELICULA_DIRECTOR'];
            
            $sql = "INSERT INTO PELICULA (PELICULA_ID, PELICULA_TIEMPO) VALUES  (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_obra, $row['SUGPELICULA_DURACION']);
            $stmt->execute();

            
            $sql = "SELECT SUGPDIRECTOR_IDD FROM SUGPDIRECTOR WHERE SUGPDIRECTOR_IDP = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id_dir = $row['SUGPDIRECTOR_IDD'];

            
            if($id_dir == NULL) {

                $sql = "INSERT INTO DIRECTOR (DIRECTOR_NOM) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $director);
                $stmt->execute();
                $id_dir = $stmt->insert_id;

                $sql = "INSERT INTO PDIRECTOR (PDIRECTOR_IDD, PDIRECTOR_IDP) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id_dir, $id_obra);
                $stmt->execute();
            }
            else {

                $sql = "INSERT INTO PDIRECTOR (PDIRECTOR_IDD, PDIRECTOR_IDP) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id_dir, $id_obra);
                $stmt->execute();
            }

            $sql = "DELETE FROM SUGPDIRECTOR WHERE SUGPDIRECTOR_IDP = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGPELICULA WHERE SUGPELICULA_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        }
        else if($tipo == 2) { //Serie

            verificar_existencia_autoria($p_id_sug, 2);
            $sql = "SELECT * FROM SUGSERIE WHERE SUGSERIE_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $director = $row['SUGSERIE_DIRECTOR'];

            $sql = "INSERT INTO SERIE (SERIE_ID, SERIE_CAP, SERIE_TEMP) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $id_obra, $row['SUGSERIE_CAP'], $row['SUGSERIE_TEMP']);
            $stmt->execute();

            $sql = "SELECT SUGSDIRECTOR_IDD FROM SUGSDIRECTOR WHERE SUGSDIRECTOR_IDS = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id_dir = $row['SUGSDIRECTOR_IDD'];

            if($id_dir == NULL) {

                $sql = "INSERT INTO DIRECTOR (DIRECTOR_NOM) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $director);
                $stmt->execute();
                $id_dir = $stmt->insert_id;

                $sql = "INSERT INTO SDIRECTOR (SDIRECTOR_IDD, SDIRECTOR_IDS) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id_dir, $id_obra);
                $stmt->execute();
            }
            else {

                $sql = "INSERT INTO SDIRECTOR (SDIRECTOR_IDD, SDIRECTOR_IDS) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id_dir, $id_obra);
                $stmt->execute();
            }

            $sql = "DELETE FROM SUGSDIRECTOR WHERE SUGSDIRECTOR_IDS = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGSERIE WHERE SUGSERIE_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

        }
        else if($tipo == 3) { //Videojuego
                
                verificar_existencia_autoria($p_id_sug, 3);
                $sql = "SELECT * FROM SUGJUEGO WHERE SUGJUEGO_ID = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $desarrollador = $row['SUGJUEGO_DESARROLLADOR'];
    
                $sql = "INSERT INTO JUEGO (JUEGO_ID, JUEGO_DURACION) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id_obra, $row['SUGJUEGO_TIEMPO']);
                $stmt->execute();
    
                $sql = "SELECT SUGDESARROLLADOR_IDD FROM SUGDESARROLLADOR WHERE SUGDESARROLLADOR_IDJ = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $id_des = $row['SUGDESARROLLADOR_IDD'];

                if($id_des == NULL) {
    
                    $sql = "INSERT INTO DESARROLLADOR (DESARROLLADOR_NOM) VALUES (?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $desarrollador);
                    $stmt->execute();
                    $id_des = $stmt->insert_id;
    
                    $sql = "INSERT INTO JDESARROLLADOR (JDESARROLLADOR_IDD, JDESARROLLADOR_IDJ) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $id_des, $id_obra);
                    $stmt->execute();
                }
                else {
    
                    $sql = "INSERT INTO JDESARROLLADOR (JDESARROLLADOR_IDD, JDESARROLLADOR_IDJ) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $id_des, $id_obra);
                    $stmt->execute();
                }

                $sql ="SELECT * FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()) {
                    $id_plat = $row['SUGJPLATAFORMA_IDP'];
                    $sql = "INSERT INTO JPLATAFORMA (JPLATAFORMA_IDJ, JPLATAFORMA_IDP) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $id_obra, $id_plat);
                    $stmt->execute();
                }
    
                $sql = "DELETE FROM SUGDESARROLLADOR WHERE SUGDESARROLLADOR_IDJ = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $sql = "DELETE FROM SUGJUEGO WHERE SUGJUEGO_ID = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $sql = "DELETE FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();


        }
        else if($tipo == 4) { //Libro

                verificar_existencia_autoria($p_id_sug, 4);    
                $sql = "SELECT * FROM SUGLIBRO WHERE SUGLIBRO_ID = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $autor = $row['SUGLIBRO_AUTOR'];
    
                $sql = "INSERT INTO LIBRO (LIBRO_ID, LIBRO_ISBN) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $id_obra, $row['SUGLIBRO_ISBN']);
                $stmt->execute();
    
                $sql = "SELECT SUGAUTOR_IDA FROM SUGAUTOR WHERE SUGAUTOR_IDS = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $id_aut = $row['SUGAUTOR_IDA'];
    
                if($id_aut == NULL) {
    
                    $sql = "INSERT INTO AUTOR (AUTOR_NOM) VALUES (?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $autor);
                    $stmt->execute();
                    $id_aut = $stmt->insert_id;
    
                    $sql = "INSERT INTO LAUTOR (LAUTOR_IDA, LAUTOR_IDL) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $id_aut, $id_obra);
                    $stmt->execute();
                }
                else {
    
                    $sql = "INSERT INTO LAUTOR (LAUTOR_IDA, LAUTOR_IDL) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $id_aut, $id_obra);
                    $stmt->execute();
                }
    
                $sql = "DELETE FROM SUGAUTOR WHERE SUGAUTOR_IDS = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
    
                $sql = "DELETE FROM SUGLIBRO WHERE SUGLIBRO_ID = $p_id_sug";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
        }

        $sql = "DELETE FROM SUGOBRA WHERE SUGOBRA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    }
    else if($estado == 3) {

        if($tipo == 1) { //Pelicula

            $sql = "DELETE FROM SUGPDIRECTOR WHERE SUGPDIRECTOR_IDP = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGPELICULA WHERE SUGPELICULA_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
        }
        else if($tipo == 2) { //Serie

            $sql = "DELETE FROM SUGSDIRECTOR WHERE SUGSDIRECTOR_IDS = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGSERIE WHERE SUGSERIE_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        else if($tipo == 3) { //Videojuego

            $sql = "DELETE FROM SUGDESARROLLADOR WHERE SUGDESARROLLADOR_IDJ = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGJUEGO WHERE SUGJUEGO_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGJPLATAFORMA WHERE SUGJPLATAFORMA_IDS = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        else if($tipo == 4) { //Libro

            $sql = "DELETE FROM SUGAUTOR WHERE SUGAUTOR_IDS = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM SUGLIBRO WHERE SUGLIBRO_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        $sql = "DELETE FROM SUGOBRA WHERE SUGOBRA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        

        $stmt->close();
    }

}

function aniadir_sugerencia_categoria($p_id_sug) {
    
    global $conn;
    $sql = "SELECT * FROM SUGCATEGORIA WHERE SUGCATEGORIA_ID = $p_id_sug";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $estado = $row['SUGCATEGORIA_ESTADO'];
    if($estado == 2) {
        $nombre = $row['SUGCATEGORIA_NOM'];
        $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOM) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        $sql = "DELETE FROM SUGCATEGORIA WHERE SUGCATEGORIA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();


    }
    else if($estado == 3) {
        $sql = "DELETE FROM SUGCATEGORIA WHERE SUGCATEGORIA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    }

}

function aniadir_sugerencia_categoria_obra($p_id_sug) {
    
    global $conn;
    $sql = "SELECT * FROM SUGCATOBRA WHERE SUGCATOBRA_ID = $p_id_sug";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $estado = $row['SUGCATOBRA_ESTADO'];
    if($estado == 2) {
        $idc = $row['SUGCATOBRA_IDC'];
        $ido = $row['SUGCATOBRA_IDO'];

        $sql = "SELECT * FROM CATOBRA WHERE CATOBRA_IDC = $idc AND CATOBRA_IDO = $ido";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $sql = "DELETE FROM SUGCATOBRA WHERE SUGCATOBRA_ID = $p_id_sug";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->close();
            return;
        }

        $sql = "INSERT INTO CATOBRA (CATOBRA_IDC, CATOBRA_IDO) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $idc, $ido);
        $stmt->execute();

        $sql = "DELETE FROM SUGCATOBRA WHERE SUGCATOBRA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();

        
    }
    else if($estado == 3) {
        $sql = "DELETE FROM SUGCATOBRA WHERE SUGCATOBRA_ID = $p_id_sug";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    }
}

function aniadir_sugerencias($p_flag_tipo_sg, $p_id_sug) {
    if($p_flag_tipo_sg == 1) { //OBRA
        aniadir_sugerencia_obra($p_id_sug);
    }
    else if($p_flag_tipo_sg == 2) { //CATEGORIA
        aniadir_sugerencia_categoria($p_id_sug);
    }
    else if($p_flag_tipo_sg == 3) { //CATEGORIA_OBRA
        aniadir_sugerencia_categoria_obra($p_id_sug);
    }
}


?>
