<?php
use MYSHOP\Controllers\MyShopController;
// check if the current url to see which header is needed
if ($_SERVER['REQUEST_URI'] === '/' && isset($data['HomeImage'][0]['image_path'])) {
   $header = '    <header class="fixed-top homenavbar fw-semibold container-fluid w-100 navbar-expand-lg d-flex justify-content-around justify-content-lg-between text-center align-items-center z-3">
  <a class="col"
  href="/"><img class="logohomepage fixed-top" src="'.MyShopController::assets('/imgs/mylogo.png').'" alt="logo">
</a><div class="dropdown col-lg d-lg-none p-3">
<button id="homedropdowntoggle" class="navbar-toggler headerwhite p-3 col rounded" type="button">
<span >Menu</span>
</button><ul id="dropdown" class="dropdown-menu headerwhite">
<li><a class="dropdown-item whitecolor home-dropdown" href="'. MyShopController::getRoute('ceramics').'">Ceramiste</a></li>
<li><a class="dropdown-item whitecolor home-dropdown" href="'. MyShopController::getRoute('photographs').'">Photographe</a></li>
<li><a class="dropdown-item whitecolor home-dropdown" href="'. MyShopController::getRoute('paints').'">Peintre</a></li>';

// check if admin or not
   if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {
      $header .= '<li><a class="dropdown-item whitecolor home-dropdown" href="'. MyShopController::getRoute('admin').'">Admin</a></li>';
   } else {
      $header .= '<li><a class="dropdown-item whitecolor home-dropdown" href="'. MyShopController::getRoute('contact').'">Contact</a></li>';
   }

   $header .= '</ul>
</div> 
<div class="nav-item col p-3 fullscreen-nav">
    <a class="navbar-brand headerwhite p-2 rounded"href="'. MyShopController::getRoute('ceramics').'">Ceramiste</a>
</div>
<div class="nav-item col p-3 fullscreen-nav">
    <a class="navbar-brand headerwhite p-2 rounded" href="'. MyShopController::getRoute('photographs').'">Photographe</a>
</div>

<div class="nav-item col p-3 fullscreen-nav">
    <a class="navbar-brand headerwhite p-2 rounded" href="'. MyShopController::getRoute('paints').'">Peintre Mural</a> 
</div>';
   // check if user is admin or not
   if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {
      $header .= '<div class=" nav-item p-3 col fullscreen-nav">
   <a id="header_admin" class="navbar-brand headerwhite p-2 rounded" href="'. MyShopController::getRoute('admin').'" >Admin</a>
   </div>';
   } else {
      $header .= '<div class="nav-item col p-3 fullscreen-nav">
   <a class="navbar-brand headerwhite p-2 rounded" href="'. MyShopController::getRoute('contact').'">Contact</a>
   </div>';
   }
   // check if Instagram link is set
   if (isset($data['Instagram'][0]['link'])) {
      $header .= '<div class="nav-item navbar-brand col p-0">
   <a  href="' . $data['Instagram'][0]['link'] . '" target="_blank"><img id="instagramlogo" class="Instagram_logo p-1" src="'. MyShopController::assets('/imgs/instagram-white.png') .'" alt =""></a>
   </div>';
   }
   $header .= '</header>';
   echo $header;
}

// Other header
else {
   $header = '<header class="navbar-background-color fixed-top homenavbar fw-semibold container-fluid w-100 navbar-expand-lg d-flex justify-content-around justify-content-lg-between text-center align-items-center z-3">
   
        
<a class="col"
    href="/"><img class="logohomepage fixed-top" src="'.MyShopController::assets('/imgs/mylogo.png').'" alt="logo">
</a>


<div class="dropdown d-lg-none p-3">
<button id="homedropdowntoggle" class="navbar-toggler headerbrown p-3 col " type="button">
    <span >Menu</span>
</button>
<ul id="dropdown" class="dropdown-menu headerbrown">
    <li><a class="dropdown-item headerbrown navbarelse" href="'. MyShopController::getRoute('ceramics').'">Ceramiste</a></li>
    <li><a class="dropdown-item headerbrown navbarelse" href="'. MyShopController::getRoute('photographs').'">Photographe</a></li>
    <li><a class="dropdown-item headerbrown navbarelse" href="'. MyShopController::getRoute('paints').'">Peintre Mural</a></li>';

   // check if admin or not
   if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {

      $header .= '<li><a class="dropdown-item headerbrown navbarelse" href="'. MyShopController::getRoute('admin').'">Admin</a></li>';
   } else {
      $header .= '    <li><a class="dropdown-item headerbrown navbarelse" href="'. MyShopController::getRoute('contact').'">Contact</a></li>
';
   }
   $header .= '</ul></div>';
   // managing the active tab with if on the list of class
   $header .= '<div class="nav-item col p-3 fullscreen-nav"><a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'ceramics') ? "active_fullscreen-nav" : "headerbrown") . '  p-2 navbarelse"href="'. MyShopController::getRoute('ceramics').'">Ceramiste</a></div>';
   $header .= '<div class="nav-item col p-3 fullscreen-nav"><a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'photographs') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="'. MyShopController::getRoute('photographs').'">Photographe</a></div>';
   $header .= '<div class="nav-item col p-3 fullscreen-nav"><a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'paints') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="'. MyShopController::getRoute('paints').'">Peintre Mural</a></div>';

   // check if admin or not
   if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {

      $header .= '<div class=" nav-item p-3 col fullscreen-nav">
<a class="navbar-brand headerbrown p-2 navbarelse" href="'. MyShopController::getRoute('admin').'" >Admin</a>
</div>';
   } else {
      $header .= '<div class="nav-item col p-3 fullscreen-nav">
   <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'contact') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="'. MyShopController::getRoute('contact').'">Contact</a>
   </div>';
   }

   if (isset($data['Instagram'][0]['link'])) {
$header .= '<div class="nav-item navbar-brand p-0 col">
<a href="'. $data['Instagram'][0]['link'] .'" target="_blank"><img id="instagramlogo" class="Instagram_logo p-1" src="'.MyShopController::assets('/imgs/instagram-brown.png').'" alt="instagram"></a>
</div>';
   }

   $header .= '</header>';


   echo $header;
}
