<?php

    require_once 'models/Veiculo.php';

    class VeiculoDaoMySql {
        private $pdo;

        public function __construct(PDO $driver){
            $this->pdo = $driver;
        }

        public function add(Veiculo $v) {

            $sql = $this->pdo->prepare("INSERT INTO veiculo (id_usuario, placa) VALUES (:id_user, :placa)");
            $sql->bindValue(':id_user', $v->getIdUsuario());
            $sql->bindValue(':placa', $v->getPlaca());
            $sql->execute();

            return true;
        }

        public function update(Veiculo $v) {

        }

        public function delete($id) {

        }

        public function findByPlaca($id_usuario, $placa) {
            $sql = $this->pdo->prepare("SELECT * FROM veiculo WHERE placa = :placa && id_usuario = :id_usuario");
            $sql->bindValue(':placa', $placa);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            if($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function findAll($id_usuario) {
            $array = [];
            $sql = $this->pdo->prepare("SELECT * FROM veiculo WHERE id_usuario = :id_usuario");
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();
            if($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array[] = $data;
            }
            return $array;
        }

     
    }