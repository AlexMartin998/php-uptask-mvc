<?php

namespace Model;

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $dbColumns = [];

    // Alertas y Mensajes
    protected static $alerts = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlert($tipo, $mensaje)
    {
        static::$alerts[$tipo][] = $mensaje;
    }
    // Validación
    public static function getAlerts()
    {
        return static::$alerts;
    }

    public function validar()
    {
        static::$alerts = [];
        return static::$alerts;
    }

    // Create - CRUD
    public function save()
    {
        $result = '';
        if (!is_null($this->id)) {
            // actualizar
            $result = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $result = $this->crear();
        }
        return $result;
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$table;
        $result = self::consultarSQL($query);
        return $result;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = $id";
        $result = self::consultarSQL($query);
        return array_shift($result);
    }

    // Obtener Registro
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$table . " LIMIT $limite";
        $result = self::consultarSQL($query);
        return array_shift($result);
    }

    // Search by column (WHERE)
    public static function where($column, $value)
    {
        $query = "SELECT * FROM " . static::$table . " WHERE $column = '$value'";
        $result = self::consultarSQL($query);
        return array_shift($result);
    }

    // search for all records belonging to an ID
    public static function belongsTo($column, $value)
    {
        $query = "SELECT * FROM " . static::$table . " WHERE $column = '$value'";
        $result = self::consultarSQL($query);
        return $result;
    }


    // SQL para Consultas Avanzadas.
    public static function SQL($consulta)
    {
        $query = $consulta;
        $result = self::consultarSQL($query);
        return $result;
    }

    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $result = self::$db->query($query);

        return [
            'resultado' =>  $result,
            'id' => self::$db->insert_id
        ];
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$table . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // debuguear($query);

        $result = self::$db->query($query);
        return $result;
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $result = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $result->free();

        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$dbColumns as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function synchronize($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
