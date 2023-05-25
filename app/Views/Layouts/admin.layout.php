<?php
/***
 *  MyShopUI Layout principal du frontend
 *
 * MyShopUI Application
 *
 * @package    MyShopUI
 * @author     Kevin Fabre
 * @email      ariga@hotmail.fr
 * @copyright  Ariga 2023
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU General Public License
 * @version    1.0.0
 ***/

use MYSHOP\Controllers\MyShopController;

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?= MyShopController::getCSRFToken(); ?>">
    <link rel="icon" type="image/png" href="<?= MyShopController::assets('/imgs/mylogo.png'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= MyShopController::assets('/css/app.min.css'); ?>">
    <meta http-equiv="refresh" content="3599">
    <title>Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:wght@100;300;500&family=Roboto+Condensed&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    require_once(__DIR__ . '/../../views/Partials/adminheader.part.php');
    ?>
    <div class="container-fluid afterheader pb-4">
    {{ pageContent }}
    </div>
    <script src="<?= MyShopController::assets('/js/jquery.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/crypto-js.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/aesjson.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/docready.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/app.min.js'); ?>"></script>
    <script src="<?= MyShopController::assets('/js/users.min.js'); ?>"></script>

</body>

</html>