<?php
/*
AltaEmpleado.php: Se recibirán por POST todos los valores: nombre, correo, clave, id_perfil, sueldo y foto
para registrar un empleado en la base de datos.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Empleado.php");

#region retorno
$ret = new stdClass();
$ret->exito = false;
$ret->mensaj = "No se agrego el usuario";
#endregion

#region Datos POST
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$id_perfil = (int) $_POST["id_perfil"];
$sueldo = (int) $_POST["sueldo"];
$foto = $_FILES["foto"];
#endregion


#region Creo el empleado
$emp = new Empleado();
$emp->nombre = $nombre;
$emp->correo = $correo;
$emp->clave = $clave;
$emp->id_perfil = $id_perfil;
$emp->sueldo = $sueldo;
$emp->foto = json_encode($foto);
#endregion

#region Agrego el empleado a la base de datos

if ($emp->Agregar() === true) {
    $ret->exito = true;
    $ret->mensaj = "Usuario Agregado";
}

$ret = json_encode($ret);

echo $ret;
#endregion