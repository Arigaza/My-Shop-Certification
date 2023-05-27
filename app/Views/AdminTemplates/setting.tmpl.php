
<div class="row margin-left"><div class="p-3">Bonjour <?= $_SESSION['name'] ?></div>   </div>
<div class="row d-flex justify-content-center margin-left">
        <a class="p-3" href="/admin/users/edituser/<?= $_SESSION['uid'] ?>">Modifier les information personnelles
        <a class="p-3" href="/admin/instagram/list"> Modifier Instagram</a>
        <?php

                                                    use MYSHOP\Controllers\MyShopController;

 if($_SESSION['admin'] === 1) {?>
<a class="p-3" href="<?= MyShopController::getRoute('users') ?>"> Voir les utilisateur</a>

            <?php } ?>
</div>



