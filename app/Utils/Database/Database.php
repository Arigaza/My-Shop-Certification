<?php

namespace MYSHOP\Utils\Database;

use PDO, PDOException;
use MYSHOP\Utils\Debug\dBug;

class PdoDb
{

    private static $connect = null;
    private PDO $conx;

   

    private function __construct()
    {
        //  dans conf mais ne semble pas nécessaire
        // 'app'   => [
        //     /* Entrez ici l'url de votre page d'accueil */
        //     'url'      => '/',
        // ],


        // global $conf;
        $conf = [

         

            'db' => [
                /* Entrez ici vos identifiants pour se connecter à la base de données */
                'host'      => 'localhost',
                'database'  => 'certification',
                'user'      => 'root',
                'password' => 'Simplon1220*'
            ]
        ];

        try {
            $this->conx = new PDO('mysql:host=' . $conf['db']['host'] . ';dbname=' . $conf['db']
            ['database'], $conf['db']['user'], $conf['db']['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
            $this->conx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $message = 'Erreur ! ' . $e->getMessage() . '<hr />';
            die($message);
        }
    }

    public static function showDebug(string $raw_sql, array $parameters): string|array|null
    {

        $keys = [];
        $values = [];

        /*
         * Obtient les clés les plus longues en premier,
         * afin que le remplacement de la regex ne coupe pas les marqueurs
         */
        $isNamedMarkers = false;
        if (count($parameters) && is_string(key($parameters))) {
            uksort($parameters, function($k1, $k2) {
                return strlen($k2) - strlen($k1);
            });
            $isNamedMarkers = true;
        }
        foreach ($parameters as $key => $value) {

            // Vérifie si des paramètres nommés ':param' ou des paramètres anonymes ? sont utilisés
            if (is_string($key)) {
                $keys[] = '/:'.ltrim($key, ':').'/';
            } else {
                $keys[] = '/[?]/';
            }

            // Mets le paramètre dans un format lisible par l'être humain
            if (is_string($value)) {
                $values[] = "'" . addslashes($value) . "'";
            } elseif(is_int($value)) {
                $values[] = strval($value);
            } elseif (is_float($value)) {
                $values[] = strval($value);
            } elseif (is_array($value)) {
                $values[] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[] = 'NULL';
            }
        }

        $query = '';
        if ($isNamedMarkers) {
            $query = preg_replace($keys, $values, $raw_sql);
        } else {
            $query = preg_replace($keys, $values, $raw_sql, 1);
        }

        return '<div style="background:#b6e0b0;padding:10px;border:1px solid #CCC;color:#333;">'.$query.'</div>';

    }

// PdoDb est un singleton grace à cette classe
    public static function getInstance(): ?PdoDb
    {
        if (is_null(self::$connect)) {
            self::$connect = new PdoDb();
        }
        return self::$connect;
    }

    public function requete($sql, $fetchMethod = 'fetchAll')
    {
        try {
            $result = $this->conx->query($sql, PDO::FETCH_ASSOC)->{$fetchMethod}();
        } catch (PDOException $e) {
            $message = 'Erreur ! ' . $e->getMessage() . '<hr />';
            die($message);
        }
        return $result;
    }

    // Insert des données dans une table
    public function inserer($table, $data): bool
    {
        // On convertit l'objet en tableau
        $dataTab = get_object_vars($data);

        // On récupère les nom de champs dans les clés du tableau
        if (gettype($data) == "object") {
            $data = $dataTab;
        }
        $fields = array_keys($data);
        // On récupère les valeurs
        $values = array_values($data);
        // On compte le nombre de champ
        $values_count = count($values);
        // On construit la chaine des paramètres ':p0,:p1,:p2,...'
        $params = [];
        foreach ($values as $key => $value) {
            array_push($params, ':p' . $key);
        }
        $params_str = implode(',', $params);
        // On prépare la requête
        $reqInsert = 'INSERT INTO ' . $table . '(' . implode(',', $fields) . ')';
        $reqInsert .= ' VALUES(' . $params_str . ')';
        $prepared = $this->conx->prepare($reqInsert);
        // On injecte dans la requête les données avec leur type.
        for ($i = 0; $i < $values_count; $i++) {
            $type = match (gettype($values[$i])) {
                'NULL' => PDO::PARAM_NULL,
                'integer' => PDO::PARAM_INT,
                'boolean' => PDO::PARAM_BOOL,
                default => PDO::PARAM_STR,
            };
            // On lie une valeur au paramètre :pX
            $prepared->bindParam(':p' . $i, $values[$i], $type);
        }

        // On exécute la requête.
        // Retourne TRUE en cas de succès ou FALSE en cas d'échec.
        try {
            $prepared->execute();
            $result = true;

        } catch (PDOException $e) {
            $result = false;
        }
        return $result ;

    }

// Mettre à jour des données
    public function update($table, $data, $id): bool
    {
        // On convertit l'objet en tableau
        $dataTab = get_object_vars($data);
        if (gettype($data) == "object") {
            $data = $dataTab;
        }
        // on enlève le created_at que l'on ne veut pas modifier
        unset($data['created_at']);
        // On prépare la requête
        $reqExectue = [];
        $reqInsert = 'UPDATE ' . $table . ' SET';
        foreach ($data as $key => $value) {
            if (!next($data)) {
                $reqInsert .= ' ' . $key . ' = :' . $key;
                                    } else {
                $reqInsert .= ' ' . $key . ' = :' . $key . ',';
            }
            $reqExectue[$key] = $value;
        }
        $reqInsert .= ' WHERE id = :id';
        $reqExectue['id'] = $id;
        print_r($reqExectue['id']);
        $prepared = $this->conx->prepare($reqInsert);
        echo self::showDebug($reqInsert, $reqExectue);

        // On exécute la requête.
        // Retourne TRUE en cas de succès ou FALSE en cas d'échec.
        try {
            return $prepared->execute($reqExectue);
            $result = true;

        } catch (PDOException $e) {
            $result = false;

        }
        return $result;
    }

    // Supprimer des données
    public function delete($table, $id): bool
    {
       
        $data = [
            'id' => $id,
        ];
        $sql = 'DELETE FROM  '. $table. '  WHERE  id  =  :id';
        // statement
        $stmt= $this->conx->prepare($sql);
        try {
            $stmt->execute($data);
            $result = true;
        } catch (PDOException $e) {
            $result = false;
        }

        // autre solotion sans prepare et juste avec query

        // try {
        //     $sql = 'DELETE FROM ' . $table . '  WHERE  id  = ' .$id;

        //     $this->conx->query($sql);
            
        //     $result = true;
        // } catch (PDOException $e) {
        //     $result = false;
        // }
        
      return $result;
    }

    // Retourne l'id de la dernière insertion par auto-incrément dans la base de données
    public function dernierIndex(): string
    {
        return $this->conx->lastInsertId();
    }

  
}
