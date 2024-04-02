<?php

// Clase para retornar las consultas a la db
class Queries {

    public function queryLogin() {
        $query = "SELECT id_user, nomb_user, apell_user, email_user, passw_user 
                    FROM users WHERE email_user = :email_user LIMIT 0,1";

        return $query;
    }

    public function queryRegisterUser() {
        $query = "INSERT INTO users
                    SET nomb_user = :nomb_user,
                        apell_user = :apell_user,
                        nick_user = :nick_user,
                        email_user = :email_user,
                        passw_user = :passw_user";
        
        return $query;
    }

    public function queryGetUserById() {
        $query = "SELECT id_user, nomb_user, apell_user, email_user
                    FROM users WHERE id_user = :id";
        
        return $query;
    }

    public function queryGetUsers() {
        $query = "SELECT id_user, nomb_user, apell_user, nick_user, email_user FROM users";
        
        return $query;
    }
}

?>