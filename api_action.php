<?php


require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/VeiculoDaoMySql.php';
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$veiculo = new VeiculoDaoMySql($pdo);
$dados = $veiculo->findAll($userInfo->id);

echo json_encode($dados);


