<?php

    require_once 'config.php';
    require_once 'models/Auth.php';
    require_once 'dao/AbastecimentoDaoMySql.php';

    $id_abastecimento = filter_input(INPUT_POST, 'id_abastecimento');
    $placa = filter_input(INPUT_POST, 'veiculo');
    $dt_abastecimento = filter_input(INPUT_POST, 'dt_abastecimento');
    $km_atual = filter_input(INPUT_POST, 'km_atual');
    $valor = filter_input(INPUT_POST, 'valor');
    $qtd_litros = filter_input(INPUT_POST, 'qtd_litros');
    $vl_litro = filter_input(INPUT_POST, 'vl_litro');
    $latitude = filter_input(INPUT_POST, 'latitude');
    $longitude = filter_input(INPUT_POST, 'longitude');
    $iduser = filter_input(INPUT_POST, 'iduser');
      

    if($id_abastecimento && $placa && $dt_abastecimento && $km_atual && $valor && $vl_litro && $latitude && $longitude && $iduser &&  $qtd_litros) {


    $valor = str_replace('', ',', $valor);
    $vl_litro = str_replace('', ',', $vl_litro);
    $dt_abastecimento = explode('/', $dt_abastecimento);
    
        if(count($dt_abastecimento) != 3){
            $_SESSION['flash'] = 'Data invalida';
            header('Location:'.$base.'/cadastroabastecimento.php');
            exit;
        }
        
        $dt_abastecimento = $dt_abastecimento[2].'-'.$dt_abastecimento[1].'-'.$dt_abastecimento[0];

        if(strtotime($dt_abastecimento) === false) {
            $_SESSION['flash'] = 'Data invalida';
            header('Location:'.$base.'/cadastroabastecimento.php');
            exit;
        }

        
        $abastecimento = new AbastecimentoDaoMySql($pdo);
        $abasobj = new Abastecimento();
        $abasobj->setId($id_abastecimento);
        $abasobj->setId_veiculo($placa);
        $abasobj->setId_usuario($iduser);
        $abasobj->setDt_abastecimento($dt_abastecimento);
        $abasobj->setKm_atual($km_atual);
        $abasobj->setValor($valor);
        $abasobj->setQtd_litros($qtd_litros);
        $abasobj->setValor_por_litro($vl_litro);
        $abasobj->setLatitude($latitude);
        $abasobj->setLongitude($longitude);
    
        $abastecimento->update($abasobj);
        sleep(1);
        $_SESSION['flash'] = 'Atualizado com sucesso';
        header('Location:'.$base);
        exit;
        

    }

