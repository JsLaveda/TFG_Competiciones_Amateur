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
    private $estado;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_competicion()
    {
        return $this->id_competicion;
    }
    public function setId_competicion($id)
    {
        $this->id_competicion = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getFecha_inicio()
    {
        return $this->fecha_inicio;
    }
    public function setFecha_inicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getFecha_fin()
    {
        return $this->fecha_fin;
    }
    public function setFecha_fin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    public function getPrivacidad()
    {
        return $this->privacidad;
    }
    public function setPrivacidad($privacidad)
    {
        $this->privacidad = $privacidad;
    }

    public function getTipo_competicion()
    {
        return $this->tipo_competicion;
    }
    public function setTipo_competicion($tipo_competicion)
    {
        $this->tipo_competicion = $tipo_competicion;
    }

    public function getCreador()
    {
        return $this->creador;
    }
    public function setCreador($creador)
    {
        $this->creador = $creador;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

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

    // Obtener competiciones por nombre
    public function getByName($nombre)
    {
        $consulta = $this->db->prepare('SELECT * FROM competicion WHERE nombre LIKE ?');
        $nombre = '%' . $nombre . '%';
        $consulta->bindParam(1, $nombre);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "CompeticionModel");
    }

    // Insertar o actualizar
    public function save()
    {
        if (!isset($this->id_competicion)) {
            $consulta = $this->db->prepare(
                'INSERT INTO competicion (nombre, fecha_inicio, fecha_fin, privacidad, tipo_competicion, creador, estado)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->fecha_inicio);
            $consulta->bindParam(3, $this->fecha_fin);
            $consulta->bindParam(4, $this->privacidad);
            $consulta->bindParam(5, $this->tipo_competicion);
            $consulta->bindParam(6, $this->creador);
            $consulta->bindParam(7, $this->estado);
            $consulta->execute();
            $this->id_competicion = $this->db->lastInsertId(); // Obtener el ID del último insert
        } else {
            $consulta = $this->db->prepare(
                'UPDATE competicion SET nombre = ?, fecha_inicio = ?, fecha_fin = ?, privacidad = ?, tipo_competicion = ?, creador = ?, estado = ?
                 WHERE id_competicion = ?'
            );
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->fecha_inicio);
            $consulta->bindParam(3, $this->fecha_fin);
            $consulta->bindParam(4, $this->privacidad);
            $consulta->bindParam(5, $this->tipo_competicion);
            $consulta->bindParam(6, $this->creador);
            $consulta->bindParam(7, $this->estado);
            $consulta->bindParam(8, $this->id_competicion);
            $consulta->execute();
        }
        return $this->id_competicion; // Devuelve el ID de la competición
    }

    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM competicion WHERE id_competicion = ?');
        $consulta->bindParam(1, $this->id_competicion);
        $consulta->execute();
    }

    /**
     * Devuelve la clasificación de la competición.
     * Cada equipo suma los puntos de puntuacion1/puntuacion2 de cada partido.
     */
    public function getClasificacion()
    {
        // Obtener todos los equipos de la competición
        $consulta = $this->db->prepare('SELECT id_equipo, nombre FROM equipo WHERE id_competicion = ?');
        $consulta->bindParam(1, $this->id_competicion);
        $consulta->execute();
        $equipos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Inicializar array de clasificación
        $clasificacion = [];
        foreach ($equipos as $equipo) {
            $clasificacion[$equipo['id_equipo']] = [
                'equipo' => $equipo['nombre'],
                'jugados' => 0,
                'ganados' => 0,
                'empatados' => 0,
                'perdidos' => 0,
                'puntos' => 0
            ];
        }

        // Obtener todos los partidos de la competición
        $consulta = $this->db->prepare(
            'SELECT p.equipo1, p.equipo2, p.puntuacion1, p.puntuacion2
             FROM partido p
             JOIN jornada j ON p.id_jornada = j.id_jornada
             WHERE j.id_competicion = ?'
        );
        $consulta->bindParam(1, $this->id_competicion);
        $consulta->execute();
        $partidos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Calcular clasificación
        foreach ($partidos as $partido) {
            $e1 = $partido['equipo1'];
            $e2 = $partido['equipo2'];
            $p1 = $partido['puntuacion1'];
            $p2 = $partido['puntuacion2'];

            // Solo contar partidos jugados (ambas puntuaciones no nulas)
            if ($p1 === null || $p2 === null) continue;

            $clasificacion[$e1]['jugados']++;
            $clasificacion[$e2]['jugados']++;

            $clasificacion[$e1]['puntos'] += $p1;
            $clasificacion[$e2]['puntos'] += $p2;

            if ($p1 > $p2) {
                $clasificacion[$e1]['ganados']++;
                $clasificacion[$e2]['perdidos']++;
            } elseif ($p1 < $p2) {
                $clasificacion[$e2]['ganados']++;
                $clasificacion[$e1]['perdidos']++;
            } else {
                $clasificacion[$e1]['empatados']++;
                $clasificacion[$e2]['empatados']++;
            }
        }

        // Ordenar por puntos
        usort($clasificacion, function ($a, $b) {
            return $b['puntos'] - $a['puntos'];
        });

        return $clasificacion;
    }


    /*
     private function generarCalendario()
{
    // Obtener equipos
    $consulta = $this->db->prepare('SELECT id_equipo FROM equipo WHERE id_competicion = ?');
    $consulta->bindParam(1, $this->id_competicion);
    $consulta->execute();
    $equipos = $consulta->fetchAll(PDO::FETCH_COLUMN);

    $numEquipos = count($equipos);

    // Si impar, hacemos que el haya un espacio pero su valor es null
    $esImpar = $numEquipos % 2 !== 0;
    if ($esImpar) {
        $equipos[] = null; // equipo fantasma
        $numEquipos++;
    }

    $jornadas = $numEquipos - 1;
    $mitad = $numEquipos / 2;

    $rondas = [];

    for ($j = 0; $j < $jornadas; $j++) {
        $ronda = [];
        for ($i = 0; $i < $mitad; $i++) {
            $e1 = $equipos[$i];
            $e2 = $equipos[$numEquipos - 1 - $i];

            if ($e1 !== null && $e2 !== null) {
                $ronda[] = [$e1, $e2];
            }
        }

        $rondas[] = $ronda;

        // Rotación de equipos
        $temp = array_splice($equipos, 1, 1)[0];
        array_splice($equipos, -1, 0, [$temp]);
    }

    // Crear jornadas y partidos
    foreach ($rondas as $i => $ronda) {
        $jornada = new JornadaModel();
        $jornada->setFecha_jornada(date('Y-m-d', strtotime("+{$i} weeks")));
        $jornada->setId_competicion($this->id_competicion);
        $jornada->save();

        foreach ($ronda as [$local, $visitante]) {
            $partido = new PartidoModel();
            $partido->setEquipo1($local);
            $partido->setEquipo2($visitante);
            $partido->setId_jornada($jornada->getId_jornada());
            $partido->save();
        }
    }
}


    */
}
