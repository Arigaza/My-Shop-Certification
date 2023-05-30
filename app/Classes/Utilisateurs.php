<?php

namespace MYSHOP\Controllers;

use MYSHOP\Controllers\Controller;
use MYSHOP\Models\UtilisateursModel;
use MYSHOP\Utils\Database\PdoDb;
use MYSHOP\Controllers\MyShopController;

class Utilisateurs extends Controller
{
    protected static ?Utilisateurs $instance = null;

    public static function getInstance(): Utilisateurs
    {
        if (Utilisateurs::$instance === null) {
            Utilisateurs::$instance = new Utilisateurs;
        }
        return Utilisateurs::$instance;
    }


    public function getNumberOfCPUs(): int
    {
        $ans = 1;
        if (is_file('/proc/cpuinfo')) {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpuinfo, $matches);
            $ans = count($matches[0]);
        } else if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            $process = @popen('wmic cpu get NumberOfCores', 'rb');
            if (false !== $process) {
                fgets($process);
                $ans = intval(fgets($process));
                pclose($process);
            }
        } else {
            $ps = @popen('sysctl -a', 'rb');
            if (false !== $ps) {
                $output = stream_get_contents($ps);
                preg_match('/hw.ncpu: (\d+)/', $output, $matches);
                if ($matches) {
                    $ans = intval($matches[1][0]);
                }
                pclose($ps);
            }
        }
        return $ans;
    }

 /*** Hash le mots de pass et le convertie en binaire
     * @param string $plaintext
     * @return int bin2hex *
     ***/

    public function argon2idHash($plaintext): string
    {
        $connect = new Utilisateurs;
        $controller = MyShopController::getInstance();
        $hashAlgo = $controller->getConf('hashAlgo');
        $secret= $controller->getConf('hmacData');
        return bin2hex(
            password_hash(
                hash_hmac($hashAlgo, $plaintext, $secret),
                PASSWORD_ARGON2ID,
                ['memory_cost' => 2**14, 'time_cost' => 5, 'threads' => $connect->getNumberOfCPUs()]
            )
        );
    }

    public function argon2idHashVerify($plaintext, $hash): bool
    {
        $controller = MyShopController::getInstance();
        $hashAlgo = $controller->getConf('hashAlgo');
        $secret= $controller->getConf('hmacData');
        return password_verify(
            hash_hmac(
                $hashAlgo,
                $plaintext,
                $secret),
            hex2bin($hash)
        );
    }

    public function aesDecrypt(string $jsonStr, string $passphrase): mixed
    {
        $cipherAlgo = json_decode(file_get_contents(__DIR__ . '/../../conf/app.json'))->cipherAlgo;
        $json = json_decode($jsonStr, true);
        $salt = hex2bin($json["s"]);
        $iv = hex2bin($json["iv"]);
        $ct = base64_decode($json["ct"]);
        $concatedPassphrase = $passphrase . $salt;
        $md5 = [];
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, $cipherAlgo, $key, true, $iv);
        return json_decode($data, true);
    }

    public function login()
    {

        $connect = new Utilisateurs;
        $data = json_decode(file_get_contents('php://input'));
        $csrfToken = MyShopController::getCSRFToken();
        $connected = false;
        $db = PdoDb::getInstance();     
        $email = $connect->aesDecrypt(base64_decode($data->email), $csrfToken);
        $sql ='SELECT * FROM `users` WHERE `email` = "' . strtolower($email) . '"' ;
        $loginDB = $db->requete($sql);
      
// vérifie s'il y a bien un utilisateur avec cette adresse e-mail
        if (isset($loginDB[0])) {

            // verifie si le hash des mots de passe match celui de la base de donnée
if ($connect->argon2idHashVerify($connect->aesDecrypt(base64_decode($data->password), $csrfToken), $loginDB[0]['password'] ) ) {


            if (isset($loginDB[0]['name'])) {
                $_SESSION['name'] = $loginDB[0]['name']; 
                $_SESSION['surname'] = $loginDB[0]['surname'];
                $_SESSION['uid'] = $loginDB[0]['id'];
                
                $_SESSION['admin'] = $loginDB[0]['is_admin'];
                
                $connected = true;
                echo json_encode([
                    'status' => 200,
                    'action' => 'cnx',
                    'connected' => true
                ]);
            }
        }
    }
        if (!$connected) {
            echo json_encode([
                'status' => 401,
                'action' => 'cnx',
                'connected' => false
            ]);
        }
    }

    public function register($post)
    {
        $post['password'] = base64_decode($post['password']);
        $post['email'] = strtolower(base64_decode($post['email']));
        $db = PdoDb::getInstance();
        $db->inserer('utilisateurs', new UtilisateursModel($post));
    }

    public function loginview()
    {
        $db = PdoDb::getInstance();
        $HomeImage = $db->requete('SELECT * FROM home_image ORDER BY RAND() LIMIT 1');
        $data['HomeImage'] = $HomeImage;



        echo $this->render('Layouts.login', null, $data);
    }


    

    /************************************************************
     ***************** CRUD UTILISATEURS ************************
     ************************************************************/


    /**
     * CRUD UTILISATEUR :
     * Renvoie la liste des utilisateurs
     * @return void
     */
    public function listUsers(): void
    {
        // On se connecte à la database
        $cnx = PdoDb::getInstance();

        $data = [];
        $data['color'] = '#ffffff';

        // Requête les utilisateurs en base de données
        $requeteUsers = 'SELECT * from `Users` ORDER BY `id`';
        $data['users'] = $cnx->requete($requeteUsers);
        // Envoie les données des utilisateurs au template
        echo $this->render('Layouts.admin', 'AdminTemplates.listusers', $data, 'Liste des utilisateurs');
    }


    /**
     * CRUD UTILISATEUR :
     * Affiche le formulaire de création d'un utilisateur
     * @return void
     */
    public function newUser(): void
    {
        $data['action'] = 'newuser';
        echo $this->render('Layouts.admin', 'AdminTemplates.userform', $data, 'Ajouter un utilisateur');
    }


    /**
     * CRUD UTILISATEUR :
     * Créé un nouvel utilisateur en base de données
     * @param array $post Les données issues du formulaire
     * @return bool Vrai si l'insertion en base s'est bien passée ou faux
     */
    public function createUser(array $post): bool
    {
        /**
         * On crée un objet User basé sur son modèle avec les données du post nettoyées
         */
        $userObj = new UtilisateursModel($this->cleanUpValues($post));

        // On se connecte à la database
        $cnx = PdoDb::getInstance();

        /**
         * On insère le nouvel utilisateur en base de données
         */
        return $cnx->inserer('Users', $userObj);
    }


    /**
     * CRUD UTILISATEUR :
     * Affiche le formulaire d'édition d'un utilisateur
     * @return void
     */
    public function editUser(): void
    {
        if ($_SESSION['admin'] === 0) {
            if (!($_GET['id'] == $_SESSION['uid'])) {
          
                header('Location:' . MyShopController::getRoute('admin/setting'));
                exit();
            }
        }
        $data = [];
        $data['userid'] = $_GET['id'];
        $data['action'] = 'edituser';

        /** On récupère les infos de l'utilisateur en base de données */
        $cnx = PdoDb::getInstance();
        $requeteUsers = sprintf('SELECT * from `Users` WHERE `id` =%d', $data['userid']);
        $data['userinfos'] = $cnx->requete($requeteUsers, 'fetch');

        echo $this->render('Layouts.admin', 'AdminTemplates.userform', $data, 'Modifier un utilisateur');
    }
 /**
     * Sécurité :
     * Vérifie la syntaxe d'une adresse mail
     * @param string $adresseEmail L'adresse mail à vérifier
     * @return bool Renvoie Vrai si l'adresse mail est valide sinon Faux
     */
    public function validateEmail(string $adresseEmail): bool
    {
        // Expression régulière pour valider une adresse email
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        // Vérifie si l'adresse email correspond au modèle
        if (preg_match($pattern, $adresseEmail)) {
            return true; // L'adresse email est valide
        } else {
            return false; // L'adresse email est invalide
        }
    }


    
    /**
 * Sécurité :
 * Nettoie les données postées avant stockage
 * @var array $post Le tableau posté à nettoyer
 * @return array $post Le tableau posté nettoyé
 */
protected function cleanUpValues(array $post) :array {
    foreach ($post as $key => $value) {
        if (is_array($value)) {
            $post[$key] = self::cleanUpValues($value);
        } else {
            $post[$key] = addslashes(htmlspecialchars(trim(strip_tags($value))));
        }
    }
    return $post;
}

    /**
     * CRUD UTILISATEUR :
     * Met à jour un utilisateur en base de données
     * @param array $post Les données issues du formulaire
     * @return bool Vrai si l'insertion en base s'est bien passée ou faux
     */
    public function updateUser(array $post): bool
    {
        if ($_SESSION['admin'] === 0) {
            if ($_GET['id'] !== $_SESSION['id']) {
            
            
                header('Location:' . MyShopController::getRoute('admin/setting'));
                exit();
            }
        }
        $cleanPost = $this->cleanUpValues($post);

        // On supprime le champ cryptedPw si il est vide
        if(empty($cleanPost['cryptedPw'])){
            unset($cleanPost['cryptedPw']);
        }

        /**
         * On crée un objet User basé sur son modèle avec les données du post nettoyées
         */
        $userObj = new UtilisateursModel($cleanPost);

        // On se connecte à la database
        $cnx = PdoDb::getInstance();
        /**
         * On insère le nouvel utilisateur en base de données
         */
        return $cnx->update('Users', $userObj, $cleanPost['id']);
    }


    /**
     * CRUD UTILISATEUR :
     * Affiche le formulaire de confirmation de suppression d'un utilisateur
     * @return void
     */
    public function deleteUser(): void
    {
        // On récupère l'identifiant unique de l'utilisateur
        $uid = $_GET['id'] ?? $_POST['id'];

        // On se connecte à la database
        $cnx = PdoDb::getInstance();

        // On récupère en base de données l'uid, le nom et le prénom de l'utilisateur
        $usersql = sprintf('SELECT `id`, `name`, `surname` FROM `Users` WHERE `id` =%d', $uid);
        $user = $cnx->requete($usersql, 'fetch');

        echo $this->render('Layouts.admin', 'AdminTemplates.deleteuser', $user, 'Supprimer un utilisateur');
    }


    /**
     * CRUD UTILISATEUR :
     * Supprime un utilisateur de la base de données
     * @param int $uid L'id de l'utilisateur à supprimer
     * @return bool Renvoie Vrai si la suppression s'est bien passée sinon Faux
     */
    public function destroyUser(int $uid): bool
    {
        // On se connecte à la database
        $cnx = PdoDb::getInstance();

        /**
         * On supprime l'utilisateur de la base de données
         */
        return $cnx->delete('users', $uid);
    }

}
