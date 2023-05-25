<?php
namespace MYSHOP\Controllers;

use MYSHOP\Utils\Database\PdoDb;

class HomePageController extends Controller 
{
    public function __construct()
    {
    }

public function show(){
    $db = PdoDb::getInstance();
    $tab = explode("/", $_SERVER['REQUEST_URI']);

    $Instagram = $db->requete('SELECT * FROM instagram');
    $HomeImage = $db->requete('SELECT * FROM home_image ORDER BY RAND() LIMIT 1' );
    $data["Instagram"]=$Instagram;
    $data["HomeImage"]=$HomeImage;
    $data['Title'] = $tab[1];
    return $this->render('layouts.default', 'templates.homepage', $data);   
}
public function adminshow(){
    $db = PdoDb::getInstance();

    $Instagram = $db->requete('SELECT * FROM instagram');
    $HomeImage = $db->requete('SELECT * FROM home_image ORDER BY RAND() LIMIT 1' );
    $data["Instagram"]=$Instagram;
    $data["HomeImage"]=$HomeImage;
    return $this->render('layouts.admin', 'templates.homepage', $data);   

}
}