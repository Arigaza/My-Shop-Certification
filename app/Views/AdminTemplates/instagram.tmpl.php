<?php

/**
 * @var array $data Les données en provenance du contrôleur
 */

use MYSHOP\Controllers\MyShopController;
?>

    
    <div class="row">
        <div class="col mx-3 my-3">
            <table class="table table-striped table-condensed">
                <tr>
                    <td colspan="8">
                        <a href="<?= MyShopController::getRoute('newuser'); ?>" class="btn btn-secondary">
                           
                            Ajouter un compte Instagram
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Lien</th>
                    <th>Actif</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                <?php foreach ($data['Instagram'] as $item) {
                    extract($item);
                    ?>
                    <tr>
                        <td class="align-middle"><?= $id; ?></td>
                        <td class="align-middle"><?= $name; ?></td>
                        <td class="align-middle"><?= $link; ?></td>
                        <td class="align-middle"><?= ($active ==1) ?'Actif' : 'Inactif' ?></td>
                           
                        </td>
                        <td class="align-middle">
                            <a href="/admin/instagram/edit/<?= $id; ?>" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="<?= $data['color'];?>"
                                    class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <a href="/admin/instagram/delete/<?= $id; ?>" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="<?= $data['color'];?>"
                                    class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
