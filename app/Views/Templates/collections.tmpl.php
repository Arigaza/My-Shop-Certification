

<div class="row margin-left pb-5 d-flex justify-content-center"> 
  <h1 class="row d-flex justify-content-center pb-2"><?= $data["Collection"][0]['name'] ?></h1>
  <p class="row"><?= $data["Collection"][0]['description'] ?></p>
</div>


<div class="row w-100" style="max-height: 100vh" >
    <div id="sidetab" class="col-2 position-fixed">
      <div class="row mb-2 headerbrown" style="padding: 0 20px">Les sous-collections</div>   
        <div class="h-10">

   <?php  
   /**
 * @var array $data
 */   
$content = '';
   foreach ($data["Sub_collection_name"] as $item)
{
$content .= '<div class="row p-2">
<a class="' . (str_contains($_SERVER['REQUEST_URI'], $item["sub_collection_name"]) ? "active_fullscreen-nav" : "headerbrown") . ' collection_list" href="/sous-collection/' . $data['Tab']. '/' .trim(str_replace(' ', '-', $item['name'] )) . '/' .trim(str_replace(' ', '-', $item['sub_collection_name'] )) . '">' . $item['sub_collection_name'] . '</a>
</div>';
}
echo $content;
?>
</div>
    </div>

<div class="col-10 p-0 m-0 Gallery">
    <div id="Gallery_container" class="text-center p-0 m-0 Gallery_container results">

<?php
require_once __DIR__ . '/../../Views/Partials/collections_data.part.php' ;
?>
    </div>
  </div> 