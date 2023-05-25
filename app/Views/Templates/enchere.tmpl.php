<!-- 
    <div class="container">
    <div class="row"></div>
<div class="row">
    <div class="col-5"></div>
    <div class="col-7"></div>
</div>
<div class="row"></div>
 -->
<?php
$date = new DateTimeImmutable();

if ($data[0]['montant'] !== null) {
    $currentbid = intval($data[0]['montant']) + 1;
} else {
    $currentbid =  intval($data[0]['prix_depart']) + 1 ;
}
$content = '<div class="container border rounded mt-5">';
$content .= '<div class="row  fs-1  rounded-top text text-center bg-light"><div class="text-black">'.$data[0]['titre_annonce'] .'</div></div>';
$content .= '<div class="row my-3"><div class="col-5">' ;
$content .= '<div class="bid_picture_container border rounded "><img class="img_cover" alt="'.$data[0]['marque']. ' ' . $data[0]['modele'].'" src="/imgs/' . $data[0]['photo'].'"></div>';
$content .= '</div>';

$content .= '<div class="col-7 ps-5 pb-3 d-flex justify-content-between flex-column"><div>';
$content .= '<h2>'.$data[0]['marque'] . ' ' . $data[0]['modele'] . '</h2>';
$content .= '<div class="py-2 fs-5 text">Année: '. $data[0]['annee'] .'</div>';
$content .= '<div class="py-2 fs-5 text">Puissance: '. $data[0]['puissance'] .'</div>';
$content .= '<div class="py-2 fs-5 text">Description: '. $data[0]['description'] .'</div>';
$content .= '<div class="py-2 fs-5 text">Prix de départ: '. number_format($data[0]['prix_depart'],2,","," ") .'€</div>';
$content .= '</div>';
if($data[0]['montant'] !==null)  {
    $content .= '<div>Montant de l\'enchère '. number_format($data[0]['montant'],2,","," ") .'€</div>';
} else {
    $content .= '<div class="bg-black p-1 " style="width:fit-content;"><div class="text-warning">Aucune enchère n\'a encore été déposé pour cette annonce</div></div>';
}
$content .= '</div></div>';

$content .= '<div class="row fs-4 rounded-bottom text d-flex  bg-light">';
$content .= '<div class="col">date de fin d\'enchere: '. date("m/d/Y H:i:s",$data[0]['date_fin_enchere']) .'</div>';
$content .= '<div class="col text-end p-2 ">';
$content .= '<a href="/" id="returnhome" class="btn border border-primary text-primary"> Retourner à la liste</a>';
if (isset($_SESSION['username']) && $_SESSION['username'] !== null) 
{
    $content .= '<button id="bid" class="btn border border-primary text-primary"> Faire une enchère</button>';
} else 
{
    $content .= '<button id="modalBtn" class="btn border border-primary text-primary"> Se connecter et proposer une enchère</button>';
}
$content .= '';
$content .= '</div></div>';

if (isset($_SESSION['username']) && $_SESSION['username'] !== null) { 
$content .= '<div id="myModal" class="modal">
       
<div id="login_form" class="modal-content">
<div class="row">
    <div class="d-flex flex-row-reverse">
        <span class="close">&times;</span>
    </div>
</div>
    <div class="form-signin m-auto border border-1 rounded-3 text-center">
        <form autocomplete="off" id="Insert">
            <h3 class="mb-3 fw-normal w-full">Faire une enchère</h3>
            <div class="form-floating p-2">
                <input type="number" class="form-control" name="montant"  placeholder="Votre enchère" min="'. $currentbid.'">
                <label for="bid">Votre enchère</label>
            </div>
            <div class="form-floating p-2 d-none">
            <input id="uid_utilisateur" type="hidden" name="uid_utilisateur" class="form-control" value="'.($_SESSION['uid']) .'">
            </div>
            <div class="form-floating p-2 d-none">
            <input id="uid_annonce" type="hidden" name="uid_annonce" class="form-control" value="'.($data[0]['annonceuid']) .'">
            </div>
            <div class="form-floating p-2 d-none">
             <input id="date" type="hidden" name="date" class="form-control" value="'.$date->getTimestamp() .'">
             </div>
            <button id="bidBtn" class="btn btn-lg btn-primary w-100 p-2" type="button">Confirmer</button>
        </form>
    </div>
</div>
</div>
</div>';
}

echo $content;
?>

