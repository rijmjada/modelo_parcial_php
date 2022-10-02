<?php

/*
ListadoEmpleados.php: (GET) Se mostrará el listado completo de los empleados (obtenidos de la base de
datos) en una tabla (HTML con cabecera). Invocar al método TraerTodos.
Nota: preparar la tabla (HTML) con una columna extra para que muestre la imagen de la foto (50px X 50px).
*/

require_once("./clases/Empleado.php");

$str = "<table>
<tr>
    <th>Id</th>
    <th>Nombre</th>
    <th>Correo</th>
    <th>Clave</th>
    <th>Perfil</th>
    <th>Sueldo</th>
    <th>Foto</th>
</tr> ";

$empleados = Empleado::TraerTodos();

foreach ($empleados as $empleado) {
    $str .= " 
        <tr>
            <td>$empleado->id</td>
            <td>$empleado->nombre</td>
            <td>$empleado->correo</td>
            <td>$empleado->clave</td>
            <td>$empleado->perfil</td>
            <td>$empleado->sueldo</td>
            <td> <img src='../$empleado->foto' width='50px' height='50px'/> </td>
        </tr>";
}


echo $str . "</table>";
