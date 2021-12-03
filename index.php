<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/AbastecimentoDaoMySql.php';


$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$nome = explode(" ", $userInfo->name);
$abastecimento = new AbastecimentoDaoMySql($pdo);
$dados = $abastecimento->findAll($userInfo->id);
$nome[1] = $nome[1] ?? '';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base?>/assets/css/login.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div style="padding-top: 40px;"></div>
    <header>
        <div class="container">
            <a href="<?=$base?>" style="text-decoration:none; font-size: 25px; color: white">Bem vindo(a) ao Sistema Locktec, <?=$nome[0].' '.$nome[1]?> 😊</a>
            <button onclick="validar()" style="position:absolute; left:50px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVeiculo">
               Cadastrar placa
            </button>
            <a href="<?=$base?>/cadastroabastecimento.php" style="position:absolute; left:200px; color: white;" class="btn btn-primary">
               Cadastro Abastecimento
            </a>
            <a href="<?=$base?>/logout.php" style="position:absolute; right:50px; color:white" type="button" class="btn btn-primary" >
               Sair
            </a>
        </div>
    </header>

<div style="margin: auto; width: 90%; padding-top: 30px;">		
<div id="list" class="row">
	<div class="table-responsive col-md-12">
		<table class="table table-striped" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Placa</th>
					<th>Data do Abastecimento</th>
          <th>Valor</th>
					<th>km Atual</th>
          <th>Valor por litro</th>
					<th>Quantidade por litro</th>
					<th>Latitude</th>
          <th>Longitude</th>
					<th class="actions">Ações</th>
				</tr>
			</thead>
			<tbody>
      <?php if(!empty($_SESSION['flash'])):?>
        <?=$_SESSION['flash']?>
      <?php $_SESSION['flash'] = ''; endif ?>

      <?php if(!empty($_GET['r']) && $_GET['r'] == 'sucess'):?>
        <p id="placa_r">Placa cadastrada com sucesso</p>
      <?php  endif ?>

      <?php if(!empty($_GET['r']) && $_GET['r'] == 'error'):?>
        <p id="placa_r">Placa já cadastrada</p>
      <?php  endif ?>
      
      <?php foreach($dados as $abast): ?>
				<tr>
					<td><?=$abast->getId_veiculo()?></td>
					<td><?=date('d/m/Y',  strtotime($abast->getDt_abastecimento()))?></td>
					<td><?=$abast->getKm_atual()?></td>
          <td><?=$abast->getValor()?></td>
					<td><?=$abast->getQtd_litros()?></td>
          <td><?=$abast->getValor_por_litro()?></td>
					<td><?=$abast->getLatitude()?></td>
          <td><?=$abast->getLongitude()?></td>
					<td class="actions">
						<a class="btn btn-warning btn-xs" href="<?=$base?>/edit.php?id=<?=$abast->getId()?>">Editar</a>
						<a onclick="return confirm('Tem certeza que deseja excluir?')" class="btn btn-danger btn-xs"  href="<?=$base?>/delete_action.php?id=<?=$abast->getId()?>" >Excluir</a>
					</td>
				</tr>
      <?php endforeach ?>
				</div> <!-- /#list -->	
			</tbody>
		</table>
	</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="modalVeiculo" tabindex="-1" role="dialog" aria-labelledby="modalVeiculoTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVeiculoLongTitle">Cadastrar Veiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Cadastre a placa de seus veiculos, rápido e fácil.
        <form method="POST" action="veiculoaction.php">
            <div class="form-group">
                <input type="text" class="form-control" name="placa" placeholder="Placa" id="placa" onkeyup="validarPlaca(this)" placeholder="ABC-1234" maxlength="8" required autofocus>
                <input type="hidden" name="id_user" value="<?=$userInfo->id?>">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <br>
        <h5>Placas cadastradas:</h5>
        <ul id="listaplacas" class="list-group list-group-flush">
          
        </ul>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Final Modal -->



<script>

function validar() {
        let lista;
        fetch('<?=$base?>/api_action.php')
        .then(function(resultado){
            return resultado.json();
        })
        .then(function(json){
            for (let i in json) {
              for (let b in json[i]) {
                  
                lista = document.querySelector('#listaplacas').innerHTML;
                lista = lista + "<li class='list-group-item'>" + json[i][b].placa + "</li>"
                document.querySelector('#listaplacas').innerHTML = lista;
          
              }
            }
        })
        .catch(function(error){
            alert("Erro ao tentar validar o arquivo. Verifique a integridade das tags do arquivo");
        });    
}


  function limparP() {
    document.querySelector('#placa_r').innerHTML = '';
  }

  if(document.querySelector('#placa_r').innerHTML != '') {
    setInterval(limparP, 6000);
  }
  

function validarPlaca(entradaDoUsuario) {
        var placa = entradaDoUsuario.value; 
        
        if (placa.length === 1 || placa.length === 2) {                      
                placaMaiuscula = placa.toUpperCase();                      
                document.forms[0].placa.value = placaMaiuscula;   
                return true;
        }
 
        if (placa.length === 3){                                                        
                placa += "-";                                                                
                placaMaiuscula = placa.toUpperCase();                   
                document.forms[0].placa.value = placaMaiuscula; 
    }
}
</script>  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>