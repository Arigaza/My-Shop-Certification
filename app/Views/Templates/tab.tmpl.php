
<div class="row w-100" style="max-height: 100vh" >
    <div id="sidetab" class="col-2 position-fixed">
      <div class="row mb-2 headerbrown" style="padding: 0 20px">Les collections</div>   
        <div class="h-10">

   <?php  
   /**
 * @var array $data
 */   
$content = '';
   foreach ($data["Collections"] as $item)
{
$content .= '<div class="row p-2">
<a class="headerbrown collection_list" href="/collections/'.$data['Tab'] . '/' .trim(str_replace(' ', '-', $item['name'] )) . '">' . $item['name'] . '</a>
</div>';
}
echo $content;
?>
</div>
    </div>

<div class="col-10 p-0 m-0 Gallery">
    <div id="Gallery_container" class="text-center p-0 m-0 Gallery_container results">

<?php
require_once __DIR__ . '/../../Views/Partials/tab_data.part.php' ;
?>
    </div>
  </div> 