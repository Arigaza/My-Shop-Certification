<?php

namespace MYSHOP\Utils\Php;

use NumberFormatter;

final class Outils {

    /* Nettoie les données postées avant stockage */
    static public function cleanUpValues($allValues) {
        foreach ($allValues as $key => $value) {
            if (is_array($value)) {
                $allValues[$key] = self::cleanUpValues($value);
            } else {
                $allValues[$key] = addslashes(htmlspecialchars(trim(strip_tags($value))));
            }
        }
        return $allValues;
    }

    /* Fonction qui s'assure qu'un appel de page PHP est bien effectué en AJAX */
    static public function ajaxCheck(): bool
    {
        $check=false;
        $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'];

        if(!empty($requestedWith) && strtolower($requestedWith) == 'xmlhttprequest') {
            $check = true;
        }
        return $check;
    }

    /* Fonction qui rend conforme (sans espace et en minuscule) une chaine */
    static public function sanitizeName($name): array|string|null
    {
        return strtolower(preg_replace('/\s+/', '', $name));
    }

    /* Fonction qui renvoie les segments de l'url courante */
    static public function getUriSegments(): array
    {
        return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    /* Fonction qui convertit un Timestamp en date française */
    static public function formalizeDate($timestamp): string
    {
        return date('d/m/Y H:i', $timestamp);
    }

    /* Fonction qui formatte un nombre en monnaie Euro */
    static public function formalizeEuro($montant): string
    {
        //$fmt = numfmt_create( 'fr_FR', NumberFormatter::CURRENCY );
        //return numfmt_format_currency($fmt, $montant, "EUR");
        return $montant . '.00 &euro;';
    }

    /* Fonction qui s'assure qu'un appel de page PHP est bien effectué depuis le nom de domaine référencé */
    static public function domainCheck(): bool
    {
        global $domain;
        $check=false;
        $referer = substr($_SERVER['HTTP_REFERER'],0,strlen($domain));
        if( $referer == $domain ) {
            $check = true;
        }
        return $check;
    }
}