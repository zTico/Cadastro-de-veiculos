<?php 
    require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base?>/assets/css/login.css" />
</head>
<body>
    <header>
        <div class="container">
            <a href="<?=$base?>" style="text-decoration:none; font-size: 25px; color: white">Locktec Tecnologia em Segurança Integrada</a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="<?=$base?>/singup_action.php">
            <?php if(!empty($_SESSION['flash'])):?>
                <?=$_SESSION['flash']?>
            <?php $_SESSION['flash'] = ''; endif ?>

            <input placeholder="Digite seu nome completo" class="input" type="text" name="name" id="name" autofocus required/>

            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" required onkeypress="return ignoreSpaces(event)"/>

            <input placeholder="Digite sua senha" class="input" type="password" name="password" required onkeypress="return ignoreSpaces(event)"/>

            <input class="button" type="submit" value="Fazer cadastro" id="button"/>

            <a href="<?=$base?>/login.php">Já tem conta? Faça o login</a>
        </form>
    </section>

    <script>
        function ignoreSpaces(event) {
        let character = event ? event.which : window.event.keyCode;
        if (character == 32) return false;}
    </script>
    
</body>
</html>