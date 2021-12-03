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
        <form method="POST" action="<?=$base?>/login_action.php">
            <?php if(!empty($_SESSION['flash'])):?>
                <?=$_SESSION['flash']?>
            <?php $_SESSION['flash'] = ''; endif ?>
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" autofocus required />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" required/>

            <input class="button" type="submit" value="Acessar o sistema" />

            <a href="<?=$base?>/singup.php">Ainda não tem conta? Cadastre-se</a>
        </form>
    </section>
</body>
</html>