<?php

/*
AltaUsuario.php: Se recibe por POST el correo, la clave, el nombre y el id_perfil. Se invocará al método
Agregar.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Usuario.php");

$correo = $_POST['correo'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$id_perfil = (int) $_POST['id_perfil'];

#region retorno
$ret = new stdClass();
$ret->exito = false;
$ret->mensaj = "No se agrego el usuario";
#endregion

$usuarito = new Usuario();
$usuarito->correo = $correo;
$usuarito->clave = $clave;
$usuarito->nombre = $nombre;
$usuarito->id_perfil = $id_perfil;

if ($usuarito->Agregar() === true) {
    $ret->exito = true;
    $ret->mensaj="Usuario Agregado";
} 

$ret = json_encode($ret);

echo $ret;