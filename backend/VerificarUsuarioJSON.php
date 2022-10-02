<?php
/*
VerificarUsuarioJSON.php: (POST) Se recibe el parámetro usuario_json (correo y clave, en
formato de cadena JSON) y se invoca al método TraerUno.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/
require_once("./clases/Usuario.php");

$data = file_get_contents('php://input');

$ret = new stdClass();
$ret->exito = false;
$ret->mensaj = "No se encontro el usuario";

if (Usuario::TraerUno($data) !== false) {
    $ret->exito = true;
    $ret->mensaj = "El usuario se encuentra en la base de datos";
}

$ret = json_encode($ret);

echo $ret;
