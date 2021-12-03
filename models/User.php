<?php

    class User {
        public $id;
        public $name;
        public $email;
        public $email_verified_at;
        public $password;
        public $remember_token;
        public $created_at;
        public $updated_at;

    }

    interface UserDAO {
        public function findByToken($token);
        public function findByEmail ($email);
        public function update(User $u);
    }

