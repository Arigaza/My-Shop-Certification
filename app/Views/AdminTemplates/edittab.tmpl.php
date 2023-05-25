<?php


use MYSHOP\Controllers\MyShopController;



$content = '<div class="afterheaderadmin pb-5 row">
<div class="col"><div id="message"></div><form id="formtab" method="post" action="/admin/post" enctype="multipart/form-data">
  <h3 class="text-center mb-5">Enregistrer une nouvelle photo</h3> 
  <label for="collection-selector">Collections</label>
  <select id="collection-selector" class="form-select" aria-label="Default select example">';

if (!isset($data['Content'][0]['collections_id'])) {

  $content .= '<option selected value="">Pas dans une collection</option>';
} else {
  if (($data['Content'][0]['collections_id'] !== "" && $data['Content'][0]['collections_id'] !== null)) {
    $content .= '<option value="">Pas dans une collection</option>';
  } else {
    $content .= '<option selected value="">Pas dans une collection</option>';
  }
}

foreach ($data["Collections"] as $item) {
  if (!isset($data['Content'])) {
    $content .= '<option value="' . $item["id"] . '">' . $item["name"] . '</option>';
  } else {
    if ($item["id"] == $data['Content'][0]['collections_id']) {
      $content .= '<option selected value="' . $item["id"] . '">' . $item["name"] . '</option>';
    } else {
      $content .= '<option value="' . $item["id"] . '">' . $item["name"] . '</option>';
    }
  }
}
$content .= '</select>

      <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" class="form-control" value ="'. $data['Content'][0]['name'] .'" >
      </div>
      <label for="sub_collection_selector">Sous-collection</label>
      <select id="sub_collection_selector" class="form-select" aria-label="Default select example">';

if (!isset($data['Content'][0]['sub_collection_name'])) {

  $content .= '<option selected value="">Pas dans une sous-collection</option>';
} else {
  if (($data['Content'][0]['sub_collection_name'] !== "" && $data['Content'][0]['sub_collection_name'] !== null)) {
    $content .= '<option value="">Pas dans une sous-collection</option>';
  } else {
    $content .= '<option selected value="">Pas dans une sous-collection</option>';
  }
}
foreach ($data["Sub_collection_name"] as $item) {
  if (($item['sub_collection_name'] !== "" && $item['sub_collection_name'] !== null)) {
    if (!isset($data['Content'][0]['sub_collection_name'])) {
      $content .= '<option value="' . $item["sub_collection_name"] . '">' . $item["sub_collection_name"] . '</option>';
    } else {
      if ($item["sub_collection_name"] == $data['Content'][0]['sub_collection_name']) {
        $content .= '<option selected value="' . $item["sub_collection_name"] . '">' . $item["sub_collection_name"] . '</option>';
      } else {
        $content .= '<option value="' . $item["sub_collection_name"] . '">' . $item["sub_collection_name"] . '</option>';
      }
    }
  }
}

$content .= ' </select>
 <div class="form-group">
   <label for="sub_collection_name">Sous-collection</label>';

if (!isset($data['Content'][0]['sub_collection_name'])) {

  $content .= '<input type="text" id="sub_collection_name" name="sub_collection_name" class="form-control" >';
} else {
  if ($data['Content'][0]['sub_collection_name'] !== "" && $data['Content'][0]['sub_collection_name'] !== null) {
    $content .= '<input type="text" id="sub_collection_name" name="sub_collection_name" class="form-control" value ="' . $data['Content'][0]['sub_collection_name'] . '">';
  } else {
    $content .= '<input type="text" id="sub_collection_name" name="sub_collection_name" class="form-control" >';
  }
}
$content .= '</div>
 <div class="form-group">
   <label for="description">Description</label>';
if (!isset($data['Content'][0]['description'])) {
  $content .= '<textarea id="description" name="description" class="form-control" ></textarea></div>';
} else {
  $content .= '<textarea id="description" name="description" class="form-control" >' . $data['Content'][0]['description'] . '</textarea></div>';
}
if (!isset($data['Content'][0]['collections_id'])) {
  $content .= '<input id="collections_id" type="hidden" name="collections_id" class="form-control" >';
} else {
  $content .= '<input id="collections_id" type="hidden" name="collections_id" class="form-control" value="' . $data['Content'][0]['collections_id'] . '" >';
}


if (!isset($data['Content'][0]['translate_x'])) {
  $content .= '<div class="form-group"><label for="image_translateX_selector">Modifier l\'alignement de l\'image(Largeur)</label>
  <input type="range" min="-40" max="0" name="translate_x" id="image_translateX_selector" class="form-control" value="0">
</div>';
} else {
  $content .= '<div class="form-group"><label for="image_translateX_selector">Modifier l\'alignement de l\'image(Largeur)</label>
  <input type="range" min="-40" max="0" name="translate_x" id="image_translateX_selector" class="form-control" value="' . $data['Content'][0]['translate_x'] . '">
</div>';
}



if (!isset($data['Content'][0]['translate_y'])) {
  $content .= '<div class="form-group">
  <label for="image_translateY_selector">Modifier l\'alignement de l\'image(hauteur)</label>
  <input type="range" min="-45" max="0" name="translate_y" id="image_translateY_selector" class="form-control" value="0">
</div>';
} else {
}
$content .= '<div class="form-group">
   <label for="image_translateY_selector">Modifier l\'alignement de l\'image(hauteur)</label>
   <input type="range" min="-45" max="0" name="translate_y" id="image_translateY_selector" class="form-control" value="' . $data['Content'][0]['translate_y'] . '">
 </div>';

if (!isset($data['Content'][0]['image_path'])) {
  $content .= '<div class="custom-file mt-3">
  <input type="file" name="file" class="custom-file-input" id="chooseFile" accept="image/*" required>
  <label class="custom-file-label" for="chooseFile">Selectionner une image</label>
</div>';
} else {
  $content .= '<div class="custom-file mt-3">
  <input type="file" name="file" class="custom-file-input" id="chooseFile" accept="image/*">
  <label class="custom-file-label" for="chooseFile">Selectionner une image</label>
</div> <input type="hidden" name="delete_image_path" id="delete_image_path" value= "' . $data['Content'][0]['image_path'] . '">
';
}


$content .= '<input type="hidden" name="tab"  id="tabName" value= "' . $data["Tab"] . '">
 <input type="hidden" name="MYSHOP_CSRF_TOKEN_SESS_IDX"  id="MYSHOP_CSRF_TOKEN_SESS_IDX" value= "' . $_SESSION["MYSHOP_CSRF_TOKEN_SESS_IDX"] . '">
';

if (isset($data['Content'][0]['id'])) {
  $content .= ' <input id="itemID" type="hidden" name="id"  value= "' . $data['Content'][0]['id'] . '">';
}

$content .= '<div class "col"> 
 <button class="btn btn-primary btn-block mt-4 me-5 text-light">
     Enregistrer l\'image
 </button><div id="deleteBtn" class="btn btn-primary btn-block mt-4 text-light">
 Suprimmer l\'image
</div></div></form>';


$content .= '</div>
<div class="col p-0 m-0">
  <div class="text-center p-0 m-0 Gallery_container">
    <div class="row col_gap_20">  
      <div class="col p-0 m-0 col_width_408">
        <div class="p-0 m-0  anti_overflow_container_sm rounded ">';

if (!isset($data['Content'][0]['image_path'])) {
  $content .= '<img class="preview-selected-image shadow-1-strong rounded  anti_overflow_image_sm"/> alt="preview small';
} else {
  $content .= '<img src="' . $data['Content'][0]['image_path'] . '" class="preview-selected-image shadow-1-strong rounded  anti_overflow_image_sm" style="transform: translate(' . $data['Content'][0]['translate_x'] . '%, ' . $data['Content'][0]['translate_y'] . '%);" alt="' . $data['Content'][0]['name'] . '" />';
}

$content .= '</div> 
<div class="anti_overflow_container_xl rounded">';
if (!isset($data['Content'][0]['image_path'])) {
  $content .= '<img class="preview-selected-image shadow-1-strong rounded  anti_overflow_image_xl"/ alt="preview xl">';
} else {
  $content .= '<img src="' . $data['Content'][0]['image_path'] . '" class="preview-selected-image shadow-1-strong rounded  anti_overflow_image_xl" style="transform: translate(' . $data['Content'][0]['translate_x'] . '%, ' . $data['Content'][0]['translate_y'] . '%)" alt="' . $data['Content'][0]['name'] . '" />';
}
$content .= '</div>  
      </div>
    </div>
  </div>
</div>';



echo $content;
