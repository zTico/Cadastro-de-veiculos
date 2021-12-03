<?php
    require_once 'config.php';
    require_once 'models/Auth.php';
    require_once 'dao/VeiculoDaoMySql.php';

    $placa = filter_input(INPUT_POST, 'placa');
    $id_user = filter_input(INPUT_POST, 'id_user');

    if($placa && $id_user) {
        $veiculo = new VeiculoDaoMySql($pdo);

        if($veiculo->findByPlaca($id_user, $placa) === true) {
            sleep(1);
            header("Location:".$base."?r=error");
            exit;
        }

        $novoVeiculo = new Veiculo();
        $novoVeiculo->setIdUsuario($id_user);
        $novoVeiculo->setPlaca($placa);
    
        if($veiculo->add($novoVeiculo)) {
            sleep(1);
            header("Location:".$base."?r=sucess");
            exit;
        }
        
    }

    header("Location:".$base);
    exit;