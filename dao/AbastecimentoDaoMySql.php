<?php
    require_once 'models/Abastecimento.php';

    class AbastecimentoDaoMySql {

        public function __construct(PDO $driver){
            $this->pdo = $driver;
        }

        public function findAll($id) {
            $array = [];
            $sql = $this->pdo->prepare("
            SELECT a.id, v.placa, a.dt_abastecimento, a.km_atual, a.valor, a.qtd_litros, a.valor_por_litro, a.latitude, a.longitude FROM abastecimento a 
            INNER JOIN veiculo v
            ON a.id_veiculo = v.id
            INNER JOIN users u
            ON a.id_usuario = u.id
            WHERE u.id = :id
            order by a.id desc;
            ;
            ");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($data as $item) {
                    $a = new Abastecimento();
                    $a->setId($item['id']);
                    $a->setId_usuario($id);
                    $a->setId_veiculo($item['placa']);
                    $a->setDt_abastecimento($item['dt_abastecimento']);
                    $a->setKm_atual($item['km_atual']);
                    $a->setValor($item['valor']);
                    $a->setQtd_litros($item['qtd_litros']);
                    $a->setValor_por_litro($item['valor_por_litro']);
                    $a->setLatitude($item['latitude']);
                    $a->setLongitude($item['latitude']);

                    $array[] = $a;

                }
            }
            return $array;
        }

        public function findById($id) {


            $sql = $this->pdo->prepare("
            select * from abastecimento where id = :id
            ");

            $sql->bindValue(':id', $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                return $data;
               
            }
            
        }

        

        public function add (Abastecimento $a) {
         
            $sql = $this->pdo->prepare('INSERT INTO abastecimento (id_veiculo, id_usuario, dt_abastecimento, km_atual, valor, qtd_litros, valor_por_litro, latitude, longitude) VALUES (:id_veiculo, :id_usuario, :dt_abastecimento, :km_atual, :valor, :qtd_litros, :valor_por_litro, :latitude, :longitude)');
            
            $sql->bindValue(':id_veiculo', $a->getId_veiculo());
            $sql->bindValue(':id_usuario', $a->getId_usuario());
            $sql->bindValue(':dt_abastecimento', $a->getDt_abastecimento());
            $sql->bindValue(':km_atual', $a->getKm_atual());
            $sql->bindValue(':valor', $a->getValor());
            $sql->bindValue(':qtd_litros', $a->getQtd_litros());
            $sql->bindValue(':valor_por_litro', $a->getValor_por_litro());
            $sql->bindValue(':latitude', $a->getLatitude());
            $sql->bindValue(':longitude', $a->getLongitude());
            $sql->execute();

            return true;
        }

        public function update (Abastecimento $a) {
            $sql = $this->pdo->prepare("
            UPDATE abastecimento
            SET id_veiculo = :id_veiculo,
            id_usuario = :id_usuario,
            dt_abastecimento = :dt_abastecimento,
            km_atual = :km_atual,
            valor = :valor,
            qtd_litros = :qtd_litros,
            valor_por_litro = :valor_por_litro,
            latitude = :latitude,
            longitude = :longitude
            WHERE id = :id;
            ");
            $sql->bindValue(':id_veiculo', $a->getId_veiculo());
            $sql->bindValue(':id_usuario', $a->getId_usuario());
            $sql->bindValue(':dt_abastecimento', $a->getDt_abastecimento());
            $sql->bindValue(':km_atual', $a->getKm_atual());
            $sql->bindValue(':valor', $a->getValor());
            $sql->bindValue(':qtd_litros', $a->getQtd_litros());
            $sql->bindValue(':valor_por_litro', $a->getValor_por_litro());
            $sql->bindValue(':latitude', $a->getLatitude());
            $sql->bindValue(':longitude', $a->getLongitude());
            $sql->bindValue(':id', $a->getId());
            $sql->execute();
        }

        public function delete($id) {
            $sql = $this->pdo->prepare("DELETE FROM abastecimento WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            
            return true;
        }

    }