<?php

namespace MYSHOP\Controllers;

use MYSHOP\Controllers\Controller;
use MYSHOP\Models\UtilisateursModel;
use MYSHOP\Utils\Database\PdoDb;
use MYSHOP\Controllers\MyShopController;

class Utilisateurs extends Controller
{

    // public function login($logins)
    // {
    //     $connected = false;
    //     $db = PdoDb::getInstance();
    //     $password = md5(base64_decode($logins['password']));
    //     $sql = 'SELECT `nom`, `prenom`, `uid_utilisateur` FROM `utilisateurs` WHERE `email` = "' . strtolower(base64_decode($logins['email'])) . '"' . ' AND `password` = ' . '"' . $password . '"';
    //     $loginDB = $db->requete($sql);
    //     if ($loginDB !== null) {

    //         if (isset($loginDB[0]['nom'])) {
    //             $_SESSION['username'] = $loginDB[0]['nom'] . ' ' . $loginDB[0]['prenom'];
    //             $_SESSION['uid'] = $loginDB[0]['uid_utilisateur'];
    //             if ($loginDB[0]['is_admin'] === 1) {
    //                 $_SESSION['admin'] = $loginDB[0]['is_admin'];
    //             }
    //             $connected = true;
    //             echo json_encode([
    //                 'status' => 200,
    //                 'action' => 'cnx',
    //                 'connected' => true
    //             ]);
    //         }
    //     }
    //     if (!$connected) {
    //         echo json_encode([
    //             'status' => 401,
    //             'action' => 'cnx',
    //             'connected' => false
    //         ]);
    //     }
    // }



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
                if ($loginDB[0]['is_admin'] === 1) {
                    $_SESSION['admin'] = $loginDB[0]['is_admin'];
                }
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
}
