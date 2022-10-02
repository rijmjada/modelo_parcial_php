<?php

/*
EliminarEmpleado.php: Recibe el parámetro id por POST y se deberá borrar el empleado (invocando al
método Eliminar).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Empleado.php");

$id = $_POST["id"];

#region ReturnJson
$ret = new stdClass();
$ret->exito = false;
$ret->mensaje = "No se pudo eliminar el empleado";
#endregion

if(Empleado::Eliminar($id))
{
    $ret->exito = true; $ret->mensaje = "Empleado eliminado";
}

$ret = json_encode($ret);

echo $ret;
