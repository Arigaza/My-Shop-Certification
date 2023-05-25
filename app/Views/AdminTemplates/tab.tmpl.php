<?php


use MYSHOP\Controllers\MyShopController;


$content = '<div class="afterheaderadmin pb-5 row">
<div class="col"><div id="message"></div><form id="formtab" method="post" action="/admin/post" enctype="multipart/form-data">
  <h3 class="text-center mb-5">Enregistrer une nouvelle photo</h3> 
  <label for="collection-selector">Collections</label>
  <select id="collection-selector" class="form-select" aria-label="Default select example">
      <option selected value="">Pas dans une collection</option>';

      foreach ($data["Collections"] as $item)
      {
        $content .='<option value="'.$item["id"] .'">'.$item["name"] . '</option>
        ';

      }
      $content .= '</select>

      <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" class="form-control" >
      </div>
      <label for="sub_collection_selector">Sous-collection</label>
      <select id="sub_collection_selector" class="form-select" aria-label="Default select example">
          <option selected value="">Pas dans une sous-collection</option>';

          foreach ($data["Sub_collection_name"] as $item)
 {
 if (($item['sub_collection_name'] !== "" && $item['sub_collection_name'] !== null))
{
$content .= '<option value="' .$item["sub_collection_name"] .'">' .$item["sub_collection_name"] .'</option>';
}

 }

 $content .= ' </select>
 <div class="form-group">
   <label for="sub_collection_name">Sous-collection</label>
   <input type="text" id="sub_collection_name" name="sub_collection_name" class="form-control" >
 </div>
 <div class="form-group">
   <label for="description">Description</label>
   <textarea id="description" name="description" class="form-control" ></textarea>
 </div>

 <div class="form-group">
   <input id="collections_id" type="hidden" name="collections_id" class="form-control" >
 </div>
 <div class="form-group">
   <label for="description">Modifier l\'alignement de l\'image(Largeur)</label>
   <input type="range" min="-40" max="0" name="translate_x" id="image_translateX_selector" class="form-control" value="0">
 </div>
 <div class="form-group">
   <label for="description">Modifier l\'alignement de l\'image(hauteur)</label>
   <input type="range" min="-45" max="0" name="translate_y" id="image_translateY_selector" class="form-control" value="0">
 </div>
 <div class="custom-file mt-3">
   <input type="file" name="file" class="custom-file-input" id="chooseFile" accept="image/*" required>
   <label class="custom-file-label" for="chooseFile">Selectionner une image</label>
 </div>
 <input type="hidden" name="tab" class="custom-file-input" id="tabName" value= "'.$data["Tab"]. '">
 <input type="hidden" name="MYSHOP_CSRF_TOKEN_SESS_IDX" class="custom-file-input" id="MYSHOP_CSRF_TOKEN_SESS_IDX" value= "'.$_SESSION["MYSHOP_CSRF_TOKEN_SESS_IDX"]. '">
<button class="btn btn-primary btn-block mt-4 text-light">
     Enregistrer l\'image
 </button>
</form>

</div>
<div class="col p-0 m-0">
  <div class="text-center p-0 m-0 Gallery_container">
    <div class="row col_gap_20">  
      <div class="col p-0 m-0 col_width_408">
        <div class="p-0 m-0  anti_overflow_container_sm rounded ">
          <img class="preview-selected-image shadow-1-strong rounded  anti_overflow_image_sm"/>
        </div> 
        <div class="anti_overflow_container_xl rounded">
          <img class="preview-selected-image shadow-1-strong rounded  anti_overflow_image_xl"/>    
        </div>  
      </div>
    </div>
  </div>
</div></div>';
       


echo $content;


// @csrf
// @if ($message = Session::get('success'))

// @endif
// @if (count($errors) > 0)
// <div class="alert alert-danger">
//     <ul>
//         @foreach ($errors->all() as $error)
//           <li>{{ $error }}</li>
//         @endforeach
//     </ul>
// </div>
// @endif
?>

