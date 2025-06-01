<?php
// model/CompeticionModel.php

class CompeticionModel
{
    // Conexión a la base de datos
    protected $db;

    // Atributos del modelo
    private $id_competicion;
    private $nombre;
    private $fecha_inicio;
    private $fecha_fin;
    private $privacidad;
    private $tipo_competicion;
    private $creador;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_competicion() { return $this->id_competicion; }
    public function setId_competicion($id) { $this->id_competicion = $id; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getFecha_inicio() { return $this->fecha_inicio; }
    public function setFecha_inicio($fecha_inicio) { $this->fecha_inicio = $fecha_inicio; }

    public function getFecha_fin() { return $this->fecha_fin; }
    public function setFecha_fin($fecha_fin) { $this->fecha_fin = $fecha_fin; }

    public function getPrivacidad() { return $this->privacidad; }
    public function setPrivacidad($privacidad) { $this->privacidad = $privacidad; }

    public function getTipo_competicion() { return $this->tipo_competicion; }
    public function setTipo_competicion($tipo_competicion) { $this->tipo_competicion = $tipo_competicion; }

    public function getCreador() { return $this->creador; }
    public function setCreador($creador) { $this->creador = $creador; }

    // Obtener todas las competiciones
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM competicion');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "CompeticionModel");
    }

    // Obtener una competición por ID
    public function getById($id)
    {
        $consulta = $this->db->prepare('SELECT * FROM competicion WHERE id_competicion = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "CompeticionModel");
        return $consulta->fetch();
    }

    // Insertar o actualizar
    public function save()
    {
        if (!isset($this->id_competicion)) {
            $consulta = $this->db->prepare(
                'INSERT INTO competicion (nombre, fecha_inicio, fecha_fin, privacidad, tipo_competicion, creador)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->fecha_inicio);
            $consulta->bindParam(3, $this->fecha_fin);
            $consulta->bindParam(4, $this->privacidad);
            $consulta->bindParam(5, $this->tipo_competicion);
            $consulta->bindParam(6, $this->creador);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare(
                'UPDATE competicion SET nombre = ?, fecha_inicio = ?, fecha_fin = ?, privacidad = ?, tipo_competicion = ?, creador = ?
                 WHERE id_competicion = ?'
            );
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->fecha_inicio);
            $consulta->bindParam(3, $this->fecha_fin);
            $consulta->bindParam(4, $this->privacidad);
            $consulta->bindParam(5, $this->tipo_competicion);
            $consulta->bindParam(6, $this->creador);
            $consulta->bindParam(7, $this->id_competicion);
            $consulta->execute();
        }
    }

    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM competicion WHERE id_competicion = ?');
        $consulta->bindParam(1, $this->id_competicion);
        $consulta->execute();
    }
}

