<?php
    require_once 'config.php';
    require_once 'models/Auth.php';

    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');

    if($name && $email && $password) {

        if(strlen($password) < 4) {
            $_SESSION['flash'] = 'Digite uma senha com no minimo 4 caracteres';
            header("Location:".$base."/singup.php");
            exit;
        }
    
        $auth = new Auth($pdo, $base);

        if($auth->emailExists($email) === false) {

            $auth->registerUser($name, $email, $password);
            header("Location:".$base);
            exit;

        } else {
            $_SESSION['flash'] = 'E-mail já cadastrado';
            header("Location:".$base."/singup.php");
             exit;
        }

    }

    $_SESSION['flash'] = 'Campos não enviados';
    header("Location:".$base."/singup.php");
    exit;

