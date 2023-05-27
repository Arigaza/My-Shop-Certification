<?php

namespace MYSHOP\Controllers;

use MYSHOP\Utils\Database\PdoDb;


class SousCollectionController extends Controller {

    protected static self|null $instance = null;

    public static function getInstance(): SousCollectionController
    {
        if (SousCollectionController::$instance === null) {
            SousCollectionController::$instance = new SousCollectionController;
        }
        return SousCollectionController::$instance;
    }


public function show($number = 6,$tab,$slug, $subcollection = null){
    // replace - with space for SQL search on the collections.name
        $slug = explode("-",$slug);
        $collectionName = implode(" ",$slug);

    // replace - with space for SQL search on the tab.subcollection_name
    $slugsubcollection = explode("-",$subcollection);
 $subcollectionName = implode(" ",$slugsubcollection);



            // replace - with space for SQL search but not needed as tab don't have space
        // $tab = explode("-",$tab);
        // $tabname = implode(" ",$tab);

        $page = $_GET['page'] ?? 1;

        $rank = $page * $number - $number;

        $db = PdoDb::getInstance();
        // $sqltest =;
        $Instagram = $db->requete('SELECT * FROM instagram WHERE active = 1');

            $Collection = $db->requete('SELECT * FROM collections WHERE collections.name = "'. $collectionName .'"');
        $Sub_collection_name = $db->requete('SELECT DISTINCT '.$tab.'.sub_collection_name, collections.name FROM '.$tab.' JOIN collections ON collections.id = '.$tab.'.collections_id WHERE collections.name = "'. $collectionName .'" ORDER BY '.$tab.'.sub_collection_name');

      $Content = $db->requete('SELECT 
        '.$tab.'.name AS name, 
        '.$tab.'.description AS description,
        '.$tab.'.image_path, 
        '.$tab.'.sub_collection_name,
        '.$tab.'.translate_y,
        '.$tab.'.translate_x,
        '.$tab.'.id,
        collections.id AS collections_id,
        collections.name AS collections_name FROM '.$tab.' JOIN collections ON '.$tab.'.collections_id = collections.id WHERE collections.name = "'. $collectionName. '" AND '.$tab.'.sub_collection_name ="'. $subcollectionName . '" ORDER BY '.$tab.'.created_at DESC LIMIT ' . $rank . ',' . $number);
                 
        $data["Instagram"]=$Instagram;
        $data["Content"]=$Content;
        $data["Collection"]=$Collection;
        $data["Sub_collection_name"] = $Sub_collection_name;
        $data['Tab'] = $tab;
       $data['Title'] = $subcollection ;
        return $this->render('Layouts.default', 'Templates.collections', $data);
    }

public function infinitescroll($number = 6,$tab,$slug, $subcollection = null) {

     // replace - with space for SQL search on the collections.name
 $slug = explode("-",$slug);
 $collectionName = implode(" ",$slug);

// replace - with space for SQL search on the tab.subcollection_name
$slugsubcollection = explode("-",$subcollection);
$subcollectionName = implode(" ",$slugsubcollection);



     // replace - with space for SQL search but not needed as tab don't have space
 // $tab = explode("-",$tab);
 // $tabname = implode(" ",$tab);

 $page = $_GET['page'] ?? 1;

 $rank = $page * $number - $number;

 $db = PdoDb::getInstance();
 // $sqltest =;
 $Instagram = $db->requete('SELECT * FROM instagram');

     $Collection = $db->requete('SELECT * FROM collections WHERE collections.name = "'. $collectionName .'"');
 $Sub_collection_name = $db->requete('SELECT DISTINCT '.$tab.'.sub_collection_name, collections.name FROM '.$tab.' JOIN collections ON collections.id = '.$tab.'.collections_id WHERE collections.name = "'. $collectionName .'" ORDER BY '.$tab.'.sub_collection_name');

$Content = $db->requete('SELECT 
 '.$tab.'.name AS name, 
 '.$tab.'.description AS description,
 '.$tab.'.image_path, 
 '.$tab.'.sub_collection_name,
 '.$tab.'.translate_y,
 '.$tab.'.translate_x,
 '.$tab.'.id,
 collections.id AS collections_id,
 collections.name AS collections_name FROM '.$tab.' JOIN collections ON '.$tab.'.collections_id = collections.id WHERE collections.name = "'. $collectionName. '" ORDER BY '.$tab.'.created_at DESC LIMIT ' . $rank . ',' . $number);
       
      

     
 $data["Instagram"]=$Instagram;
 $data["Content"]=$Content;
 $data["Collection"]=$Collection;
 $data["Sub_collection_name"] = $Sub_collection_name;
 $data['Tab'] = $tab;

 if ($Content == null) {
    return "";
} else {
    return $this->renderPartial('collections_data', $data);
}
}


}