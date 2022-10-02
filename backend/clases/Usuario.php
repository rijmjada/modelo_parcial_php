<?php

require_once("accesoDatos.php");
require_once("IBM.php");


class Usuario implements IBM
{
    #region Atributos
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;
    #endregion

    #region JsonMetodos
    // Método de instancia ToJSON(), que retornará los datos de la instancia nombre, correo y clave (en una cadena con formato JSON)
    public function ToJSON(): string
    {
        $obj = new stdClass;
        $obj->nombre = $this->nombre;
        $obj->correo = $this->correo;
        $obj->clave = $this->clave;

        return json_encode($obj);
    }

    // Método de instancia GuardarEnArchivo(), que agregará al usuario en ./backend/archivos/usuarios.json.
    // Retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. 
    public function GuardarEnArchivo()
    {
        $ret = new stdClass;
        $ret->exito = false;
        $ret->mensaje = "error";

        $usersArray = Usuario::TraerTodosJSON();    // Traigo todos los usuarios guardados en usuarios.json
        $obj = $this->ToJSON();
        array_push($usersArray, json_decode($obj));             // Agrego al array la instancia actual usuario
        $filename = "./archivos/usuarios.json";
        try {
            $file = fopen($filename, "w");          // Sobreescribo el archivo
            if ($file) {
                $json = json_encode($usersArray);
                fwrite($file, $json);
                $ret->exito = true;
                $ret->mensaje = "todo ok";
            }
        } catch (Exception) {
            echo "Error al guardar el archivo";
        } finally {
            fclose($file);
            return json_encode($ret);
        }
    }

    // Método de clase TraerTodosJSON(), que retornará un array de objetos de tipo Usuario, recuperado del archivo usuarios.json.
    public static function TraerTodosJSON(): array
    {
        $usuarios = array();
        $ruta_archivo = "./archivos/usuarios.json";
        try {
            $json = file_get_contents($ruta_archivo);
            if ($json) {
                $decode_json = json_decode($json, true);
                foreach ($decode_json as $item) {
                    $usuario = new Usuario();
                    $usuario->nombre = $item["nombre"];
                    $usuario->correo = $item["correo"];
                    $usuario->clave = $item["clave"];

                    array_push($usuarios, $usuario);
                }
            }
        } catch (Exception) {
            echo "Ocurrio un error en TraerTodosJSON()";
        } finally {
            return $usuarios;
        }
    }
    #endregion

    #region Metodos Base de Datos
    // Método de instancia Agregar(): agrega, a partir de la instancia actual, un nuevo registro en la tabla usuarios
    // (id,nombre, correo, clave e id_perfil), de la base de datos usuarios_test. Retorna true, si se pudo agregar,
    // false, caso contrario.
    public function Agregar(): bool
    {
        $retorno = false;
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->retornarConsulta("INSERT INTO usuarios(id, nombre, correo, clave, id_perfil) 
                                            VALUES (null, :nombre, :correo, :clave, :id_perfil)");

            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

            $retorno = $consulta->execute();
        } catch (Exception $e) {
            print($e);
        } finally {
            return $retorno;
        }
    }

    // Método de clase TraerTodos(): retorna un array de objetos de tipo Usuario, recuperados de la base de datos (con la descripción del perfil correspondiente).
    public static function TraerTodos(): array
    {
        $array_ret = array();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("SELECT usuarios.id as id, nombre, correo, clave, id_perfil, perfiles.descripcion as perfil FROM usuarios, perfiles WHERE usuarios.id_perfil=perfiles.id;");

        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);

        $temp_array = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

        if ($temp_array != false)
            $array_ret = $temp_array;

        return $array_ret;
    }


    // Método de clase TraerUno($params): retorna un objeto de tipo Usuario, de acuerdo al correo y clave que ser reciben en el parámetro $params.
    public static function TraerUno($params)
    {
        $recupero_json = json_decode($params);

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM `usuarios` WHERE correo=:correo AND clave=:clave");
        $consulta->bindValue(':correo', $recupero_json->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $recupero_json->clave, PDO::PARAM_STR);

        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");

        return $consulta->fetch();
    }

    // IBM - Modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
    // Retorna true, si se pudo modificar, false, caso contrario.
    public function Modificar(): bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE usuarios
              SET correo=:correo, clave=:clave, nombre=:nombre, id_perfil=:id_perfil 
                WHERE usuarios.id=:id");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

        $consulta->execute();

        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }

    // IBM - Eliminar (estático): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro.
    // Retorna true, si se pudo eliminar, false, caso contrario.
    public static function Eliminar($id): bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta("DELETE FROM `usuarios` WHERE id=:id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }


    #endregion

}
