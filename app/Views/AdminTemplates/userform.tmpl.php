<?php

use MYSHOP\Controllers\MyShopController;
use MYSHOP\Controllers\Utilisateurs;



/**
 * @var array $data Les données en provenance du controller
 * $data['action'] > newuser || edituser
 * $data['userid']
 * $data['userinfos']
 */
extract($data);

/**
 * @string $mandatory Message pour les champs obligatoires
 */
$mandatory = '(<span class="text-danger">*</span>)';

/**
 * @array $formErrors Tableau pour stocker le nom des champs en erreur
 */
$formErrors = [];

/**
 * @string $xxxValidationClass Chaines pour stocker les classes à appliquer aux champs en erreur
 */
$surnameValidationClass = $nameValidationClass = $emailValidationClass = $passwordValidationClass = '';

/**
 * Instanciation du contrôleur UsersController
 */
$usersObj = Utilisateurs::getInstance();
$myshopInstance = MyShopController::getInstance();
/**
 * On récupère le jeton CSRF
 */
$csrfToken = MyShopController::getCSRFToken();

/** Validation du formulaire */
if (isset($_POST['useraction']) && !empty($_POST['useraction'])) {
    // Le champ prénom ne peut être vide
    if (empty($_POST['surname'])) {
        $formErrors[] = 'surname';
    }
    // Le champ nom ne peut être vide
    if (empty($_POST['name'])) {
        $formErrors[] = 'name';
    }
    // Le champ adresse email encrypté ne peut être vide
    // et doit être valide
    if (empty($_POST['cryptedEmail']) || !$usersObj->validateEmail($usersObj->aesDecrypt(base64_decode($_POST['cryptedEmail']), $csrfToken))) {
        $formErrors[] = 'email';
    }
    // Pour un nouvel utilisateur, le champ mot de passe encrypté ne peut être vide
    if ($action === 'newuser' && empty($_POST['cryptedPw'])) {
        $formErrors[] = 'password';
    }


    /** S'il n'y a pas d'erreur de saisie dans le formulaire */
    if (empty($formErrors)) {

        /** On valide le jeton csrf */
        if ($myshopInstance->validateFormRequest()) {

            /** Ajout du nouvel utilisateur */
            if ($action === 'newuser') {
                $insertUser = $usersObj->createUser($_POST);
                if ($insertUser) {
                    header('location: ' . MyShopController::getRoute('users'));
                }
            }

            /** Modification d'un utilisateur existant */
            if ($action === 'edituser' && !empty($_POST['id'])) {
                $updateUser = $usersObj->updateUser($_POST);
                if ($updateUser) {
                    header('location: ' . MyShopController::getRoute('users'));

                }
            }
        }
    }
}
?>

<div class="container">
    <?php
    // Détermination de l'action du formulaire
    $actionform = '';
    switch ($action) {
        case 'newuser':
            $actionform = MyShopController::getRoute('newuser');
            break;
        case 'edituser':
            $actionform = MyShopController::getRoute('edituser') . '/' . $userinfos['id'];
            break;
    }
    ?>

    <form action="<?= $actionform; ?>" id="userform" method="post" autocomplete="off">
<?php 
if ($_SESSION['admin']=== 1) {
    $return =MyShopController::getRoute('users');
} else {
   $return = MyShopController::getRoute('admin/setting');
}
?>
        <!-- Header Area -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 text-center p-3 bg-ui wow bounceIn">
                <a class="d-flex justify-content-start small link-underline link-underline-opacity-25 link-underline-opacity-100-hover"
                   href="<?= $return; ?>">&lt; Retour</a>
                <?php if ($action === 'newuser') { ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#833500"
                         class="bi bi-person-add"
                         viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                        <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                    </svg>
                <?php } elseif ($action === 'edituser') { ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#833500"
                         class="bi bi-person-gear"
                         viewBox="0 0 16 16">
                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                    </svg>
                <?php } ?>
                <div class="small">Les champs précédés d'une astérisque <?= $mandatory; ?> sont <span
                            class="text-danger">obligatoires</span>.
                </div>
            </div>
        </div>


        <!-- Formulaire Ajout/Modification d'un utilisateur -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 m-3 p-3 border rounded-3 bg-light">

                <!-- Champs cachés -->
                <?php if ($action === 'edituser') { ?>
                    <!-- Champ de stockage de l'id de l'utilisateur à modifier -->
                    <input type="hidden" name="id" value="<?= $userinfos['id']; ?>">
                <?php } ?>
                <!-- Champ de stockage de l'email encrypté -->
                <input type="hidden" id="cryptedEmail" name="cryptedEmail" value="">
                <!-- Champ de stockage du mot de passe encrypté -->
                <input type="hidden" id="cryptedPw" name="cryptedPw" value="">
                <!-- Champ de stockage de l'action newuser/edituser  -->
                <input type="hidden" id="useraction" name="useraction" value="<?= $action; ?>">
                <!-- Champ de stockage du jeton CSRF -->
                <?= MyShopController::insertHiddenToken(); ?>


             


                <!-- Champ Rôle -->
                <div class="form-group has-validation mb-5 wow fadeIn">
                    <?php
                    if (isset($userinfos)) {
                        $role = ($userinfos['is_admin'] === 1) ?"admin" :"user" ;  
                    } else{
                        $role = "";
                    }
                    
                 
                    ?>
                     <?php if ( $_SESSION['admin'] === 1) { ?>
                    <label class="form-label mb-2 bg-ui">R&ocirc;le <?= $mandatory; ?></label>
                    <div class="form-check mb-1">
                        <?php $checkedRole = $role === 'user' ? ' checked' : ''; ?>
                        <input type="radio" name="is_admin" id="role-user" value="0"
                               class="form-check-input"<?= $checkedRole; ?>>
                        <label for="role-user" class="form-label">Utilisateur</label>
                    </div>
                    <div class="form-check mb-1">
                        <?php $checkedRole = $role === 'admin' ? ' checked' : ''; ?>
                        <input type="radio" name="is_admin" id="role-admin" value="1"
                               class="form-check-input"<?= $checkedRole; ?>>
                        <label for="role-admin" class="form-label">Administrateur</label>
                    </div>
                </div>
                <?php } ?>

                <!-- Champ Prénom -->
                <div class="form-group has-validation mb-5 wow fadeIn">
                    <?php
                    $surname = (isset($userinfos) && $action === 'edituser')
                        ? $userinfos['surname'] : ((isset($_POST['surname']) && !empty($_POST['surname']))
                            ? $_POST['surname'] : '');

                    $surnameValidationClass = in_array('surname', $formErrors) ? ' is-invalid' : '';
                    ?>
                    <label for="surname" class="form-label bg-ui">Nom <?= $mandatory; ?></label>
                    <input type="text" id="surname" name="surname"
                           class="form-control<?= $surnameValidationClass; ?>" value="<?= $surname; ?>" required>
                    <div class="invalid-feedback">Veuillez saisir un nom !</div>
                </div>


                <!-- Champ Nom -->
                <div class="form-group has-validation mb-5 wow fadeIn">
                    <?php
                    $name = (isset($userinfos) && $action === 'edituser')
                        ? $userinfos['name'] : ((isset($_POST['name']) && !empty($_POST['name']))
                            ? $_POST['name'] : '');
                    $nameValidationClass = in_array('name', $formErrors) ? ' is-invalid' : '';
                    ?>
                    <label for="name" class="form-label bg-ui">Prénom <?= $mandatory; ?></label>
                    <input type="text" id="name" name="name"
                           class="form-control<?= $nameValidationClass; ?>" value="<?= $name; ?>" required>
                    <div class="invalid-feedback">Veuillez saisir un prénom !</div>
                </div>


                <!-- Champ Email -->
                <div class="form-group has-validation mb-5 wow fadeIn">
                    <?php
                    $email = (isset($userinfos) && $action === 'edituser')
                        ? $userinfos['email'] : ((isset($_POST['cryptedEmail']) && !empty($_POST['cryptedEmail']))
                            ? $usersObj->aesDecrypt(base64_decode($_POST['cryptedEmail']), $csrfToken) : '');
                    $emailValidationClass = in_array('email', $formErrors) ? ' is-invalid' : '';
                    ?>
                    <label for="email" class="form-label bg-ui">Adresse email <?= $mandatory; ?></label>
                    <input type="text" id="email" class="form-control<?= $emailValidationClass; ?>"
                           value="<?= $email; ?>" required>
                    <div class="invalid-feedback">Veuillez saisir une adresse mail valide !</div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="form-group has-validation mb-5 wow fadeIn">
                    <?php
                    $password = (isset($userinfos) && $action === 'edituser')
                        ? '' : ((isset($_POST['cryptedPw']) && !empty($_POST['cryptedPw']))
                            ? $usersObj->aesDecrypt(base64_decode($_POST['cryptedPw']), $csrfToken) : '');
                    $passwordValidationClass = in_array('password', $formErrors) ? ' is-invalid' : '';
                    ?>
                    <label for="password" class="form-label bg-ui">Mot de
                        passe <?= $action === 'newuser' ? $mandatory : ''; ?></label>
                    <input type="password" id="password" class="form-control<?= $passwordValidationClass; ?>"
                           value="<?= $password; ?>" autocomplete="new-password" required>
                    <div class="invalid-feedback">Veuillez saisir un mot de passe !</div>
                    <?php if ($action === 'edituser') { ?>
                        <span class="small">Saisissez un mot de passe seulement si vous souhaitez le changer.</span>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="row d-flex justify-content-center wow bounceIn">
            <div class="col-md-6 text-center p-3 bg-ui">
                <div class="form-group mb-3">
                    <a href="<?= MyShopController::getRoute('users'); ?>"
                       class="btn btn-secondary float-start">Annuler</a>
                    <?php $actionLabel = $action === 'newuser' ? 'Enregistrer' : 'Mettre à jour'; ?>
                    <button id="actionuser" type="button" class="btn btn-primary text-white float-end">
                        <?= $actionLabel; ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
