<?php

require '../core/Router.php';
require '../app/controllers/PistasController.php';
require '../app/models/Pista.php';
require '../app/models/Response.php';
require '../vendor/CodigosRespuesta.php';

$url = $_SERVER['QUERY_STRING'];
// echo 'URL = '. $url . '<br>';

$router = new Router();

$router->add('/public', array(
    'controller'=>'Home',
    'action'=>'index' 
));

// $router->add('/public/post/new', array(
//     'controller'=>'Post',
//     'action'=>'new' 
// ));

$router->add('/public/pistas/get', array(
    'controller'=>'PistasController',
    'action'=>'getAll' 
));

$router->add('/public/pistas/get/{id}', array(
    'controller'=>'PistasController',
    'action'=>'index' 
));

$router->add('/public/reservas/new', array(
    'controller'=>'Reservas',
    'action'=>'addReserva' 
));

$router->add('/public/reservas/new', array(
    'controller'=>'Reservas',
    'action'=>'addReserva' 
));

$router->add('/public/reservas/confirmar/{id}', array(
    'controller'=>'Reservas',
    'action'=>'confirmarReserva' 
));

$router->add('/public/reservas/anular/{id}', array(
    'controller'=>'Reservas',
    'action'=>'addReserva' 
));

// echo 'router: <pre>';
// print_r($router->getRoutes()) . '<br>';
// echo '</pre>';

$urlParams = explode('/', $url);

$urlArray = array(
    'HTTP'=>$_SERVER['REQUEST_METHOD'],
    'path'=>$url,
    'controller'=>'',
    'action'=>'',
    'params'=>''
);

if (!empty($urlParams[2])){
    $urlArray['controller'] = ucwords($urlParams[2]);    
    if (!empty($urlParams[3])){
        $urlArray['action'] = $urlParams[3];
        if (!empty($urlParams[4])){
            $urlArray['params'] = $urlParams[4];
        }
    }else{
        $urlArray['action'] = 'index';
    }
}else{
    $urlArray['controller'] = 'Home';
    $urlArray['action'] = 'index';
}



if($router->matchRoute($urlArray)){

    $method = $_SERVER['REQUEST_METHOD'];

    $params = [];

    if ($method === 'GET'){
        $params[]=intval( $urlArray['params']) ?? null;
    }elseif ($method === 'POST') {
        
        $json = file_get_contents('php://input');
        $params[]=json_decode($json, true);

    }elseif ($method === 'PUT') {
        
        $id=intval( $urlArray['params']) ?? null;
        $json = file_get_contents('php://input');
        $params[]=$id;
        $params[]=json_decode($json, true);

    }elseif ($method === 'DELETE') {
        $params[]=intval( $urlArray['params']) ?? null;
    }

    $controller = $router->getParams()['controller'];
    $action=$router->getParams()['action'];
    $controller = new $controller();



    if (method_exists($controller, $action)){
        $resp = call_user_func_array([$controller, $action], $params);

    }else{
        echo "El método no existe";
    }

}else{
    echo'No route found for URL ' . $url;
}



// if($router->match($urlArray)){
//     $controller = $router->getParams()['controller'];
//     $action=$router->getParams()['action'];

//     $controller = new $controller();
//     $controller->$action();
// }else{
//     echo'No route found for URL ' . $url;
// }

// echo 'urlParams: <pre>';
// print_r($urlParams) . '<br>';
// echo '</pre>';

// echo 'urlArray<pre>';
// print_r($urlArray) . '<br>';
// echo '</pre>';
?>