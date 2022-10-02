<?php
/*
ListadoUsuarios.php: (GET) Se mostrará el listado completo de los usuarios, exepto la clave (obtenidos de la
base de datos) en una tabla (HTML con cabecera). Invocar al método TraerTodos.
*/

require_once("./clases/Usuario.php");

$str = "<table>
<tr>
    <th>Id</th>
    <th>Nombre</th>
    <th>Correo</th>
    <th>Id_Perfil</th>
    <th>Perfil</th> 

</tr> ";

$usuarios = Usuario::TraerTodos();

foreach ($usuarios as $item) {
    $str .= " 
        <tr>
            <td>$item->id</td>
            <td>$item->nombre</td>
            <td>$item->correo</td>
            <td>$item->id_perfil</td>
            <td>$item->perfil</td>
        </tr>";
}


echo $str . "</table>";
