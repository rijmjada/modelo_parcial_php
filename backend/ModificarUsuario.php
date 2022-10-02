<?php
/*
ModificarUsuario.php: Se recibirán por POST los siguientes valores: usuario_json (id, nombre, correo, clave y
id_perfil, en formato de cadena JSON), para modificar un usuario en la base de datos. Invocar al método
Modificar.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Usuario.php");

#region retorno
$ret = new stdClass();
$ret->exito = false;
$ret->mensaje = "No se pudo modificar el usuario";
#endregion

$usuario_json = file_get_contents('php://input');

$user_decode = json_decode($usuario_json, false);

$usuario = new Usuario();
$usuario->id = $user_decode->id;
$usuario->nombre = $user_decode->nombre;
$usuario->correo = $user_decode->correo;
$usuario->clave = $user_decode->clave;
$usuario->id_perfil = $user_decode->id_perfil;

if($usuario->Modificar())
{
    $ret->exito = true;
    $ret->mensaje = "Usuario modificado";
}

$ret = json_encode($ret);

echo $ret;
