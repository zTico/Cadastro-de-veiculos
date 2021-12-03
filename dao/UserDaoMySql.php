<?php
    require_once 'models/User.php';

    class UserDaoMySql implements UserDAO {
        private $pdo;

        public function __construct(PDO $driver){
            $this->pdo = $driver;
        }

        private function generateUser ($array) {
            $u = new User();
            $u->id = $array['id'] ?? 0;
            $u->name = $array['name'] ?? '';
            $u->email = $array['email'] ?? '';
            $u->email_verified_at = $array['email_verified_at'];
            $u->password = $array['password'] ?? '';
            $u->remember_token = $array['remember_token'] ?? '';
            $u->created_at = $array['created_at'] ?? '';
            $u->updated_at = $array['updated_at'] ?? '';

            return $u;
        }

        public function findByToken($token) {
            if(!empty($token)) {
                $sql = $this->pdo->prepare("SELECT * FROM users WHERE remember_token = :token");
                $sql->bindValue(':token', $token);
                $sql->execute();

                if($sql->rowCount() > 0 ) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $user = $this->generateUser($data);

                    return $user;
                }
            }
            else {
                return false;
            }
        }

        public function findByEmail($email) {
            if(!empty($email)) {
                $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
                $sql->bindValue(':email', $email);
                $sql->execute();

                if($sql->rowCount() > 0 ) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $user = $this->generateUser($data);
                    return $user;
                } else {
                    return false;
                }
            }
            

        }

        public function update(User $u) {
            $sql = $this->pdo->prepare("UPDATE users SET email = :email, password = :password, name = :name, remember_token = :token WHERE id = :id");
            $sql->bindValue(':email', $u->email);
            $sql->bindValue(':password', $u->password);
            $sql->bindValue(':name', $u->name);
            $sql->bindValue(':token', $u->remember_token);
            $sql->bindValue(':id', $u->id);
            $sql->execute();

            return true;
        }

        public function insert(User $u) {
            $sql = $this->pdo->prepare("INSERT INTO users (
                name, email, password, remember_token, created_at
            )
            VALUES (
                :name, :email, :password, :token, :created_at
            )
            ");

            $sql->bindValue(':name', $u->name);
            $sql->bindValue(':email', $u->email);
            $sql->bindValue(':password', $u->password);
            $sql->bindValue(':token', $u->remember_token);
            $sql->bindValue(':created_at', $u->created_at);
            $sql->execute();

            return true;

        }
    }