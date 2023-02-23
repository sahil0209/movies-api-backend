<?php


// include('src/Database.php');
// include('src/controllers/MovieController.php');
// include('src/gateways/MovieGateway.php');
// include('src/controllers/ReviewController.php');
// include('src/gateways/ReviewGateway.php');


// For autloading all the functions

spl_autoload_register(function($class_name){
    $path = null;
    if(str_contains($class_name,"Controller")){
        $path = "src/controllers/".$class_name.'.php';
    } else if(str_contains($class_name,"Gateway")){
        $path = "src/gateways/".$class_name.'.php';
    } else{
        $path = "src/".$class_name.'.php';
    }
    // echo $path;
    include $path;
});

set_exception_handler("ErrorHandler::handleException");

$urlparts = explode("/", $_SERVER['REQUEST_URI']);
$id = $urlparts[4] ?? null;


$database = new Database();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, DELETE");
header("Access-Control-Allow-Headers: *");
header('Content-Type:application/json;charset=UTF-8');

if($urlparts[3]==="movies"){
    $movieGateway = new MovieGateway($database);
    $movieController = new MovieController($movieGateway);
    $movieController->handleRequest($_SERVER['REQUEST_METHOD'],$id);
} else if($urlparts[3]==="reviews"){
    $reviewGateway = new ReviewGateway($database);
    $reviewController = new ReviewController($reviewGateway);
    $reviewController->handleRequest($_SERVER['REQUEST_METHOD'],$id);
}


?>