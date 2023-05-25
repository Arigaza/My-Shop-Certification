<?php

/***
 * MyShopUI interface de démarrage
 * Dispatch vers le controller ad hoc
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

use MYSHOP\Controllers\AdminController;
use MYSHOP\Controllers\MyShopController;
use MYSHOP\Controllers\Utilisateurs;

use MYSHOP\Controllers\CeramicsController;
use MYSHOP\Controllers\PaintsController;
use MYSHOP\Controllers\PhotographsController;
use MYSHOP\Controllers\CollectionController;
use MYSHOP\Controllers\Controller;
use MYSHOP\Controllers\TabController;

use function PHPSTORM_META\type;

// Instance la classe MyShopUI
$myShopUI = MyShopController::getInstance();

// Récupère l'url demandée
$requestUri = $_SERVER['REQUEST_URI'];

// Vérifie que la route existe et renvoi de son nom
$routeName = $myShopUI->getRouteName($requestUri);

//***************************************************
// Traitement de l'API Ajax *************************
//***************************************************
// Vérifie si la requête est une requête Ajax XmlHttpRequest
// Vérifiction du domaine enregistré
$requestIsAjax = $myShopUI->ajaxCheck() && $myShopUI->domainCheck();


if ($requestIsAjax) {
    // Récupération du flux de données JSON envoyé par le client
    $ajaxRequest = json_decode(file_get_contents('php://input'));
    // Vérification de la requête ajax avec son CSRF Token
    if ($myShopUI->validateAjaxRequest()) {
// print_r($_FILES);
// $testing = parse_str(file_get_contents('php://input'), $ajaxRequest2);
// print_r($ajaxRequest2 );

        // Le CSRF Token est valide
        // On ne spécifie aucun cache pour la réponse
        header("Cache-Control: no-store, no-transform, max-age=0, private");
        // Si la requête ajax reçue contient des paramètres
        if (isset($ajaxRequest) && !empty($ajaxRequest)) {

            //exit();
            // Routage de la demande
            switch ($requestUri) {

                    /*** Demande de connexion ***/
                case '/connect':
                    if (isset($ajaxRequest->type) && $ajaxRequest->type === 'cnx') {
                        if (isset($ajaxRequest->action) && $ajaxRequest->action === 'connect') {
                            if (isset($ajaxRequest->email) && isset($ajaxRequest->password)) {
                                if (isset($_SESSION['mvcRoutes'][$routeName]['action']) && $_SESSION['mvcRoutes'][$routeName]['route'] === $requestUri) {
                                    $data = json_decode(file_get_contents('php://input'));
                                    $connect = new Utilisateurs;
                                    $connect->login();
                                    // $MyShopUI = $_SESSION['mvcRoutes'][$routeName]['class']::getInstance();
                                    // echo json_encode([
                                    //     'status' => 200,
                                    //     'action' => $ajaxRequest->action,
                                    //     'connected' => $MyShopUI->{$_SESSION['mvcRoutes'][$routeName]['action']}([base64_decode($ajaxRequest->username), base64_decode($ajaxRequest->hash)])
                                    // ]);
                                    exit();
                                }
                            }
                        }
                    }
                    break;

                    /*** Demande de déconnexion ***/
                case '/disconnect':
                    if (isset($ajaxRequest->type) && $ajaxRequest->type === 'cnx') {
                        if (isset($ajaxRequest->action) && $ajaxRequest->action === 'disconnect') {
                            if (isset($_SESSION['mvcRoutes'][$routeName]['action']) && $_SESSION['mvcRoutes'][$routeName]['route'] === $requestUri) {
                                $MyShopUI = $_SESSION['mvcRoutes'][$routeName]['class']::getInstance();
                                echo json_encode([
                                    'status' => 200,
                                    'action' => $ajaxRequest->action,
                                    'disconnected' => $MyShopUI->{$_SESSION['mvcRoutes'][$routeName]['action']}()
                                ]);
                                exit();
                            }
                        }
                    }
                    break;

                    /*** Demande d'un template partiel ***/
                case '/partial':
                    if (isset($ajaxRequest->type) && $ajaxRequest->type === 'srv') {
                        if (isset($ajaxRequest->partial)) {
                            $myShopUI = MyShopController::getInstance();
                            echo json_encode([
                                'status' => 200,
                                'partial' => $myShopUI->renderPartial($ajaxRequest->partial)
                            ]);
                        }
                    }
                    break;
                    case '/admin/post':
                        if (isset($ajaxRequest->action) && $ajaxRequest->action === 'delete') {
                            if (isset($_SESSION['admin'])) {
                                $myShopUI = AdminController::getInstance();
                                // print_r();
                                $myShopUI->deleteData($ajaxRequest->tab, $ajaxRequest->id);

                            }
                        }     
            }
        } else {

            $tab = explode("/", $_SERVER['REQUEST_URI']);
            switch ($requestUri) {
                case str_starts_with($requestUri, '/ceramics'):
                    $content = new TabController;
                    echo json_encode([
                        'status' => 200,
                        'action' => 'scroll',
                        'html' => $content->infiniteScroll(Controller::Itemperpage, $tab[1]),
                        'page' => $_GET['page']
                    ]);
                    exit();
                    break;

                case str_starts_with($requestUri, '/photographs'):
                    $content = new TabController;
                    echo json_encode([
                        'status' => 200,
                        'action' => 'scroll',
                        'html' => $content->infiniteScroll(Controller::Itemperpage, $tab[1]),
                        'page' => $_GET['page']
                    ]);
                    exit();
                    break;

                case str_starts_with($requestUri, '/paints'):
                    $content = new TabController;
                    echo json_encode([
                        'status' => 200,
                        'action' => 'scroll',
                        'html' => $content->infiniteScroll(Controller::Itemperpage, $tab[1]),
                        'page' => $_GET['page']
                    ]);
                    exit();
                    break;

                case str_starts_with($requestUri, '/collections'):
                    $content = new CollectionController;
                    echo json_encode([
                        'status' => 200,
                        'action' => 'scroll',
                        'html' => $content->infiniteScroll(Controller::Itemperpage, $tab[2], $_GET['collection']),
                        'page' => $_GET['page']
                    ]);
                    exit();
                    break;

                    case str_contains($requestUri,'admin/home-image'):
                        $content = new AdminController;
                        echo json_encode([
                            'status' => 200,
                            'action' => 'update',
                            'html' => $content->showedithomeimage(),
                        ]);
                        break;
            }
        }


        // Si le CSRF Token n'est pas ou plus valide
    } else {

        // Routage de la demande
        switch ($requestUri) {
            case '/disconnect':
                echo json_encode([
                    'status' => 200,
                    'action' => 'disconnect',
                    'disconnected' => true
                ]);
                break;
            case '/partial':
                header("HTTP/1.1 401 Unauthorized");
                echo json_encode(['status' => 401]);
                break;
            default:
                header("HTTP/1.1 401 Unauthorized");
                break;
        }
        exit();
    }

    //***************************************************
    // Traitement des requêtes HTTP standard ************
    //***************************************************
} else {
    // Si la route n'existe pas
    if ($routeName === null) {
        header("HTTP/1.1 404 Not Found");
        header('Location:' . MyShopController::getRoute('404'));
        exit();
        // Si la route existe
    } 
    else {
        if ($_SESSION['mvcRoutes'][$routeName]['privacy'] === 'private') {
            if (!$myShopUI->isConnected()) {
                header('Location:' . MyShopController::getRoute('login'));
                exit();
            }
        } else if ($_SESSION['mvcRoutes'][$routeName]['privacy'] === 'admin') {
            if (!$myShopUI->isAdmin()) {
                header('Location:' . MyShopController::getRoute('login'));
                exit();
            }
        }
        $myShopUI = $_SESSION['mvcRoutes'][$routeName]['class']::getInstance();
        $myShopUI->{$_SESSION['mvcRoutes'][$routeName]['action']}();
    }
}
