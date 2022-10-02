<?php
require_once("./backend/clases/Usuario.php");
require_once("./backend/clases/Empleado.php");

$emp = new Empleado();
$emp->Agregar();

//var_dump(Empleado::TraerTodos());
// $usuarito = new Usuario();

// $usuarito->id = 3;
// $usuarito->nombre = "romina";
// $usuarito->correo = "romina@gmail.com";
// $usuarito->clave = "romina";
// $usuarito->id_perfil = 2;

// $json = new stdClass();
// $json->clave = "admin123";
// $json->correo = "admin@admin.com";
// $json = json_encode($json);


//var_dump(Usuario::TraerTodos());
//print(gettype(Usuario::TraerUno($json)));

//echo $usuarito->Agregar();

// echo $usuarito->Modificar();

// $var = Usuario::Eliminar(1);
// echo $var;