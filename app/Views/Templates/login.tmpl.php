<div id="frontpagecontainer" class="frontpagecontainer">
    <?php 

use MYSHOP\Controllers\MyShopController;

    $location = dirname($_SERVER['DOCUMENT_ROOT']);
    $image    = $data['HomeImage'][0]['image_path'];
    

    // $imageLocation = __DIR__ . '/../../..' . $data['HomeImage'][0]['image_path'] ;
    // $imageLocation = str_replace(['/'], '\\', $imageLocation);
    // $imagePath = file_get_contents($imageLocation);
    if (isset($data['HomeImage'][0]))
    {
   $content = '<img id="frontpageimage" class="frontpageimage" src="' . (isset($data['HomeImage'][0])) ? $image : MyShopController::assets('/imgs/mvc-ui.svg')  . '" alt="Image d\'acceuil">';
echo $content;
// echo '<br><br><br><br><br><br><br><br><br><br><br><br>' . print_r();
}
    
    ?>
    </div>

    <div class="d-flex justify-content-center align-items-center">
<div></div>

    </div>

