<?php
// model/PartidoModel.php

class PartidoModel
{
    // Conexión a la base de datos
    protected $db;

    // Atributos del modelo (coinciden con la tabla partido)
    private $id_partido;
    private $puntuacion1;
    private $puntuacion2;
    private $equipo1;
    private $equipo2;
    private $id_jornada;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_partido() { return $this->id_partido; }
    public function setId_partido($id) { $this->id_partido = $id; }

    public function getPuntuacion1() { return $this->puntuacion1; }
    public function setPuntuacion1($p1) { $this->puntuacion1 = $p1; }

    public function getPuntuacion2() { return $this->puntuacion2; }
    public function setPuntuacion2($p2) { $this->puntuacion2 = $p2; }

    public function getEquipo1() { return $this->equipo1; }
    public function setEquipo1($eq1) { $this->equipo1 = $eq1; }

    public function getEquipo2() { return $this->equipo2; }
    public function setEquipo2($eq2) { $this->equipo2 = $eq2; }

    public function getId_jornada() { return $this->id_jornada; }
    public function setId_jornada($id_jornada) { $this->id_jornada = $id_jornada; }

    // Obtener todos
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM partido');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "PartidoModel");
    }

    // Obtener por ID
    public function getById($id)
    {
        $consulta = $this->db->prepare('SELECT * FROM partido WHERE id_partido = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "PartidoModel");
        return $consulta->fetch();
    }
    // Obtener competición por jornada
    public function getIdCompeticionByJornada($id_jornada)
    {
        $consulta = $this->db->prepare('
            SELECT id_competicion 
            FROM jornada 
            WHERE id_jornada = ?');
        $consulta->bindParam(1, $id_jornada);
        $consulta->execute();
        return $consulta->fetchColumn();
    }

    // Actualizar puntuacion1
    public function updatePuntuacion1($id_partido, $puntuacion1)
    {
        $consulta = $this->db->prepare('UPDATE partido SET puntuacion1 = ? WHERE id_partido = ?');
        $consulta->bindParam(1, $puntuacion1);
        $consulta->bindParam(2, $id_partido);
        $consulta->execute();
    }

    // Actualizar puntuacion2
    public function updatePuntuacion2($id_partido, $puntuacion2)
    {
        $consulta = $this->db->prepare('UPDATE partido SET puntuacion2 = ? WHERE id_partido = ?');
        $consulta->bindParam(1, $puntuacion2);
        $consulta->bindParam(2, $id_partido);
        $consulta->execute();
    }

    // Obtener partidos por jornada
    public function getPartidosByJornada($id_jornada)
    {
        $consulta = $this->db->prepare('SELECT * FROM partido WHERE id_jornada = ?');
        $consulta->bindParam(1, $id_jornada);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar o actualizar
    public function save()
{
    if (empty($this->id_jornada)) {
        throw new Exception("Error: El partido no tiene asignada una jornada (id_jornada).");
    }

    if (!isset($this->id_partido)) {
        $consulta = $this->db->prepare(
            'INSERT INTO partido (puntuacion1, puntuacion2, equipo1, equipo2, id_jornada) VALUES (?, ?, ?, ?, ?)'
        );
        $consulta->bindParam(1, $this->puntuacion1);
        $consulta->bindParam(2, $this->puntuacion2);
        $consulta->bindParam(3, $this->equipo1);
        $consulta->bindParam(4, $this->equipo2);
        $consulta->bindParam(5, $this->id_jornada);
        $consulta->execute();
    } else {
        $consulta = $this->db->prepare(
            'UPDATE partido SET puntuacion1 = ?, puntuacion2 = ?, equipo1 = ?, equipo2 = ?, id_jornada = ? WHERE id_partido = ?'
        );
        $consulta->bindParam(1, $this->puntuacion1);
        $consulta->bindParam(2, $this->puntuacion2);
        $consulta->bindParam(3, $this->equipo1);
        $consulta->bindParam(4, $this->equipo2);
        $consulta->bindParam(5, $this->id_jornada);
        $consulta->bindParam(6, $this->id_partido);
        $consulta->execute();
    }
}


    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM partido WHERE id_partido = ?');
        $consulta->bindParam(1, $this->id_partido);
        $consulta->execute();
    }
}
