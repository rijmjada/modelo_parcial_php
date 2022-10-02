<?php
/*
EliminarUsuario.php: Si recibe el parámetro id por POST, más el parámetro accion con valor "borrar", se
deberá borrar el usuario (invocando al método Eliminar).
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Usuario.php");

#region retorno
$ret = new stdClass();
$ret->exito = false;
$ret->mensaje = "No se pudo modificar el usuario";
#endregion

$id = isset($_POST["id"]) ? (int) $_POST["id"] : 0;
$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

if($accion === "borrar")
{
    if(Usuario::Eliminar($id) === true)
    {
        $ret->exito = true;
        $ret->mensaje = "Usuario eliminado";
    }
    $ret = json_encode($ret);
}

echo $ret;
