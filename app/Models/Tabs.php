<?php

namespace MYSHOP\Models;

/*
 * Modèle Tabs(ceramics/photographs/paints)
 */

class TabsModele  
{
public int $id;
public int $collections_id;
public string $name;
public string $description;
public string $sub_collection_name;
public string $image_path;
// public string
public int $translate_x;
public int $translate_y;
public  $created_at;
public  $updated_at;

 /** 
     *@param $post
     */

function __construct($post)
{
  
    extract($post);
    /***
     * @var string $name
     * @var string $description
     * @var string $image_path
     * @var string $sub_collection_name
     * @var int $sub_collection_name
     * @var int $collections_id 
     * @var int $translate_x
     * @var int $translate_y
     * @var string $created_at
     * @var string $updated_at
     */

    /*  verifie si les variable sont présente pour les ajouter 
    ou que cela soit null dans la base de donnée **/
    if (isset($collections_id)) {
        $this->collections_id =(int)$collections_id;
    }
    if (isset($sub_collection_name)) {
        $this->sub_collection_name =(string)$sub_collection_name;
    }
    if (isset($name)) {
        $this->name =(string)$name ;
    }
    if (isset($description)) {
        $this->description =(string)$description ;
    }
    if (isset($image_path)) {
        $this->image_path =(string)$image_path ;
    }
    if (isset($collections_id)) {
        $this->translate_y =(int)$translate_y;
    }
    if (isset($collections_id)) {
        $this->translate_x =(int)$translate_x;
    }
    $this->created_at = date('Y-m-d-h:i:s');
    $this->updated_at = date('Y-m-d-H:i:s');
    return $this;
}


}

  // $this->sub_collection_name =(string)$sub_collection_name;
    // $this->name =(string)$name ;
    // $this->description =(string)$description ;
    // $this->image_path =(string)$image_path ;
    // $this->translate_x =(int) $translate_x ;
    // $this->translate_y =(int) $translate_y;