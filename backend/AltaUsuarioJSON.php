<?php
/*
AltaUsuarioJSON.php: Se recibe por POST el correo, la clave y el nombre. Invocar al método
GuardarEnArchivo.
*/

require_once("./clases/Usuario.php");

$clave = isset($_POST["clave"]) ? (int) $_POST["clave"] : 0;
$correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";

$usuarito = new Usuario();

$usuarito->nombre = $nombre;
$usuarito->correo = $correo;
$usuarito->clave = $clave;

print($usuarito->GuardarEnArchivo());
