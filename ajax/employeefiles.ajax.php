<?php

$folder_name = $_POST['folder_name'];
$folder_id = $_POST['folder_id'];


echo'
<input type="text" class="form-control" id="folder_name" placeholder="Enter Folder Name" value="'.$folder_name.'" name="folder_name" autocomplete="nope" required>
<input type="text" hidden  class="form-control" id="folder_id"  name="folder_id" value="'.$folder_id.'" autocomplete="nope">
';