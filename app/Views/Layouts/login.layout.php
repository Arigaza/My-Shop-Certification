<?php

/***
 *  MyShopUI Layout Login
 *
 * MyShopUI Application
 *
 * @package    MyShopUI
 * @author     Kevin Fabre
 * @copyright  Ariga 2023
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU General Public License
 * @version    1.0.0
 */

use MYSHOP\Controllers\MyShopController;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= MyShopController::getCSRFToken(); ?>">
    <meta http-equiv="refresh" content="3000">
    <title>Se connecter</title>
    <link rel="icon" type="image/png" href="<?= MyShopController::assets('/imgs/mylogo.png'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/bootstrap-icons.min.css'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/login.min.css'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/app.min.css'); ?>">
</head>

<body oncontextmenu="return false;" data-bs-theme="light">
    <div id="mainLogin" class="d-flex align-items-center z-3 position-relative">
        <div id="loginContainer" class="animate__animated animate__fadeIn">
            <div class="text-center mb-4" id="form-signin">
                <img id="loginLogo" src="<?= MyShopController::assets('/imgs/mylogo.png'); ?>" alt="MyShopUI">
            </div>
            <?php if (!MyShopController::isConnected()) { ?>
                <form autocomplete="off">
                    <div class="form-group my-2">
                        <label class="d-block" for="email">Adresse e-mail:</label>
                        <input type="text" class="form-control" id="email" placeholder="________________________" required>
                    </div>
                    <div class="form-group my-2">
                        <label class="d-block" for="password">Mot de passe:</label>
                        <input type="password" class="form-control" id="password" placeholder="________________________" required>
                    </div>
                    <div class="form-group my-6">
                        <button type="button" id="loginBtn" class="btn btn-primary w-100 text-white">Login</button>
                    </div>
                </form>
            <?php } else { ?>
                <div class="text-center mt-4 mb-4">
                    <p>Vous êtes connecté : <span class="text-primary"><?= $_SESSION['admin']; ?></span></p>
                    <button type="button" data-id="disconnect" class="btn btn-secondary text-white">
                        Logout
                    </button>
                    <a href="<?= MyShopController::getRoute('home'); ?>" class="btn btn-primary text-white">
                        Enter
                    </a>
                </div>
            <?php } ?>
            <div class="text-center my-2">
                <span class="small normal text-black">Ariga&copy;<?= date('Y'); ?></span>
            </div>
        </div>
    </div>

    <script src="<?= MyShopController::assets('/js/docready.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/crypto-js.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/aesjson.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/jquery.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/app.min.js'); ?>"></script>
    <img id="frontpageimage" class="frontpageimage" src="<?= (isset($data['HomeImage'][0])) ? $data['HomeImage'][0]['image_path'] : "https://source.unsplash.com/1600x900/?nature,people,architecture"  ?>" alt="Image d\'acceuil">
</body>


</html>