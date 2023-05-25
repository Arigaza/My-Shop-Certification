<?php

namespace MYSHOP\Models;

/*
 * Modèle Utilisateurs
 */
class UtilisateursModel
{
    public string $nom;
    public string $prenom;
    public string $email;
    public string $password;

    public function __construct($userInfos) {
        $this->nom = $userInfos['nom'];
        $this->prenom = $userInfos['prenom'];
        $this->email = $userInfos['email'];
        $this->password = md5($userInfos['password']);
        return $this;
    }
}