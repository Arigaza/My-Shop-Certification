<?php
/***
 * MyShopUI Inclusion de fichiers JS additionnels
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
use MYSHOP\MyShopController;

if (MyShopController::isRoute('dashboard', true)) {
    echo '<script src="'. MyShopController::assets('/js/dashboard.min.js').'"></script>';
}