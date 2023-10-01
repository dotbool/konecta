<?php

    class Conn {

        private $pdo;
        private $user = "root";
        private $password = "";
        private $dsn = 'mysql:host=localhost;dbname=konecta';


        /**
         * Función para enlazar con la bbdd
         */
        public function conectar() {

            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            try {
                $this -> pdo = new PDO($this->dsn, $this->user, $this-> password, $opciones);
                $this-> pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo("conectado");
            }
            catch(PDOException $ex){
                exit("fallo al conectar --> ".$ex->getMessage());
            }
            return $this-> pdo;
        }
    }

?>