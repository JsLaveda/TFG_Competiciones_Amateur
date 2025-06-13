<?php
// model/EquipoModel.php

class EquipoModel
{
    // Conexión a la base de datos
    protected $db;

    // Atributos que coinciden con los campos de la tabla equipo
    private $id_equipo;
    private $nombre;
    private $id_competicion;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_equipo()
    {
        return $this->id_equipo;
    }

    public function setId_equipo($id)
    {
        $this->id_equipo = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getId_competicion()
    {
        return $this->id_competicion;
    }

    public function setId_competicion($id_competicion)
    {
        $this->id_competicion = $id_competicion;
    }

    // Obtener todos los equipos
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM equipo');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "EquipoModel");
    }

    // Obtener un equipo por ID
    public function getById($id_equipo)
    {
        $consulta = $this->db->prepare('SELECT * FROM equipo WHERE id_equipo = ?');
        $consulta->bindParam(1, $id_equipo);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "EquipoModel");
        return $consulta->fetch();
    }

    // Guardar o actualizar
    public function save()
    {
        if (!isset($this->id_equipo)) {
            $consulta = $this->db->prepare('INSERT INTO equipo (nombre, id_competicion) VALUES (?, ?)');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->id_competicion);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE equipo SET nombre = ?, id_competicion = ? WHERE id_equipo = ?');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->id_competicion);
            $consulta->bindParam(3, $this->id_equipo);
            $consulta->execute();
        }
    }

    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM equipo WHERE id_equipo = ?');
        $consulta->bindParam(1, $this->id_equipo);
        $consulta->execute();
    }

    // Obtener numero de equipos en una competición
    public function contarEquiposPorCompeticion($id_competicion)
{
    $consulta = $this->db->prepare('SELECT COUNT(*) FROM equipo WHERE id_competicion = ?');
    $consulta->bindParam(1, $id_competicion, PDO::PARAM_INT);
    $consulta->execute();
    return (int) $consulta->fetchColumn();
}

}
