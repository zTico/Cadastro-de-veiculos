<?php

    class Veiculo {

        private $id;
        private $id_usuario;
        private $placa;

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setIdUsuario($id) {
            $this->id_usuario = $id;
        }

        public function getIdUsuario() {
            return $this->id_usuario;
        }

        public function setPlaca($placa) {
            $this->placa = strtoupper(trim($placa));
        }

        public function getPlaca() {
            return $this->placa;
        }

    }