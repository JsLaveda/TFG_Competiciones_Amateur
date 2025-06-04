<?php
// model/UsuarioModel.php

class UsuarioModel
{
    // Conexión a la base de datos
    protected $db;

    // Atributos del modelo
    private $id_usuario;
    private $nombre_usuario;
    private $nombre;
    private $email;
    private $contraseña;
    private $id_equipo;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // Getters y setters
    public function getId_usuario()
    {
        return $this->id_usuario;
    }
    public function setId_usuario($id)
    {
        $this->id_usuario = $id;
    }

    public function getNombre_usuario()
    {
        return $this->nombre_usuario;
    }
    public function setNombre_usuario($nombre_usuario)
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getContraseña()
    {
        return $this->contraseña;
    }
    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;
    }

    public function getId_equipo()
    {
        return $this->id_equipo;
    }
    public function setId_equipo($id_equipo)
    {
        $this->id_equipo = $id_equipo;
    }

    // Obtener todos los usuarios
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM usuario');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "UsuarioModel");
    }

    // Obtener un usuario por ID
    public function getById($id)
    {
        $consulta = $this->db->prepare('SELECT * FROM usuario WHERE id_usuario = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
        return $consulta->fetch();
    }

    // Insertar o actualizar
    public function save()
    {
        try {
            if (!isset($this->id_usuario)) {
                $consulta = $this->db->prepare(
                    'INSERT INTO usuario (nombre_usuario, nombre, email, contraseña, id_equipo) VALUES (?, ?, ?, ?, ?)'
                );
                $consulta->bindParam(1, $this->nombre_usuario);
                $consulta->bindParam(2, $this->nombre);
                $consulta->bindParam(3, $this->email);
                $consulta->bindParam(4, $this->contraseña);
                $consulta->bindParam(5, $this->id_equipo);

                return $consulta->execute();
            } else {
                $consulta = $this->db->prepare(
                    'UPDATE usuario SET nombre_usuario = ?, nombre = ?, email = ?, contraseña = ?, id_equipo = ? WHERE id_usuario = ?'
                );
                $consulta->bindParam(1, $this->nombre_usuario);
                $consulta->bindParam(2, $this->nombre);
                $consulta->bindParam(3, $this->email);
                $consulta->bindParam(4, $this->contraseña);
                $consulta->bindParam(5, $this->id_equipo);
                $consulta->bindParam(6, $this->id_usuario);

                return $consulta->execute();
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    //Añadir funcion que verifique si el nombre de suario y el correo están registrados

    // Eliminar
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM usuario WHERE id_usuario = ?');
        $consulta->bindParam(1, $this->id_usuario);
        $consulta->execute();
    }


    public function verificarLogin($nombre_usuario, $contraseña)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        $stmt->execute([$nombre_usuario]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario;
        } else {
            return false;
        }
    }
}


    /*public function save($nombre_usuario, $nombre, $email, $contraseña_hash) {
        $sql = "INSERT INTO usuario (nombre_usuario, nombre, email, contraseña) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre_usuario, $nombre, $email, $contraseña_hash]);
    }
}
?>*/
