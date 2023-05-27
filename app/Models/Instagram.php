<?php

namespace MYSHOP\Models;

/*
 * Modèle Instagram
 */

class InstagramModele  
{
public int $id;
public string $name;
public string $link;
public bool $active;
public string $created_at;
public string $updated_at;

 /** 
     *@param $post
     */

function __construct($post)
{
  
    extract($post);
    /***
     * @var string $name
     * @var string $link
     * @var bool $active;
     * @var string $created_at
     * @var string $updated_at
     */

    /*  verifie si les variable sont présente pour les ajouter 
    ou que cela soit null dans la base de donnée ou ne pas les modifier si c'est une modification 
    **/
   
    if (isset($link)) {
        $this->link =(string)$link;
    }
    if (isset($name)) {
        $this->name =(string)$name ;
    }
    if (isset($active)) {
        $this->active =(bool)$active ;
    }
   
    $this->created_at = date('Y-m-d-h:i:s');
    $this->updated_at = date('Y-m-d-H:i:s');
    return $this;
}


}