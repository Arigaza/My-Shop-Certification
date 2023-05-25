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
 class Controller{
    const ROUTESFILE = __DIR__ . '/../routes.php';
    const VIEWPATH = __DIR__ . '/../Views';
    const PARTIALSPATH = self::VIEWPATH . '/Partials';
    const LAYOUT_EXT = '.layout.php';
    const TMPL_EXT = '.tmpl.php';
    const PARTIAL_EXT = '.part.php';
    const ASSETSFOLDER = '/assets';
    const PAGETITLE = 'My-Shop';
    const Itemperpage = 6;

    public function render($layout, $view = null, $data = null): string
    {
        // Récupère le layout
        $layout_ar = explode('.', $layout);
        ob_start();
        require(sprintf("%s/%s/%s%s", self::VIEWPATH, $layout_ar[0], $layout_ar[1], self::LAYOUT_EXT));
        $layout_content = ob_get_contents();
        ob_end_clean();
        $layout = str_replace('{{ pageTitle }}', self::PAGETITLE, $layout_content);
        // Récupère le template
        $view_content = '';
        if (!is_null($view)) {
            $view_ar = explode('.', $view);
            ob_start();
            require(self::VIEWPATH . '/' . $view_ar[0] . '/' . $view_ar[1] . self::TMPL_EXT);
            $view_content = ob_get_contents();
            ob_end_clean();
        }
        return str_replace('{{ pageContent }}', $view_content, $layout);
    }

    /*** Renvoie le chemin d'un partiel
     * @param $partial
     * @return string *
     ***/
    public static function partial($partial): string
    {
        return self::PARTIALSPATH . $partial;
    }

    /*** Renders a partial
     * @param $partial
     * @return string *
     ***/
    public function renderPartial($partial, $data = null): string
    {
        ob_start();
        require(self::PARTIALSPATH . '/' . $partial . self::PARTIAL_EXT);
        $partial_content = ob_get_contents();
        ob_end_clean();
        return $partial_content;
    }


 }