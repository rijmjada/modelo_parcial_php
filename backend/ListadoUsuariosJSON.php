<?php

// ListadoUsuariosJSON.php: (GET) Se mostrarĂ¡ el listado de todos los usuarios en formato JSON.

require_once("./clases/Usuario.php");


var_dump(Usuario::TraerTodosJSON());

