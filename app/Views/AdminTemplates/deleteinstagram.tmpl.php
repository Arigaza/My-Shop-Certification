<?php

use MYSHOP\Controllers\AdminController;
use MYSHOP\Controllers\MyShopController;


/**
 * @var array $data Les données renvoyées depuis le controlleur
 */
extract($data);

//** Si ce même formulaire vient d'être posté */
if(isset($_POST['id'])) {
    // On valide le jeton CSRF
    $instagramObj = MyShopController::getInstance();
    $adminObJ = AdminController::getInstance();
    if($instagramObj->validateFormRequest()) {
       $destroyUser = $adminObJ->destroyInstagram($_POST['id']);
       if($destroyUser) {
           header('location: ' . MyShopController::getRoute('instagram'));
       }
    }
}
?>


<div class="container">

    <form action="<?= MyShopController::getRoute('deleteinstagram'); ?>" id="instagramdeleteform" method="post" autocomplete="off">

        <!-- Header Area -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 text-center p-3 bg-ui animated bounceIn">
                <a class="d-flex justify-content-start small link-underline link-underline-opacity-25 link-underline-opacity-100-hover"
                   href="<?= MyShopController::getRoute('instagram'); ?>">&lt; Retour à la liste</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#833500" class="bi bi-person-x"
                     viewBox="0 0 16 16">
                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
                </svg>
            </div>
        </div>

        <!-- Message de confirmation de supression d'un utilisateur -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 m-3 p-3 border rounded-3 bg-light text-center">
                Souhaitez-vous r&eacute;ellement supprimer le compte instagram <br><?= $name; ?> ?
                <!-- Champ de stockage de l'id de l'utilisateur à modifier -->
                <input type="hidden" name="id" value="<?= $id; ?>">
                <!-- Champ de stockage du jeton CSRF -->
                <?= MyShopController::insertHiddenToken(); ?>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 text-center p-3 bg-ui"> 
                <div class="form-group mb-3">
                    <a href="<?= MyShopController::getRoute('instagram'); ?>"
                       class="btn btn-secondary float-start">Non</a>
                    <button id="deleteinstagram" value="1" type="button" class="btn btn-primary text-white float-end">
                        Oui
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

