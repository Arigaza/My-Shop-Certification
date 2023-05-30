    <?php
    //   transparent header 

    use MYSHOP\Controllers\MyShopController;

    if ($_SERVER['REQUEST_URI'] === '/admin' && isset($data['HomeImage'][0])) {

        $content = '<header class="fixed-top homenavbar fw-semibold container-fluid w-100 navbar-expand-lg d-flex justify-content-around justify-content-lg-between text-center align-items-center z-3">
                        <a class="col"
                        href="/"><img class="logohomepage fixed-top" src="' . MyShopController::assets('/imgs/mylogo.png') . '" alt="logo">
                      </a><div class="dropdown col d-lg-none p-3">
                      <button id="homedropdowntoggle" class="navbar-toggler headerwhite p-3 col rounded" type="button">
                      <span >Menu</span>
                      </button><ul id="dropdown" class="dropdown-menu headerwhite"> <li><a class="dropdown-item whitecolor home-dropdown" href="' . MyShopController::getRoute('admin/ceramics') . '">Ceramiste</a></li>
                      <li><a class="dropdown-item whitecolor home-dropdown" href="' . MyShopController::getRoute('admin/photographs') . '">Photographe</a></li>
                      <li><a class="dropdown-item whitecolor home-dropdown" href="' . MyShopController::getRoute('admin/paints') . '">Peintre</a></li>
                      <li><a class="dropdown-item whitecolor home-dropdown" href="' . MyShopController::getRoute('admin/collections') . '">Collection</a></li>
                      <li><a class="dropdown-item whitecolor home-dropdown" href="' . MyShopController::getRoute('admin/home-image') . '">Home Image</a></li>
                      <li><button  class="dropdown-item whitecolor home-dropdown logoutBtn" href="' . MyShopController::getRoute('admin/logout') . '">Se déconnecter</></li>
                      <li><a class="dropdown-item whitecolor home-dropdown" href="' . MyShopController::getRoute('admin/setting') . '">Paramètres</a></li>
                      </ul>
                </div>     
                <div class="nav-item col p-3 fullscreen-nav">
                    <a class="navbar-brand headerwhite p-2 rounded" href="' . MyShopController::getRoute('admin/ceramics') . '">Ceramiste</a>
                </div>  
                <div class="nav-item col p-3 fullscreen-nav">
                    <a class="navbar-brand headerwhite p-2 rounded" href="' . MyShopController::getRoute('admin/photographs') . '">Photographe</a>
                </div>
                <div class="nav-item col p-3 fullscreen-nav">
                    <a class="navbar-brand headerwhite p-2 rounded" href="' . MyShopController::getRoute('admin/paints') . '">Peintre</a>
                </div>
                <div class="nav-item col p-3 fullscreen-nav">
                    <a class="navbar-brand headerwhite p-2 rounded" href="' . MyShopController::getRoute('admin/collections') . '">Collection</a>
                </div>
                <div class="nav-item col p-3 fullscreen-nav">
                    <a class="navbar-brand headerwhite p-2 rounded" href="' . MyShopController::getRoute('admin/home-image') . '">Home Image</a>
                </div>      
            <div class=" nav-item p-3 col fullscreen-nav">
            <a id="header_admin" class="navbar-brand headerwhite p-2 rounded" href="' . MyShopController::getRoute('admin/setting') . '">Paramètres</a>
        </div>
        <div class="nav-item col p-3 "><div class="navbar-brand headerwhite p-2 rounded logoutBtn">Se déconnecter</div>
        </div>
            </header>';
    }


    // other header
    else {

        $content = ' <header id="header_admin" class="navbar-background-color navbar fixed-top  fw-semibold container-fluid w-100 navbar-expand-lg d-flex justify-content-around justify-content-lg-between text-center align-items-center z-3">
   
        
                        <a class="col"
                            href="/"><img class="logohomepage" src="' . MyShopController::assets('/imgs/mylogo.png') . '" alt="logo">
                        </a>
                    
                
                    <div class="col dropdown d-lg-none">
                        <button id="homedropdowntoggle" class="navbar-toggler headerbrown p-3 col " type="button">
                            <span >Menu</span>
                        </button>
                        <ul id="dropdown" class="dropdown-menu headerbrown z-3">
                          <li><a class="dropdown-item headerbrown navbarelse" href="' . MyShopController::getRoute('admin/ceramics') . '">Ceramiste</a></li>
                          <li><a class="dropdown-item headerbrown navbarelse" href="' . MyShopController::getRoute('admin/photographs') . '">Photographe</a></li>
                          <li><a class="dropdown-item headerbrown navbarelse" href="' . MyShopController::getRoute('admin/paints') . '">Peintre</a></li>
                          <li><a class="dropdown-item headerbrown navbarelse" href="' . MyShopController::getRoute('admin/collections') . '">Collection</a></li>
                          <li><a class="dropdown-item headerbrown navbarelse" href="' . MyShopController::getRoute('admin/home-image') . '">Home Image</a></li>
                          <li><div   class="dropdown-item headerbrown navbarelse logoutBtn">Se déconnecter</div></li>
                        </ul>
                    </div>     
                    <div class="nav-item col p-3 fullscreen-nav">
                        <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'ceramics') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="' . MyShopController::getRoute('admin/ceramics') . '">Ceramiste</a>
                    </div>  
                    <div class="nav-item col p-3 fullscreen-nav">
                        <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'photographs') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="' . MyShopController::getRoute('admin/photographs') . '">Photographe</a>
                    </div>
                  
                    <div class="nav-item col p-3 fullscreen-nav">
                        <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'paints') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="' . MyShopController::getRoute('admin/paints') . '">Peintre</a>
                    </div>
                    <div class="nav-item col p-3 fullscreen-nav">
                        <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'collections') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="' . MyShopController::getRoute('admin/collections') . '">Collection</a>
                    </div>
                    <div class="nav-item col p-3 fullscreen-nav">
                        <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'home-image') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="' . MyShopController::getRoute('admin/home-image') . '">Home Image</a>
                    </div>       
                <div class=" nav-item p-3 col">
                <a class="navbar-brand ' . (str_contains($_SERVER['REQUEST_URI'], 'setting') ? "active_fullscreen-nav" : "headerbrown") . ' p-2 navbarelse" href="' . MyShopController::getRoute('admin/setting') . '">Paramètres</a>
                </div>
                <div class="nav-item col p-3 fullscreen-nav">
                    <div  class="navbar-brand headerbrown p-2 navbarelse logoutBtn">Se déconnecter</div>
                </div>
                
                </header>';
    }
    echo $content;
