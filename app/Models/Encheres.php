<?php

namespace MYSHOP\Models;

/*
 * Modèle Enchères
 */
class EncheresModel
{
    public int $uid_utilisateur;
    public int $uid_annonce;
    public int $date;
    public int $montant;


    public function __construct($EnchereInfos) {
        $this->uid_utilisateur = (int)$EnchereInfos['uid_utilisateur'];
        $this->uid_annonce = (int)$EnchereInfos['uid_annonce'];
        $this->date = (int)$EnchereInfos['date'];
        $this->montant = (float)$EnchereInfos['montant'];
        return $this;
    }
}
