<?php 

Class Usuario{

    private $id;
    private $nombre;
    private $apellidos;
    private $fecha_nacimiento;
    private $activo;
    private $email;
    private $pass;
    private $dni;

    public function __CONSTRUCT($usuario){

        $this->id = $usuario->id;
        $this->nombre = $usuario->nombre;
        $this->apellidos = $usuario->apellidos;
        $this->fecha_nacimiento = $usuario->fecha_nacimiento;
        $this->activo = $usuario->activo;
        $this->email = $usuario->email;
        $this->pass = $usuario->pass;
        $this->dni = $usuario->dni;
    }

    public function getId(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function getFecha_nacimiento(){
        return $this->fecha_nacimiento;
    }
    public function isActivo(){
        return $this->activo;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPass(){
        return $this->pass;
    }
    public function getDni(){
        return $this->dni;
    }
}
?>