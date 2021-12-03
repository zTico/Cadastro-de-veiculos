<?php
    session_start();
    $base = 'http://localhost/teste_lockteck';

    class Conexao {
        private $host = 'localhost';
        private $dbname = 'crudlock';
        private $user = 'root';
        private $pass = '';

        public function conectar(){

            try {
                $conexao = new PDO( 
                    "mysql:host=$this->host;dbname=$this->dbname", 
                    "$this->user",
                    "$this->pass"
                );
                return $conexao;

            } catch (PDOException $e) {
                echo '<p> O erro é: '.$e.'</p>';
            }

        }

    }

$sql = new Conexao();
$pdo = $sql->conectar();