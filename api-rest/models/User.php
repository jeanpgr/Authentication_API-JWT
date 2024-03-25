<?php

class User {
    
    private $id_user;
    private $nomb_user;
    private $apell_user;
    private $nick_user;
    private $email_user;
    private $passw_user;

    public function __construct($id_user, $nomb_user, $apell_user, 
                                    $nick_user, $email_user, $passw_user) {
        
            $this->id_user = $id_user;
            $this->nomb_user = $nomb_user;
            $this->apell_user = $apell_user;
            $this->nick_user = $nick_user;
            $this->email_user = $email_user;
            $this->passw_user = $passw_user;

    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function getNombUser() {
        return $this->nomb_user;
    }

    public function getApellUser() {
        return $this->apell_user;
    }

    public function getNickUser() {
        return $this->nick_user;
    }

    public function getEmailUser() {
        return $this->email_user;
    }

    public function getPasswUser() {
        return $this->passw_user;
    }

}


?>