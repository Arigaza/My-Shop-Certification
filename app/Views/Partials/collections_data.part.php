
<?php

use MYSHOP\Controllers\MyShopController;

$i = 1;
$content = '';
/**
 * @var array $data
 */
$tab = explode("/", $_SERVER['REQUEST_URI']);
foreach ($data['Content'] as $item) {
    $overlay = '';
    if (isset($_SESSION['admin'])) {
        $route = "admin/" .$data['Tab'] . '/' . $item['id'];
$overlay = '<a href="/' . $route . '">Modifier</a>
';
    }
    if (!(str_contains($tab[1], "sous-collection"))) {
        if (!empty($item['sub_collection_name'])) {
            $overlay .='  <h2><a href="/sous-collection/'.$data['Tab'] . '/'.trim(str_replace(' ', '-', $item['collections_name'] )) . '/' . trim(str_replace(' ', '-', $item['sub_collection_name'] )). '">' . $item["sub_collection_name"] . '</a></h2>';

        } else {
            $overlay .='<h2>'. $item["name"] .'</h2><p>' . $item["description"] . '</p>' ;
        }
    } else  {
        $overlay .='<h2>'. $item["name"] .'</h2><p>' . $item["description"] . '</p>' ;

    } 
    switch ($i) {
        case 1:
            $content .= '<div class="row col_gap_20">  
            <div class="col p-0 m-0 col_width_408">
              <div class="hovereffect p-0 m-0  anti_overflow_container_sm rounded ">
                <img src="' . $item["image_path"] . '" class="shadow-1-strong rounded  anti_overflow_image_sm" alt="' . (!empty($item['name']) ? $item['name'] : $item['collections_name']) . '" style="transform: translate(' . $item["translate_x"] . '%,' .  $item["translate_y"] . '%)">
                <div class="overlay">'
                    . $overlay .
                '</div>
            </div>';
            $i = 2;
            break;

        case 2:
            $content .= '<div class="hovereffect anti_overflow_container_xl rounded">
            <img src="' . $item["image_path"] . '" class="shadow-1-strong rounded  anti_overflow_image_xl" alt="' . (!empty($item['name']) ? $item['name'] : $item['collections_name']) . '" style="transform:translate(' . $item["translate_x"] . '%, ' .  $item["translate_y"] . '%)">
          <div class="overlay">'
            . $overlay .
          '</div> </div></div>';
            $i = 3;
            break;

        case 3:
            $content .= '<div class="col p-0 m-0 col_width_408">
            <div class="hovereffect anti_overflow_container_xl rounded">
                <img src="' . $item["image_path"] . '" class="shadow-1-strong rounded  anti_overflow_image_xl" alt="' . (!empty($item['name']) ? $item['name'] : $item['collections_name']) . '" style="transform:translate(' . $item["translate_x"] . '%,' .  $item["translate_y"] . '%)">
                <div class="overlay">'
                    . $overlay .
                '</div>
            </div>';
            $i = 4;
            break;

        case 4:
            $content .= '<div class="hovereffect p-0 m-0  anti_overflow_container_sm rounded ">
            <img src="' . $item["image_path"] . '" class="shadow-1-strong rounded  anti_overflow_image_sm" alt="' . (!empty($item['name']) ? $item['name'] : $item['collections_name']) . '" style="transform:translate(' . $item["translate_x"] . '%,' .  $item["translate_y"] . '%)">
            <div class="overlay">'
                . $overlay .
            '</div>
        </div>               
    </div>';
            $i = 5;
            break;

        case 5:
            $content .= '<div class="col p-0 m-0 col_width_408">
            <div class="hovereffect p-0 m-0  anti_overflow_container_sm rounded ">
                <img src="' . $item["image_path"] . '" class="shadow-1-strong rounded anti_overflow_image_sm" alt="' . (!empty($item['name']) ? $item['name'] : $item['collections_name']) . '" style="transform:translate(' . $item["translate_x"] . '%,' .  $item["translate_y"] . '%)">
                <div class="overlay">'
                    . $overlay .
                '</div>
            </div>';
            $i = 6;
            break;

        case 6:
            $content .= '<div class="hovereffect p-0 m-0 anti_overflow_container_xl rounded">
            <img src="' . $item["image_path"] . '" class="shadow-1-strong rounded anti_overflow_image_xl" alt="' . (!empty($item['name']) ? $item['name'] : $item['collections_name']) . '" style="transform:translate(' . $item["translate_x"] . '%,' .  $item["translate_y"] . '%)">
            <div class="overlay">'
                . $overlay .
            '</div>
            </div>   
    </div>
</div>';
            $i = 1;
            break;
    }
}
echo $content;  


?>
