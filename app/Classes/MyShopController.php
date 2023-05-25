<?php

/***
 * MyShopUI classe principale de l'interface
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

namespace MYSHOP\Controllers;

use MYSHOP\Utils\Database\PdoDb;

/*** MyShopUI controller ***/
final class MyShopController  extends Controller
{


    protected static self|null $instance = null;




    protected function __construct()
    {
    }


    protected function __clone()
    {
    }


    /*** Instantie l'objet MyShopController
     * @return MyShopController object *
     ***/
    public static function getInstance(): MyShopController
    {
        if (MyShopController::$instance === null) {
            MyShopController::$instance = new MyShopController;
        }
        return MyShopController::$instance;
    }

    /*** Récupère la configuration de l'application
     * @param null $key
     ***/
    public function getConf($key = null)
    {
        $confFile = __DIR__ . '/../../conf/app.json';
        $config = json_decode(file_get_contents($confFile));
        return $config->$key ?? $config;
    }

    /*** Renvoie le chemin des assets
     * @param $asset
     * @return string *
     ***/
    public static function assets($asset): string
    {
        return self::ASSETSFOLDER . $asset;
    }


    /*** Mise en cache des routes de l'Application dans une session PHP
     * @return void
     ***/
    public function cacheRoutes(): void
    {
        $mvcConf = $this->getConf();
        ini_set('session.name', $mvcConf->user_session_name);
        ini_set('session.use_cookies', true);
        ini_set('session.use_only_cookies', false);
        ini_set('session.use_strict_mode', true);
        ini_set('session.cookie_path', $mvcConf->originating_segment);
        // cookies peuvent être uniquement modifié par php block la modification via javascript
        ini_set('session.cookie_httponly', true);
        // encode avec les 3 dernière init set
        ini_set('session.cookie_secure', true);
        ini_set('session.cookie_samesite', 'Strict');
        // durée de vie de la session
        ini_set('session.gc_maxlifetime', 3600);
        //  durée de vie du cookie
        ini_set('session.cookie_lifetime', 3600);
        ini_set('session.use_trans_sid', false);
        ini_set('session.trans_sid_hosts', $mvcConf->domain);
        ini_set('session.referer_check', $mvcConf->originating_url);
        ini_set('session.cache_limiter', 'nocache');
        ini_set('session.sid_length', 128);
        ini_set('session.sid_bits_per_character', 6);
        ini_set('session.hash_function', $mvcConf->hashAlgo);
        // si il n'y a pas de Session, crée une session
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        /* enregistre toutes les route dans $_SESSION['mvcRoutes'] 
         si elle n'existe pas encore **/
        if (empty($_SESSION['mvcRoutes'])) {
            $_SESSION['mvcRoutes'] = include_once self::ROUTESFILE;
        }
    }

    /*** Renvoie vrai si une route existe
     * @param string $routeName
     * @param bool|null $startBy
     * @return bool $isRoute *
     ***/
    public static function isRoute(string $routeName, bool|null $startBy = null): bool
    {
        $isRoute = false;
        if (isset($_SESSION['mvcRoutes']) && !empty($_SESSION['mvcRoutes'])) {
            if ($startBy) {
                $isRoute = str_starts_with($_SERVER['REQUEST_URI'], $_SESSION['mvcRoutes'][$routeName]['route']);
            } else {
                $isRoute = $_SESSION['mvcRoutes'][$routeName]['route'] === $_SERVER['REQUEST_URI'];
            }
        }
        return $isRoute;
    }


    /*** Renvoie le nom d'une route à partir de ses segments
     * @param string $requestedRoute
     * @return string|null $routeKey *
     ***/

    public function getRouteName(string $requestedRoute): string|null
    {
        $requestedRoute2 = null;
        $requestedRoute3 = null;
        $routeName = null;
        if (isset($_SESSION['mvcRoutes']) && !empty($_SESSION['mvcRoutes'])) {
            foreach ($_SESSION['mvcRoutes'] as $routeKey => $routeInfos) {
                if (isset($routeInfos['allowed_params']) && !empty($routeInfos['allowed_params'])) {
                    $requestedRouteSegments = explode('/', trim($requestedRoute, ('/')));
                    if (in_array(end($requestedRouteSegments), $routeInfos['allowed_params'], true)) {
                        $requestedRoute = str_replace('/' . end($requestedRouteSegments), '', $requestedRoute);
                    }
                }
                if (isset($routeInfos['allowed_params_regex']) && !empty($routeInfos['allowed_params_regex'])) {
                    if ($routeInfos['allowed_params_regex'] === 'int+') {
                        $requestedRouteSegments = explode('/', trim($requestedRoute, ('/')));
                    }
                }

                if ($requestedRoute === $routeInfos['route']) {
                    $routeName = $routeKey;
                    return $routeName;
                }
            }


            if (isset($requestedRouteSegments) && !isset($routeName)) {
                foreach ($_SESSION['mvcRoutes'] as $routeKey => $routeInfos) {
                    $lastParamSlug = end($requestedRouteSegments);
                    $requestedRoute2 = str_replace('/' . $lastParamSlug, '', $requestedRoute);
                    $requestedRouteSegments2 = explode('/', trim($requestedRoute2, ('/')));

                    if ($requestedRoute2 === $routeInfos['route']) {
                        $routeName = $routeKey;
                        return $routeName;
                    }
                }
            }

            if (isset($requestedRouteSegments) && !isset($routeName)) {
                foreach ($_SESSION['mvcRoutes'] as $routeKey => $routeInfos) {
                    $lastParam = (int)end($requestedRouteSegments);
                    $lastParamSlug = end($requestedRouteSegments);
                    $requestedRoute2 = str_replace('/' . $lastParamSlug, '', $requestedRoute);
                    $lastParam2 = end($requestedRouteSegments2);
                    $requestedRoute3 = str_replace('/' . $lastParam2, '', $requestedRoute2);

                    if ($requestedRoute3 === $routeInfos['route']) {
                        $routeName = $routeKey;
                        return $routeName;
                    }
                }
            }
        }
    }


    /*** Renvoie les segments d'une route à partir de son nom
     * @param string $routeName
     * @return string $route *
     ***/
    public static function getRoute(string $routeName): string
    {
        $route = (new self)->getConf('originating_segment');
        if (isset($_SESSION['mvcRoutes'][$routeName]) && !empty($_SESSION['mvcRoutes'][$routeName])) {
            $route = $_SESSION['mvcRoutes'][$routeName]['route'];
        }
        return $route;
    }


    /*** Atténuation des risques XSS
     * @param $data
     * @return string *
     ***/
    private static function xssafe($data): string
    {
        return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }


    /*** Génère un jeton CSRF
     * @return string *
     ***/
    private function generateCSRFToken(): string
    {
        $mvcConf = $this->getConf();
        $sessionTokenLabel = $mvcConf->session_token_label;
        if (empty($_SESSION[$sessionTokenLabel])) {
            $_SESSION[$sessionTokenLabel] = bin2hex(openssl_random_pseudo_bytes(256));
        }
        return hash_hmac($mvcConf->hashAlgo, $mvcConf->hmacData, $_SESSION[$sessionTokenLabel]);
    }

    /*** Renvoie le jeton CSRF
     * @return string *
     ***/
    public static function getCSRFToken(): string
    {
        return self::xssafe((new self)->generateCSRFToken());
    }

    /*** Rendu d'un layout + template
     * @param $layout
     * @param null $view
     * @param null $data
     * @return string *
     ***/

    /*** Vérifie si un utilisateur est connecté
     * @return bool
     ***/
    public static function isConnected(): bool
    {
        return isset($_SESSION['admin']) &&($_SESSION['admin']=== 1 || $_SESSION['admin'] === 0 );
    }

    /*** Vérifie si un utilisateur est connecté et est administrateur
     * @return bool
     ***/
    public static function isAdmin(): bool
    {
        $bool= false;
        if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
            if ($_SESSION['admin'] === 1) {
     $bool= true;
        } 
    }
    return $bool;

}
    /*** Affiche la bannière de login
     * @return void
     ***/
    public function login(): void
    {
        $view = new Utilisateurs;
        echo $view->loginview();
    }


    /*** Affiche la page d'accueil
     * @return void
     ***/
    public function home(): void
    {
        $view = new HomePageController;
        echo $view->show();
    }

    /*** Affichage des tabs ceramiste/peintre/photographe
     * @return void
     ***/

    public function showtabs(): void
    {
        $tab = explode("/", $_SERVER['REQUEST_URI']);
        $view = new TabController;
        if (!(isset($_GET['page'])) && (empty($_GET['page']))) {
            echo $view->show(self::Itemperpage, $tab[1]);
        }
    }

    /*** Affichage de contact
     * @return void
     ***/

    public function showcontact(): void
    {
        $view = new ContactController;
        echo $view->show();
    }

    /*** Affichage des collections ceramiste/peintre/photographe
     * @return void
     ***/

    public function showcollection(): void
    {
        $tab = explode("/", $_SERVER['REQUEST_URI']);
        $view = new CollectionController;
        if (!(isset($_GET['page'])) && (empty($_GET['page']))) {
            echo $view->show(self::Itemperpage, $tab[2], $_GET['collection']);
        }
    }
    /***   Affichage des sous-collections ceramiste/peintre/photographe
     * @return void
     ***/

    public function showsubcollection(): void
    {
        $tab = explode("/", $_SERVER['REQUEST_URI']);

        $view = new SousCollectionController;
        if (!(isset($_GET['page'])) && (empty($_GET['page']))) {
            echo $view->show(self::Itemperpage, $tab[2], $_GET['collection'], $_GET['subcollection']);
        }
    }

    /*** Affiche la page admin home
     * @return void
     ***/

    public function adminshowhome(): void
    {
        $view = new HomePageController;
        echo $view->adminshow();
    }
    /*** Affiche la page admin ceramique/photographie/peinture
     * @return void
     ***/

    public function adminshowtab(): void
    {
        $tab = explode("/", $_SERVER['REQUEST_URI']);

        $view = new AdminController;

        echo $view->showtab($tab[2]);
    }


    /*** Affiche la page admin collection
     * @return void
     ***/

    public function adminshowcollections(): void
    {
        $view = new AdminController;

        echo $view->showcollections();
    }

    /*** Affiche la page admin home image
     * @return void
     ***/

    public function adminshowhomeImage(): void
    {
        $view = new AdminController;

        echo $view->showhomeimage();
    }

    /*** Affiche la page admin paramètres
     * @return void
     ***/

    public function adminshowsetting(): void
    {
        $view = new AdminController;

        echo $view->showsetting();
    }


    /*** Affiche la page d'erreur 404
     * @return void
     ***/
    public function error404(): void
    {
        echo $this->render('Layouts.404');
    }

    /***
     * Vérifie les requêtes Ajax
     * @return bool *
     ***/
    public function ajaxCheck(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /***
     * Vérification du Domaine enregistré
     * @return bool *
     ***/
    public function domainCheck(): bool
    {
        $domain = $this->getConf('domain');
        return $_SERVER['HTTP_HOST'] === $domain && $_SERVER['SERVER_NAME'] === $domain;
    }

    /***
     * Valide le jeton CSRF pour les appels Ajax
     * @return bool *
     ***/
    public function validateAjaxRequest(): bool
    {
        $mvcConf = $this->getConf();
        $sessionTokenLabel = $mvcConf->session_token_label;
        if (!isset($_SESSION[$sessionTokenLabel])) {
            return false;
        }
        $expected = hash_hmac($mvcConf->hashAlgo, $mvcConf->hmacData, $_SESSION[$sessionTokenLabel]);
        $requestToken = $_SERVER['HTTP_X_CSRF_TOKEN'];
        return hash_equals($requestToken, $expected);
    }

   /**
     * Sécurité :
     * Insert un champ caché avec le jeton CSRF
     * @return string *
     */
    public static function insertHiddenToken(): string
    {
        $csrfToken = self::getCSRFToken();
        return '<input type="hidden" name="' . self::xssafe((new self)->getConf('form_token_label')) . '" value="' . $csrfToken . '">';
    }
    
    /***
     * Valide le jeton CSRF pour les données postées
     * @return bool *
     ***/
    public function validateFormRequest(): bool
    {
        $mvcConf = $this->getConf();
        $sessionTokenLabel = $mvcConf->session_token_label;
        if (!isset($_SESSION[$sessionTokenLabel])) {
            return false;
        }
        $expected = hash_hmac($mvcConf->hashAlgo, $mvcConf->hmacData, $_SESSION[$sessionTokenLabel]);
        $requestToken = $_POST[$mvcConf->form_token_label];
        return hash_equals($requestToken, $expected);
    }











    //     public function getRouteNameFailed(string $requestedRoute): string|null
    //     {
    //         $requestedRoute2 = null;
    //         $requestedRoute3 = null;
    //         $routeName = null;
    //         if (isset($_SESSION['mvcRoutes']) && !empty($_SESSION['mvcRoutes'])) {
    //             foreach ($_SESSION['mvcRoutes'] as $routeKey => $routeInfos) {
    //                 if (isset($routeInfos['allowed_params']) && !empty($routeInfos['allowed_params'])) {
    //                     $requestedRouteSegments = explode('/', trim($requestedRoute, ('/')));
    //                     if (in_array(end($requestedRouteSegments), $routeInfos['allowed_params'], true)) {
    //                         $requestedRoute = str_replace('/' . end($requestedRouteSegments), '', $requestedRoute);
    //                     }
    //                 }
    //                 if (isset($routeInfos['allowed_params_regex']) && !empty($routeInfos['allowed_params_regex'])) {
    //                     $requestedRouteSegments = explode('/', trim($requestedRoute, ('/')));
    //                     if ($routeInfos['allowed_params_regex'] === 'int+') {
    //                         // $requestedRoute = $requestedRoute;
    //                     }
    //                 } 

    //                 if ($requestedRoute === $routeInfos['route']) {
    //                     $routeName = $routeKey;
    //                     return $routeName;
    //                 }

    //                 if (isset($requestedRouteSegments) && !isset($routeName))
    //                 {

    //                         $lastParamSlug = end($requestedRouteSegments);
    //                         $requestedRoute2 = str_replace('/' . $lastParamSlug, '', $requestedRoute);
    //                         $requestedRouteSegments2 = explode('/', trim($requestedRoute2, ('/')));

    //                         if ($requestedRoute2 === $routeInfos['route']) {
    //                             $routeName = $routeKey;
    //                             return $routeName;

    //                         }


    //                 }  
    //                 if (isset($requestedRouteSegments) && !isset($routeName))
    // {

    //         $lastParamSlug = end($requestedRouteSegments);
    //         $requestedRoute2 = str_replace('/' . $lastParamSlug, '', $requestedRoute);
    //         $lastParam2 = end($requestedRouteSegments2);
    //         $requestedRoute3 = str_replace('/' . $lastParam2, '', $requestedRoute2);

    //         if ($requestedRoute3 === $routeInfos['route']) {
    //             $routeName = $routeKey;
    //             return $routeName;

    //         }

    //     }            
    //             }





    //         }
    //     }
}
