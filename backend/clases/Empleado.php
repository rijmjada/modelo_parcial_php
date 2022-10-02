<?php

require_once("ICRUD.php");
require_once("Usuario.php");


class Empleado extends Usuario implements ICRUD
{
    #region Atributos
    public string $foto;
    public int $sueldo;
    #endregion


    #region Metodos

    // TraerTodos (de clase): retorna un array de objetos de tipo Empleado, recuperados de la base de datos (con la
    // descripción del perfil correspondiente y su foto).
    public static function TraerTodos(): array
    {
        $array_ret = array();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("SELECT empleados.id as id, nombre, correo, clave, foto, sueldo, id_perfil, perfiles.descripcion
                                                         as perfil FROM empleados, perfiles WHERE empleados.id_perfil=perfiles.id;");

        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_INTO, new Empleado);

        $temp_array = $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");

        if ($temp_array != false)
            $array_ret = $temp_array;

        return $array_ret;
    }

    /*Agregar (de instancia): agrega, a partir de la instancia actual, un nuevo registro en la tabla empleados
    (id,nombre, correo, clave, id_perfil, foto y sueldo), de la base de datos usuarios_test. Retorna true, si se pudo
    agregar, false, caso contrario.
    Nota: La foto guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre punto tipo
    punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg).*/
    public function Agregar(): bool
    {
        $foto_json_decode = json_decode($this->foto);
        $nombre_archivo = $foto_json_decode->name . "." . date("his");
        $destino_archivo =  "./empleados/fotos/" . $nombre_archivo . ".jpg";
        $ruta_bd = "./backend/empleados/fotos/" . $nombre_archivo . ".jpg";
        $retorno = false;

        if (move_uploaded_file($foto_json_decode->tmp_name, $destino_archivo)) {
            try {

                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

                $consulta = $objetoAccesoDato->retornarConsulta("INSERT INTO empleados(id, nombre, correo, clave, id_perfil, foto, sueldo) 
                                                VALUES (null, :nombre, :correo, :clave, :id_perfil, :foto, :sueldo)");

                $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
                $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
                $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
                $consulta->bindValue(':foto', $ruta_bd , PDO::PARAM_STR);
                $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);

                $consulta->execute();

                $retorno = true;

            } catch (Exception $e) {
                print($e);
            }
        }
        return $retorno;
    }

    public static function Eliminar($id): bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("DELETE FROM `empleados` WHERE id=:id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }



    #endregion
}
