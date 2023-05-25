<div id="message"></div><h3 class="text-center mb-5 change_color_white">Enregistrer une nouvelle photo</h3>
<label for="homeImageIDSelector">Modifier une image existante</label>
<select id="homeImageIDSelector"  name="id" class="form-select" aria-label="Default select example">
    <option selected value = "">Créer une nouvelle Image d'accueil</option>';
   
   
   <?php foreach ($data["Content"] as $item)
    {
      $content .='<option value="'.$item["id"] .'">'.$item["name"] . '</option>
      ';

    }
    $content .='</select><form id="formtab" action="admin/post" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="change_color_white" for="name">Nom</label>
            <input type="text" id="name" name="name" class="form-control" >
        </div>
        <div class="form-group">
            <label class="change_color_white" for="description">Description</label>
            <textarea name="description" class="form-control" ></textarea>
        </div>
        <div class="custom-file">
            <input type="file" name="file" class="custom-file-input change_color_white" id="chooseFile" accept="image/*" required>
            <label class="custom-file-label change_color_white" for="chooseFile">Selectionner une image</label>
        </div>';
       
        if (isset($_GET['tabid'])) {
$content .= '<input id="itemID" type="hidden" name="id"  value= "' . $data['Content'][0]['id'] . '"> 
<input type="hidden" name="delete_image_path" id="delete_image_path" value= "' . $data['Content'][0]['image_path'] . '">';

        }
       
       $content .= '<input type="hidden" name="tab" class="custom-file-input" id="tabName" value= "'. $data["Tab"]. '">
        <input type="hidden" name="MYSHOP_CSRF_TOKEN_SESS_IDX" class="custom-file-input" id="MYSHOP_CSRF_TOKEN_SESS_IDX" value= "'.$_SESSION["MYSHOP_CSRF_TOKEN_SESS_IDX"]. '">
        <div class "col"> <button type="submit" name="submit" class="btn btn-primary btn-block mt-4 me-5 text-light">
        Enregistrer l\'image
      </button><div id="deleteBtn" class="btn btn-primary btn-block mt-4 text-light">
      Suprimmer l\'image
      </div></div></form>
</div> 
<div id="frontpagecontainer">
    <img id="preview-selected-home-image"  src=""/>
</div>';    
echo $content;
?>