<?php
/***
 * MyShopUI Définition des Routes de l'application
 *
 * MyShopUI Sample App
 *
 * @package    MyShopUI
 * @author     Kevin Fabre
 * @email      ariga@hotmail.fr
 * @copyright  Ariga 2023
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU General Public License
 * @version    1.0.0
 ***/

use MYSHOP\Controllers\AdminController;
use MYSHOP\Controllers\MyShopController;
use MYSHOP\Controllers\Utilisateurs;

return [
    'login' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/login',
        'class' => MyShopController::class,
        'action' => 'login',
        'info' => 'Affiche la bannière de login.'
    ],
    '404' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/404',
        'class' => MyShopController::class,
        'action' => 'error404',
        'info' => 'Affiche la page d\'erreur 404.'
    ],
    'home' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/',
        'class' => MyShopController::class,
        'action' => 'home',
        'info' => 'Affiche la page d\'accueil.'
    ],
    'dashboard' => [
        'access' => 'web',
        'privacy' => 'private',
        'method' => 'get',
        'route' => '/dashboard',
        'class' => MyShopController::class,
        'action' => '',
        'info' => 'Page d\'accueil du Backend.'
    ],
    'connect' => [
        'access' => 'api',
        'privacy' => 'public',
        'method' => 'post',
        'route' => '/connect',
        'class' => MyShopController::class,
        'action' => 'connect',
        'info' => 'Connecte un utilisateur.'
    ],
    'disconnect' => [
        'access' => 'api',
        'privacy' => 'private',
        'method' => 'post',
        'route' => '/disconnect',
        'class' => MyShopController::class,
        'action' => 'disconnect',
        'info' => 'Déconnecte un utilisateur.'
    ],
    'ceramics' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/ceramics',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showtabs',
        'info' => 'Affiche les céramics.'
    ],
    'photographs' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/photographs',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showtabs',
        'info' => 'Affiche les photos.'
    ],
    'paints' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/paints',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showtabs',
        'info' => 'Affiche les peintures.'
    ],
    'contact' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/contact',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showcontact',
        'info' => 'Affiche les céramics.'
    ],
    'collections/ceramics' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/collections/ceramics',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showcollection',
        'info' => 'Affiche la collection sélectionné de céramiste.'
    ],
    'collections/photographs' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/collections/photographs',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showcollection',
        'info' => 'Affiche la collection sélectionné de photographe.'
    ],
    'collections/paints' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/collections/paints',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showcollection',
        'info' => 'Affiche la collection sélectionné de  peintre.'
    ],
    'sous-collection/ceramics' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/sous-collection/ceramics',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showsubcollection',
        'info' => 'Affiche la sous-collection sélectionné de  céramiste.'
    ],
    'sous-collection/photographs' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/sous-collection/photographs',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showsubcollection',
        'info' => 'Affiche la sous-collection sélectionné de photographe.'
    ],
    'sous-collection/paints' => [
        'access' => 'web',
        'privacy' => 'public',
        'method' => 'get',
        'route' => '/sous-collection/paints',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'showsubcollection',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowhome',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/ceramics' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin/ceramics',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowtab',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/photographs' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin/photographs',
        // 'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowtab',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/paints' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin/paints',
        // 'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowtab',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/collections' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin/collections',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowcollections',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/home-image' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin/home-image',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowhomeImage',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/setting' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'get',
        'route' => '/admin/setting',
        'allowed_params_regex' =>  'int+',
        'class' => MyShopController::class,
        'action' => 'adminshowsetting',
        'info' => 'Affiche la sous-collection sélectionné de peintre.'
    ],
    'admin/post' => [
        'access' => 'web',
        'privacy' => 'admin',
        'method' => 'post',
        'route' => '/admin/post',
        'allowed_params_regex' =>  'int+',
        'class' => AdminController::class,
        'action' => 'insertdata',
        'info' => 'Insere une nouvelle ceramics.'
    ]
    // autre nom des routes... 
];