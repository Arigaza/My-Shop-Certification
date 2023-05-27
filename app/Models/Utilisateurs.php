<?php

namespace MYSHOP\Models;

use MYSHOP\Controllers\MyShopController;
use MYSHOP\Controllers\Utilisateurs;

/*
 * Modèle Utilisateurs
 */

class UtilisateursModel
{
    public string $is_admin;
    public string $surname;
    public string $name;
    public string $email;
    public string $password;
    public string $updated_at;
    public string $created_at;
    /**
     * Système :
     * Constructeur du modèle User
     * @param $userInfos
     * @return UserModel $UserModel L'objet User
     */
    public function __construct($userInfos)
    {

        // Récupération du jeton CSRF pour le décryptage du mot de passe
        $usersObj = Utilisateurs::getInstance();
        $myShopObj = MyShopController::getInstance();
        $csrfToken = $myShopObj->getCsrfToken();

        // On affecte les valeurs du post à l'objet UserModel
        if (isset($_SESSION['is_admin'])) {
            $this->is_admin = $userInfos['is_admin'];
        }
        $this->name = (string)$userInfos['name'];
        $this->surname  = (string)$userInfos['surname'];
        // On décrypte l'adresse email reçue
        $this->email = (string)$usersObj->aesDecrypt(base64_decode($userInfos['cryptedEmail']), $csrfToken);
        $this->updated_at = date('Y-m-d-H:i:s');
        $this->created_at = date('Y-m-d-h:i:s');

        // Si un mot de passe est foourni
        if (!empty($userInfos['cryptedPw'])) {
            // On décrypte le mot de passe reçu et on le hash avec l'algorythme argon2id
            $this->password = $usersObj->argon2idHash($usersObj->aesDecrypt(base64_decode($userInfos['cryptedPw']), $csrfToken));
        }
        return $this;
    }
}
