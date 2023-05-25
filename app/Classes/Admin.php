<?php

namespace MYSHOP\Controllers;

use MYSHOP\Utils\Database\PdoDb;
use MYSHOP\Models;
use MYSHOP\Models\TabsModele;

class AdminController extends Controller
{

    public $result;
    protected static self|null $instance = null;

    public static function getInstance(): AdminController
    {
        if (AdminController::$instance === null) {
            AdminController::$instance = new AdminController;
        }
        return AdminController::$instance;
    }

    public function showtab($tab)
    {
        $db = PdoDb::getInstance();

        $Collections = $db->requete('SELECT * FROM collections');
        $Sub_collection_name = $db->requete('SELECT DISTINCT ' . $tab . '.sub_collection_name FROM ' . $tab . ' ORDER BY ' . $tab . '.sub_collection_name');
        $data["Collections"] = $Collections;
        $data["Sub_collection_name"] = $Sub_collection_name;
        $data["Tab"] = $tab;
        if (isset($_GET['tabid'])) {
            $content = $db->requete('SELECT 
            ' . $tab . '.name AS name, 
            ' . $tab . '.description AS description, 
            ' . $tab . '.image_path,
            ' . $tab . '.sub_collection_name,
            ' . $tab . '.translate_y,
            ' . $tab . '.translate_x,
            ' . $tab . '.id,
            collections.id AS collections_id,
            collections.name AS collections_name FROM ' . $tab . ' LEFT JOIN collections ON ' . $tab . '.collections_id = collections.id WHERE ' . $tab . '.id =' . $_GET['tabid']);
            $data['Content'] = $content;
            return $this->render('Layouts.admin', 'AdminTemplates.edittab', $data);
        } else {
            return $this->render('Layouts.admin', 'AdminTemplates.tab', $data);
        }
    }

    public function showcollections()
    {
        $db = PdoDb::getInstance();
        $tab = explode("/", $_SERVER['REQUEST_URI']);
        $Collections = $db->requete('SELECT * FROM collections');
        $data['Tab'] = $tab[2];
        $data["Collections"] = $Collections;
        return $this->render('Layouts.admin', 'AdminTemplates.collections', $data);
    }

    public function showhomeimage()
    {
        $db = PdoDb::getInstance();

        $tab = explode("/", $_SERVER['REQUEST_URI']);
        $tab[2] = str_replace("-", "_", $tab[2]);
        $HomeImage = $db->requete('SELECT * FROM home_image ORDER BY RAND() LIMIT 1');
        $data['Content'] = $HomeImage;
        $data['Tab'] = $tab[2];
        return $this->render('Layouts.admin', 'AdminTemplates.homeimage', $data);
    }

    public function showedithomeimage()
    {
        $db = PdoDb::getInstance();

        $HomeImage = $db->requete('SELECT * FROM home_image WHERE id = ' . $_GET['tabid']);
        $data['Content'] = $HomeImage;
        return $this->renderPartial('admin_home_image_data', $data);
    }
    public function showsetting()
    {
        $db = PdoDb::getInstance();
        $tab = explode("/", $_SERVER['REQUEST_URI']);



        $data['Tab'] = $tab[2];

        return $this->render('Layouts.admin', 'AdminTemplates.setting', $data);
    }

    public function insertdata()
    {
        $GP = $_POST;
        $result = "Unknown Error";
        $myShopUI = MyShopController::getInstance();
        if (isset($_SESSION['admin'])) {
            $admin = ($_SESSION['admin'] == 1) ? true : false;
        } else {
            $admin = false;
        }

        $requestIsAjax = $admin && $myShopUI->domainCheck();
        if (!$requestIsAjax) {
            exit();
        }
        // define("ALLOWED_SIZE",   6000000);    // CHANGE ALLOWED SIZE AS YOUR NEED
        define("SAVED_DIRECTORY", __DIR__ . "/../../public/storage/uploads/"); // CHANGE SAVED DIRECTORY AS YOUR NEED

        $allowed_extensions = array("jpeg", "jpg", "png"); // CHANGE allowed extension AS YOUR NEED
        if (isset($_FILES['image'])) {
            $errors = null;

            $uploaded_file_name = $_FILES['image']['name'];
            $uploaded_file_size = $_FILES['image']['size'];
            $uploaded_file_tmp  = $_FILES['image']['tmp_name'];
            //   $uploaded_file_type = $_FILES['image']['type'];

            $file_compositions = explode('.', $uploaded_file_name);
            $file_ext = strtolower(end($file_compositions));

            $saved_file_name = date('Ymdhis') . $uploaded_file_name; // CHANGE FILE NAME AS YOUR NEED

            if (in_array($file_ext, $allowed_extensions) === false) {
                $errors = 'Extension not allowed, please choose a JPEG or PNG file';
            }
            //   if($uploaded_file_size > ALLOWED_SIZE)
            //     $errors[] = 'File size is too big';

            if (empty($errors) == true) { // if no error, uploaded image is valid
                move_uploaded_file($uploaded_file_tmp, SAVED_DIRECTORY . $saved_file_name);
                $result = "success";
            } else {
                $result = $errors;
            }
        }
        if (isset($_POST["tab"])) {
            // connection à la database
            $db = PdoDb::getInstance();
            // envoie les donnée de le path de l'image dans GP s'il une image a bien été envoyée
            if ($_POST["tab"] == "ceramics" || $_POST["tab"] == "paints" || $_POST["tab"] == "photographs") {
                if (isset($saved_file_name)) {
                    

                    $image_path = "/storage/uploads/" . $saved_file_name;
                    $image_patharray = array("image_path" => $image_path);
                    $GP = array_merge($_POST, $image_patharray);
                } else {
                    $GP = $_POST;
                }

                // vérifie si c'est pour delete ou si c'est pour update/insert


                // verifie si c'est pour update ou non $_POST['id']=> update
                if (!isset($GP['id'])) {


                    $db->inserer($GP["tab"], new TabsModele($GP));
                    echo json_encode([
                        'status' => 200,
                        'message' => $result
                    ]);
                } else {
                    $db->update($GP["tab"], new TabsModele($GP), $GP['id']);
                    if (isset($saved_file_name)) {
                        if (file_exists($_POST['delete_image_path'])) {
                            // supprime l'ancienne photo pour qu'elle ne prenne plus de place dans le disque dur
                            unlink($GP['delete_image_path']);
                        }
                    }

                    echo json_encode([
                        'status' => 200,
                        'message' => 'success'
                    ]);
                }
            } else if ($GP["tab"] == "collections") {
                $db = PdoDb::getInstance();

                // update si itemID est set sinon crée une nouvelle collection

                if (isset($GP["id"])) {
                    $db->update($GP["tab"], new TabsModele($GP), ($GP["id"]));
                } else {
                    $db->inserer($GP["tab"], new TabsModele($GP));
                }

                echo json_encode([
                    'status' => 200,
                    'message' => 'success'
                ]);
            } else if ($GP["tab"] == "home_image") {


                $image_path = "/storage/uploads/" . $saved_file_name;
                $image_patharray = array("image_path" => $image_path);

                $GP = array_merge($_POST, $image_patharray);

                $db = PdoDb::getInstance();

                $db->inserer($_POST["tab"], new TabsModele($GP));
                echo json_encode([
                    'status' => 200,
                    'message' => $result
                ]);
            } else if ($GP["tab"] = "instagram") {
            }
        }
    }

    public function deleteData($tab, $id)
    {
        if (!isset($_SESSION['admin'])) {
            echo json_encode([
                'status' => 200,
                'message' => 'failure'
            ]);
            exit();
        }
        if ($tab == "users") {
            if ($_SESSION['admin'] !== 1) {
                echo json_encode([
                    'status' => 200,
                    'message' => 'failure'
                ]);
                exit();
            }
        }
        $db = PdoDb::getInstance();
        if ($db->delete($tab, $id) == true) {
            echo json_encode([
                'status' => 200,
                'message' => 'success'
            ]);
        } else {
            echo json_encode([
                'status' => 200,
                'message' => 'failure'
            ]);
        }
        $db->delete($tab, $id);
    }
}
