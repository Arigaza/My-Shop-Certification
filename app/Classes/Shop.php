<?php

namespace MYSHOP\Controllers;

use MYSHOP\Utils\Database\PdoDb;

Class ShopController extends Controller {
    public function show($number = 6, $request = null)
    {
        $page = $_GET['page'] ?? 1;

        $rank = $page * $number - $number;

        $db = PdoDb::getInstance();

        $Instagram = $db->requete('SELECT * FROM instagram WHERE active = 1' );

        $data["Instagram"] = $Instagram;
            return $this->render('layouts.default', 'templates.shop', $data);
        
    }
    function infiniteScroll($number = 6)
    {
        $data = [];
        $page = $_GET['page'] ?? 1;
        $rank = $page * $number - $number;
        
        $db = PdoDb::getInstance();

        return $this->renderPartial('partials.shop', $data);
    }
}