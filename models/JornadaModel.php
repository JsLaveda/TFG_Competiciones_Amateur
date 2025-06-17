<?php
// model/JornadaModel.php

class JornadaModel
{
    // Conexión a la base de datos
    protected $db;

    // Atributos del modelo
    private $id_jornada;
    private $fecha_jornada;
    private $id_competicion;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_jornada() { return $this->id_jornada; }
    public function setId_jornada($id) { $this->id_jornada = $id; }

    public function getFecha_jornada() { return $this->fecha_jornada; }
    public function setFecha_jornada($fecha) { $this->fecha_jornada = $fecha; }

    public function getId_competicion() { return $this->id_competicion; }
    public function setId_competicion($id_competicion) { $this->id_competicion = $id_competicion; }

    // Obtener todas las jornadas
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM jornada');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "JornadaModel");
    }

    // Obtener una jornada por ID
    public function getById($id)
    {
        $consulta = $this->db->prepare('SELECT * FROM jornada WHERE id_jornada = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "JornadaModel");
        return $consulta->fetch();
    }

    // Obtener jornadas por competición
    public function getJornadasByCompeticion($id_competicion)
{
    $consulta = $this->db->prepare('SELECT * FROM jornada WHERE id_competicion = ? ORDER BY fecha_jornada ASC');
    $consulta->bindParam(1, $id_competicion);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS, "JornadaModel");
}

    // Guardar o actualizar
    public function save()
    {
        if (!isset($this->id_jornada)) {
            $consulta = $this->db->prepare(
                'INSERT INTO jornada (fecha_jornada, id_competicion) VALUES (?, ?)'
            );
            $consulta->bindParam(1, $this->fecha_jornada);
            $consulta->bindParam(2, $this->id_competicion);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare(
                'UPDATE jornada SET fecha_jornada = ?, id_competicion = ? WHERE id_jornada = ?'
            );
            $consulta->bindParam(1, $this->fecha_jornada);
            $consulta->bindParam(2, $this->id_competicion);
            $consulta->bindParam(3, $this->id_jornada);
            $consulta->execute();
        }
    }

    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM jornada WHERE id_jornada = ?');
        $consulta->bindParam(1, $this->id_jornada);
        $consulta->execute();
    }
}
