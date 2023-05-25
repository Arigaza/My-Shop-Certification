<div id="frontpagecontainer" class="frontpagecontainer">
    <?php 
    // symlink('/../../storage/app/public', '/storage');
    $location = dirname($_SERVER['DOCUMENT_ROOT']);
    $image    = $data['HomeImage'][0]['image_path'];
    

    // $imageLocation = __DIR__ . '/../../..' . $data['HomeImage'][0]['image_path'] ;
    // $imageLocation = str_replace(['/'], '\\', $imageLocation);
    // $imagePath = file_get_contents($imageLocation);
    if (isset($data['HomeImage'][0]))
    {
   $content = '<img id="frontpageimage" class="frontpageimage" src="' . $image . '" alt="Image d\'acceuil">';
echo $content;
}
    
    ?>
    </div>

