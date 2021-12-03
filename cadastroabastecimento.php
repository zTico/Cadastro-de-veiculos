<?php 
    require_once 'config.php';
    require_once 'models/Auth.php';
    require_once 'dao/VeiculoDaoMySql.php';

    $auth = new Auth($pdo, $base);
    $userInfo = $auth->checkToken();
    $veiculo = new VeiculoDaoMySql($pdo);
    $lista_veiculo = $veiculo->findAll($userInfo->id);
    $nome = explode(" ", $userInfo->name);
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
            <a href="<?=$base?>/logout.php" style="position:absolute; right:50px; color:white" type="button" class="btn btn-primary" >
               Sair
            </a>
            <a href="<?=$base?>" style="position:absolute; left:50px; color: white;" class="btn btn-primary">
               Voltar
            </a>
        </div>
    </header>
    <form action=cadastroabastecimento_action method="POST">

    <?php if(!empty($_SESSION['flash'])):?>
        <?=$_SESSION['flash']?>
    <?php $_SESSION['flash'] = ''; endif ?>

    <div class="form-group">
    <select class="form-control" name="veiculo">
      <option selected>Selecione seu veículo</option>
      <?php foreach($lista_veiculo as $placa){
                foreach ($placa as $value) { ?>
                    <option value="<?=$value['id']?>"><?=$value['placa']?></option>
        <?php }
      } ?>
    </select>
  </div>

  <div class="form-group">
    <input type="text" class="form-control" placeholder="Data do abastecimento" name="dt_abastecimento" id="dt_abastecimento"  required>
  </div>

  <div class="form-group">
    <input type="text" class="form-control" placeholder="km Atual" name="km_atual" id="kmatual" onkeypress="return somenteNumeros(event)" required>
  </div>

  <div class="form-group">
    <input type="text" class="form-control"placeholder="Valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
  </div>

  <div class="form-group">
    <input type="text" class="form-control"  placeholder="Valor por litro" name="vl_litro" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
  </div>

  <div class="form-group">
    <input type="text" class="form-control"  placeholder="Quantidade de litros" name="qtd_litros" onkeypress="return somenteNumeros(event)" required>
  </div>

  <div class="form-group">
    <input type="text" class="form-control"  placeholder="Latitude" name="latitude" id="lat" value="" required>
  </div>

  <div class="form-group">
    <input type="text" class="form-control" placeholder="Longitude" name="longitude" id="lon" value="" required>
  </div>
        <input type="hidden" name="iduser" value="<?=$userInfo->id?>">
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById("dt_abastecimento"),
        {mask:'00/00/0000'}
    );
</script>

<script> 
        function getLocation() {
            if(!navigator.geolocation) { 
                return null;
            }
            alert('A latitude e longitude serão preenchida automaticamente, permita a página saber sua localização!');
                navigator.geolocation.getCurrentPosition((pos) => {                    
                    document.querySelector("#lat").value = pos.coords.latitude;
                    document.querySelector("#lon").value = pos.coords.longitude;
                })
           
        }
        getLocation();
    </script>

    
<script language="javascript">
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

document.getElementById("kmatual").onkeyup = function(e) {
         var chr = String.fromCharCode(e.which);
         if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM".indexOf(chr) < 0)
           return false;
       };
</script>
<script>

function somenteNumeros(e) {
        var charCode = e.charCode ? e.charCode : e.keyCode;
        // charCode 8 = backspace   
        // charCode 9 = tab
        if (charCode != 8 && charCode != 9) {
            // charCode 48 equivale a 0   
            // charCode 57 equivale a 9
            if (charCode < 48 || charCode > 57) {
                return false;
            }
        }
    }
 </script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>