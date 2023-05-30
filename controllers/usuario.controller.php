<?php
// Heredamos la sesion
session_start();

//La sesion contendrá datos del login en formato de arreglo
$_SESSION['login'] = [];

require_once '../models/Usuario.php';

    if(isset($_GET['operacion'])){

        $usuario = new Usuario();    

        if($_GET['operacion'] == 'login'){
            // 0. Array que sera leido por la vista
            $resultado = [
                "acceso"      => false,
                "idusers"    => "",
                "mensaje"     => "",
                "surnames"    => "",
                "namess"      => "",
                "accesslevel" => ""
            ];

            // 1. Verificar si existe el usuario
            $data = $usuario->login($_GET['email']);

                if($data){
                    
                    // 2. El usuario si existe, debemos validar la clave
                    $claveEncriptada = $data['accesskey'];
    
                    // 3. Comprobar la clave de entrada con la encriptada
    
                    if (password_verify($_GET['accesskey'], $claveEncriptada)){
    
                        // Enviamos toda la info del usuario
                        $resultado["acceso"] = true;
                        $resultado["mensaje"] = "Bienvenido al sistema";
                        $resultado["idusers"] = $data['idusers'];
                        $resultado["surnames"] = $data['surnames'];
                        $resultado["namess"] = $data['namess'];
                        $resultado["accesslevel"] = $data['accesslevel'];
    
                    } else {
                        // La contraseña es incorrecta
                        $resultado["acceso"] = false;
                        $resultado["mensaje"] = "La contraseña es incorrecta";
                    }
                } else {
                    // No existe el usuario
                    $resultado["acceso"] = false;
                    $resultado["mensaje"] = "El usuario no existe";
                }
                //Actualizamos la información en la variable de sesíon
                $_SESSION["login"] = $resultado;

                //Enviando información de la sesion a la vista
                echo json_encode($resultado);
        }

        if($_GET['operacion'] == 'registrarUsuario'){

            $datosSolicitados = [
                "surnames"     => $_GET['surnames'],
                "namess"       => $_GET['namess'],
                "email"        => $_GET['email'],
                "accesslevel"  => $_GET['accesslevel'],
                "accesskey"    => password_hash($_GET['accesskey'], PASSWORD_BCRYPT)
                
            ];

            $usuario->registrarUsuario($datosSolicitados);
        }

        if($_GET['operacion'] == 'cerrar-sesion'){
            session_destroy();
            session_unset();
            header("location:../index.php");
        }

        if($_GET['operacion'] == 'listarUsuarios'){
            echo json_encode($usuario->listarUsuarios());
        }

        if($_GET['operacion'] == 'eliminarUsuario'){
            $usuario->eliminarUsuario($_GET['idusers']);
        }

        if ($_GET['operacion'] == 'getUsers'){
            echo json_encode($usuario->getUsers($_GET['idusers']));   
        }

        if($_GET['operacion'] == 'actualizarUsuario'){
            $datosSolicitados = [
                "idusers"       => $_GET['idusers'],
                "namess"        => $_GET['namess'],
                "surnames"      => $_GET['surnames'],
                "email"         => $_GET['email'],
                "accesslevel"   => $_GET['accesslevel'],
                "accesskey"     => password_hash($_GET['accesskey'], PASSWORD_BCRYPT)
            ];
            
            $usuario->actualizarUsuario($datosSolicitados);
        }

        if($_GET['operacion'] == 'validacionUsuario'){
            echo json_encode($usuario->validacionUsuario($_GET['email']));
        }
    }

?>