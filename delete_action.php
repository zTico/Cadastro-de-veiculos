<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/AbastecimentoDaoMySql.php';


$id_abastecimento = filter_input(INPUT_GET, 'id');

if($id_abastecimento) {
    $abastecimento = new AbastecimentoDaoMySql($pdo);

    if($abastecimento->delete($id_abastecimento)) {
        $_SESSION['flash'] = 'Deletado com sucesso';
        header('Location:'.$base);
        exit;
    }
    
}

