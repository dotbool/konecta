<?php

require_once 'conn.php';
require_once '../modelos/Usuario.php';

$conn = new conn;
$pdo = $conn -> conectar();

    
    function response($mensaje, $codigo){
        header(http_response_code($codigo));
        return $mensaje;
    }

    /**
     * Select para los usuarios
     */
    function indexUsuarios(){
        global $pdo;
        $sql = "SELECT * from usuarios";
        $sentencia = $pdo->prepare($sql);
        $resultado = null;

        try{
            $sentencia->execute();
            while($usuario = $sentencia -> fetch(PDO::FETCH_OBJ)):
                $usuarios[] = $usuario;
                $resultado = $usuarios;
            endwhile;
        }
        catch(PDOException $ex){
            header(http_response_code(404));
            echo($ex->getMessage());
        }
        return $resultado;
    }


    /**
     * Encuentra un usuario por mail
     */
    function findOneByEmail($email){

        global $pdo;
        $resultado = false;
        $sql ="SELECT COUNT(*) from usuarios WHERE email = '$email'";
        $sentencia = $pdo->prepare($sql);
        try {
            $sentencia->execute();
            $count = $sentencia->fetchColumn();
            $resultado = $count > 0 ? true: false;
        }
        catch(PDOException $ex){
            $resultado = false;
        }
        return $resultado;
    }

    /**
     * Encuentra un usuario por mail
     */
    function findOneById($id){

        global $pdo;
        $resultado = false;
        $sql ="SELECT COUNT(*) from usuarios WHERE id = :id";
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindParam(':id', $id);
        try {
            $sentencia->execute();
            $count = $sentencia->fetchColumn();
            $resultado = $count > 0 ? true: false;
        }
        catch(PDOException $ex){
            $resultado = false;
        }
        return $resultado;
    }


    /**
     * Inserta un nuevo usuario si no está ya registrado
     */
    function insertUsuario($usuario){

        // $usuarioNuevo = new Usuario($usuario);
    
        global $pdo;
        $resultado = response("Ese email ya está registrado!", http_response_code(406));

        if(!findOneByEmail($usuario->email)):
            $sql = "INSERT into usuarios(nombre, apellidos, fecha_nacimiento, activo, email, pass, dni)
             values (:nombre, :apellidos, :fecha_nacimiento, :activo, :email, :pass, :dni)";
            $sentencia = $pdo -> prepare($sql);
            $sentencia-> bindParam(':nombre', $usuario->nombre);
            $sentencia-> bindParam(':apellidos', $usuario->apellidos);
            $sentencia-> bindParam(':fecha_nacimiento', $usuario->fecha_nacimiento);
            $sentencia-> bindParam(':email', $usuario->email);
            $sentencia-> bindParam(':activo', $usuario->activo);
            $sentencia-> bindParam(':pass', $usuario->pass);
            $sentencia-> bindParam(':dni', $usuario->dni);

            try {
                $sentencia -> execute();
                $resultado = response($usuario->email, http_response_code(201));
            }
            catch(PDOException $ex){
                $resultado = response($ex-> getMessage(), http_response_code(500));
            }
        endif;
        return $resultado;
    }


    /**
     * 
     */
    function updateUsuario($usuario){
        
        global $pdo;
        $resultado = null;
        $sql = "UPDATE usuarios set nombre = :nombre,
                                    apellidos = :apellidos,
                                    fecha_nacimiento = :fecha_nacimiento,
                                    email = :email,
                                    activo = :activo,
                                    pass = :pass,
                                    dni = :dni
                WHERE email = '$usuario->email'";
        if(findOneByEmail($usuario->email)):
            $sentencia = $pdo -> prepare($sql);
            $sentencia-> bindParam(':nombre', $usuario->nombre);
            $sentencia-> bindParam(':apellidos', $usuario->apellidos);
            $sentencia-> bindParam(':fecha_nacimiento', $usuario->fecha_nacimiento);
            $sentencia-> bindParam(':email', $usuario->email);
            $sentencia-> bindParam(':activo', $usuario->activo);
            $sentencia-> bindParam(':pass', $usuario->pass);
            $sentencia-> bindParam(':dni', $usuario->dni);

            try{
                $sentencia -> execute();

                header(http_response_code(200));
                $resultado = "Usuario actualizado";
            }
            catch(PDOException $ex){
                header(http_response_code(500));
                $resultado = $ex->getMessage();
            }
        endif;
        return $resultado;
    }


    function deleteUsuario($id){

        $resultado = false;
        global $pdo;
        $sql = "DELETE from usuarios WHERE id = '$id'";
        if(findOneById($id)):
            $sentencia = $pdo -> prepare($sql);
            // $sentencia -> bindParam(':id', $id);
            try{
                $sentencia->execute();
                header(http_response_code(200));
                $resultado = "Usuario eliminado";
            }
            catch(PDOException $ex){
                header(http_response_code(500));
                $resultado = "upssss, la eliminación falló: ".$ex->getMessage();
            }
        else:
            header(http_response_code(500));
            $resultado = "Ese usuario no existe!";
        endif;

        return $resultado;
    }

?>