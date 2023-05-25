<?php
/***
 * MyShopUI Inclusion de fichiers CSS additionnels
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

use MYSHOP\Controllers\MyShopController as ControllersMyShopController;
use MYSHOP\MyShopController;

if (ControllersMyShopController::isRoute('dashboard', true)) {
    echo '<link rel="stylesheet" href="'. ControllersMyShopController::assets('/css/dashboard.min.css').'">';
}
