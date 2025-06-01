<?php
// model/TipoCompeticionModel.php

class TipoCompeticionModel
{
    // Conexión a la base de datos
    protected $db;

    // Atributos del modelo
    private $id_tipo_competicion;
    private $nombre_competicion;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_tipo_competicion()
    {
        return $this->id_tipo_competicion;
    }

    public function setId_tipo_competicion($id)
    {
        $this->id_tipo_competicion = $id;
    }

    public function getNombre_competicion()
    {
        return $this->nombre_competicion;
    }

    public function setNombre_competicion($nombre)
    {
        $this->nombre_competicion = $nombre;
    }

    // Obtener todos
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM tipo_competicion');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "TipoCompeticionModel");
    }

    // Obtener uno por ID
    public function getById($id)
    {
        $consulta = $this->db->prepare('SELECT * FROM tipo_competicion WHERE id_tipo_competicion = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "TipoCompeticionModel");
        return $consulta->fetch();
    }

    // Guardar (insertar o actualizar)
    public function save()
    {
        if (!isset($this->id_tipo_competicion)) {
            $consulta = $this->db->prepare('INSERT INTO tipo_competicion (nombre_competicion) VALUES (?)');
            $consulta->bindParam(1, $this->nombre_competicion);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE tipo_competicion SET nombre_competicion = ? WHERE id_tipo_competicion = ?');
            $consulta->bindParam(1, $this->nombre_competicion);
            $consulta->bindParam(2, $this->id_tipo_competicion);
            $consulta->execute();
        }
    }

    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM tipo_competicion WHERE id_tipo_competicion = ?');
        $consulta->bindParam(1, $this->id_tipo_competicion);
        $consulta->execute();
    }
}
