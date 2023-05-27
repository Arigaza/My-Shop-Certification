<?php

namespace MYSHOP\Controllers;

use MYSHOP\Utils\Database\PdoDb;


class TabController extends Controller 
{
    protected static self|null $instance = null;

    public static function getInstance(): TabController
    {
        if (TabController::$instance === null) {
            TabController::$instance = new TabController;
        }
        return TabController::$instance;
    }

    public function show($number = 6, $tab)
    {
        $page = $_GET['page'] ?? 1;

        $rank = $page * $number - $number;

        $db = PdoDb::getInstance();
        $Instagram = $db->requete('SELECT * FROM instagram WHERE active = 1');
        $Collections = $db->requete('SELECT * FROM collections');
        $Collections = $db->requete('SELECT DISTINCT collections.name, collections.description FROM collections JOIN '.$tab.' ON '.$tab.'.collections_id = collections.id ORDER BY collections.name');
        $Content = $db->requete('SELECT 
            '.$tab.'.name AS name, 
            '.$tab.'.image_path,
            '.$tab.'.sub_collection_name,
            '.$tab.'.translate_y,
            '.$tab.'.translate_x,
            '.$tab.'.id,
            collections.id AS collections_id,
            collections.name AS collections_name FROM '.$tab.' LEFT JOIN collections ON '.$tab.'.collections_id = collections.id ORDER BY '.$tab.'.created_at DESC LIMIT ' . $rank . ',' . $number);
        $data["Collections"] = $Collections;
        $data["Instagram"] = $Instagram;
        $data["Content"] = $Content;
        $data['Tab'] = $tab;
        $data['Title'] =$tab;
            return $this->render('Layouts.default', 'Templates.tab', $data);
        
    }

    function infiniteScroll($number = 6, $tab) {
        $page = $_GET['page'] ?? 1;
        $rank = $page * $number - $number;
        $db = PdoDb::getInstance();

        $Content = $db->requete('SELECT 
        '.$tab.'.name AS name, 
        '.$tab.'.image_path,
        '.$tab.'.sub_collection_name,
        '.$tab.'.translate_y,
        '.$tab.'.translate_x,
        '.$tab.'.id,
        collections.id AS collections_id,
        collections.name AS collections_name FROM '.$tab.' LEFT JOIN collections ON '.$tab.'.collections_id = collections.id ORDER BY '.$tab.'.created_at DESC LIMIT ' . $rank . ',' . $number);
        $data['Content'] = $Content;
        $data['Tab'] = $tab;
if ($Content == null) {
    return "";
} else {
    return $this->renderPartial('tab_data', $data);
}
    }
}