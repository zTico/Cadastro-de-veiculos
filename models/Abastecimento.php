<?php

    class Abastecimento {

        private $id;
        private $id_veiculo;
        private $id_usuario;
        private $dt_abastecimento;
        private $km_atual;
        private $valor;
        private $qtd_litros;
        private $valor_por_litro;
        private $latitude;
        private $longitude;


        public function setId($id) {
            $this->id = $id;
        }
        public function getId() {
            return $this->id;
        }

        public function setId_veiculo($id_veiculo) {
            $this->id_veiculo = $id_veiculo;
        }
        public function getId_veiculo() {
            return $this->id_veiculo;
        }

        public function setId_usuario($id_usuario) {
            $this->id_usuario = $id_usuario;
        }
        public function getId_usuario() {
            return $this->id_usuario;
        }

        public function setDt_abastecimento($dt_abastecimento) {
            $this->dt_abastecimento = $dt_abastecimento;
        }
        public function getDt_abastecimento() {
            return $this->dt_abastecimento;
        }

        public function setKm_atual($km_atual) {
            $this->km_atual = $km_atual;
        }
        public function getKm_atual() {
            return $this->km_atual;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }
        public function getValor() {
            return $this->valor;
        }

        public function setQtd_litros($qtd_litros) {
            $this->qtd_litros = $qtd_litros;
        }
        public function getQtd_litros() {
            return $this->qtd_litros;
        }

        public function setValor_por_litro($valor_por_litro) {
            $this->valor_por_litro = $valor_por_litro;
        }
        public function getValor_por_litro() {
            return $this->valor_por_litro;
        }

        public function setLatitude($latitude) {
            $this->latitude = $latitude;
        }
        public function getLatitude() {
            return $this->latitude;
        }

        public function setLongitude($longitude) {
            $this->longitude = $longitude;
        }
        public function getLongitude() {
            return $this->longitude;
        }

    }