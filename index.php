<?php

include_once './response.php';
include_once './datos.php';
include_once './users.php';
include_once './materias.php';
include_once './profesores.php';
include_once './asignaciones.php';

session_start();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$pathInfo = $_SERVER['PATH_INFO'];

$respuesta = new Response;
$respuesta->data='';

switch($requestMethod)
{
    case 'GET':
        switch($pathInfo)
        {
            case '/materia':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isUser($token))
                {
                    $respuesta->data=Materia::MostrarMaterias();
                }else
                {
                    $respuesta->data='Token invalido, no tiene permisos';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/profesor':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isUser($token))
                {
                    $respuesta->data=Profesor::MostrarProfesores();
                }else
                {
                    $respuesta->data='Token invalido, no tiene permisos';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/asignacion':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isUser($token))
                {
                    $respuesta->data=Asignacion::MostrarAsignaciones();
                }else
                {
                    $respuesta->data='Token invalido, no tiene permisos';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            default:
            $respuesta->data= "Error en pathinfo";
            $respuesta->status= 'fail';
        break;
        }
    break;
    case 'POST':
        switch($pathInfo)
        {
            case '/usuario':
                if (isset($_POST['email']) && isset($_POST['clave'])
                && !empty($_POST['email']) && !empty($_POST['clave']))
                {
                    if (User::Singin($_POST['email'],$_POST['clave']))
                    {
                        $respuesta->data = 'Sign valido';
                    }else
                    {
                        $respuesta->data = 'Revisar datos';
                        $respuesta->status = 'fail';
                    }
                    
                }else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);

            break;
            case '/login':
                if (isset($_POST['email']) && isset($_POST['clave']) && 
                !empty($_POST['email']) && !empty($_POST['clave']))
                {
                    $respuesta->data = User::Login($_POST['email'],$_POST['clave']);
                }
                else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);

            break;
            case '/materia':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isUser($token))
                {
                    if (isset($_POST['nombre'])  && isset($_POST['cuatrimestre']) &&
                    !empty($_POST['nombre'])  && !empty($_POST['cuatrimestre']))
                    {
                        $respuesta->data = Materia::Save($_POST['nombre'], $_POST['cuatrimestre']);
                    }else
                    {
                        $respuesta->data='Faltan datos';
                        $respuesta->status='fail';
                    }
                }else
                {
                    $respuesta->data='Token invalido, no tiene permisos';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/profesor':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isUser($token))
                {
                    if (isset($_POST['nombre'])  && isset($_POST['legajo']) && isset($_FILES['imagen']) &&
                    !empty($_POST['nombre'])  && !empty($_POST['legajo']) && !empty($_FILES['imagen']))
                    {
                        $respuesta->data = Profesor::Save($_POST['nombre'], $_POST['legajo'], $_FILES['imagen']['tmp_name']);
                        move_uploaded_file($_FILES['imagen']['tmp_name'], 'imagenes/'.$_FILES['imagen']['name']);
                    }else
                    {
                        $respuesta->data='Faltan datos';
                        $respuesta->status='fail';
                    }
                }else
                {
                    $respuesta->data='Token invalido, no tiene permisos';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/asignacion':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isUser($token))
                {
                    if (isset($_POST['legajo'])  && isset($_POST['id']) && isset($_POST['turno']) &&
                    !empty($_POST['legajo'])  && !empty($_POST['id']) && !empty($_POST['turno']))
                    {
                        $respuesta->data = Asignacion::Save($_POST['legajo'], $_POST['id'], $_POST['turno']);
                    }else
                    {
                        $respuesta->data='Faltan datos';
                        $respuesta->status='fail';
                    }
                }else
                {
                    $respuesta->data='Token invalido, no tiene permisos';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            default:
            $respuesta->data= "Error en pathinfo";
            $respuesta->status= 'fail';
            break;
        }
    break;
    default:
    $respuesta->data= "Metodo no permitido";
    $respuesta->status= 'fail';
break;
}