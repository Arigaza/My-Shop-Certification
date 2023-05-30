<?php
/***
 * MyShopUI fichier autoloader
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

require_once __DIR__ . '/Classes/Controller.php';
require_once __DIR__ . '/Classes/MyShopController.php';
require_once __DIR__ . '/Utils/Database/Database.php';


require_once __DIR__ . '/Classes/Contact.php';
require_once __DIR__ . '/Classes/Homepage.php';
require_once __DIR__ . '/Classes/Utilisateurs.php';
require_once __DIR__ . '/Classes/Tabs.php';
require_once __DIR__ . '/Classes/Collections.php';
require_once __DIR__ . '/Classes/SousCollections.php';
require_once __DIR__ . '/Classes/Admin.php';
require_once __DIR__ . '/Models/Tabs.php';
require_once __DIR__ . '/Models/Utilisateurs.php';
require_once __DIR__ . '/Models/Instagram.php';


use MYSHOP\Controllers\MyShopController;

$mvcUI = MyShopController::getInstance();
$mvcUI->cacheRoutes();