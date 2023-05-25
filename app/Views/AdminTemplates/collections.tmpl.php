<?php

$content = '<div class="afterheader position-relative z-2"><div id="message"></div>
<form action="admin/post" id="formtab" method="post">
<h3 class="text-center mb-5">Enregistrer une nouvelle collection</h3> 
<label for="itemID">Modifier une collection existante</label>
<select id="itemID" name="id" class="form-select" aria-label="Default select example">
    <option selected value = "">Créer une nouvelle Collection</option>';

    foreach ($data["Collections"] as $item)
    {
      $content .='<option value="'.$item["id"] .'">'.$item["name"] . '</option>
      ';

    }
$content .= '</select><div class="form-group">
<label for="name">Nom</label>
<input type="text" id="name" name="name" class="form-control" >
</div>
<div class="form-group">
<label for="description">Description</label>
<textarea id="description" name="description" class="form-control" ></textarea>
</div>
<input type="hidden" name="tab" class="custom-file-input" id="tabName" value= "'. $data["Tab"]. '">
<input type="hidden" name="MYSHOP_CSRF_TOKEN_SESS_IDX" class="custom-file-input" id="MYSHOP_CSRF_TOKEN_SESS_IDX" value= "'.$_SESSION["MYSHOP_CSRF_TOKEN_SESS_IDX"]. '">
<div class ="col"> <button type="submit" name="submit" class="btn btn-primary btn-block mt-4 me-5 text-light">
  Enregistrer la collection
</button><div id="deleteBtn" class="btn btn-primary btn-block mt-4 text-light">
Suprimmer la collection
</div></div></form></div>';



echo $content;