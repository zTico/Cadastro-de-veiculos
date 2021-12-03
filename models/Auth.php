<?php
    require_once 'dao/UserDaoMySql.php';
    class Auth {

        private $pdo;
        private $base;
        private $dao;

        public function __construct($pdo, $base) {
            $this->pdo = $pdo;
            $this->base = $base;
            $this->dao = new UserDaoMySql($this->pdo);
        }

        public function checkToken() {
            if(!empty($_SESSION['token'])) {
                $token = $_SESSION['token'];
                $user = $this->dao->findByToken($token);

                if($user) {
                    return $user;
                }
            } 

            header("Location:".$this->base."/login.php");
            exit;
        }

        public function validateLogin($email, $password)  {
            $user =$this->dao->findByEmail($email);
         
            if($user) {
                if(password_verify($password, $user->password)) {
                    $token = md5(time().rand(0,9999));
                    $_SESSION['token'] = $token;
                    $user->remember_token = $token;
           
                    $this->dao->update($user);

                    return true;
                }
            }
            return false;
        }

        public function emailExists($email) {
            if($this->dao->findByEmail($email)) {
                return true;
            } else {
                return false;
            }
        }

        public function registerUser($name, $email, $password) {
            date_default_timezone_set('America/Sao_Paulo');
            $newUser = new User();

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $token = md5(time().rand(0,9999));

            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->password = $hash;
            $newUser->remember_token = $token;
            $newUser->created_at = date('Y-m-d H:i:s');
            $this->dao->insert($newUser);

            $_SESSION['token'] = $token;

        }
    

    }