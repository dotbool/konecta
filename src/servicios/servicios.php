<?php
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT,DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, X-Requested-With, Content-Type, Accept, Authorization");

require_once 'conn.php';
require_once 'querys.php';

function logg($texto){
    $file = fopen("pistas.txt", "a");
    fwrite($file, json_encode($texto) . PHP_EOL);
    fclose($file);
}


$data = file_get_contents('php://input');
$object_json = json_decode($data);


if($_SERVER['REQUEST_METHOD']=='GET'):
        print json_encode(indexUsuarios());

elseif($_SERVER['REQUEST_METHOD']=='POST'):
    if($object_json!=null):
        print json_encode(insertUsuario($object_json));
    endif;

elseif($_SERVER['REQUEST_METHOD']=='PUT'):
    if($object_json!=null):
        print json_encode(updateUsuario($object_json));
    endif;

elseif($_SERVER['REQUEST_METHOD']=='DELETE'):
    
    $id = isset($_REQUEST['id']) ? $_REQUEST['id']: null;
    if($id):
        print json_encode(deleteUsuario($id));
    endif;
endif;

?>