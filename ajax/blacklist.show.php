
<?php
require_once "../models/connection.php";
require_once "../controllers/blacklist.controller.php";
require_once "../models/blacklist.model.php";
require_once "../views/modules/session.php";
$idClient = $_POST['idClient'];

$clients = (new Connection)->connect()->query("SELECT * FROM clients WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);

$first_name = $clients['first_name'];
$id = $clients['id'];
$middle_name = $clients['middle_name']; 
$last_name = $clients['last_name'];
$bank = $clients['bank'];
$account_number = $clients['account_number'];
$remarks = $clients['remarks'];
$status = $clients['status'];
$lending_firm = $clients['lending_firm'];
$upload_files = $clients['upload_files'];
$clientid = $clients['clientid'];
$img_name = "";
if($upload_files==""){
    $img_name ="profile.png";
}else{
    $img_name ="$upload_files";
}
$img = (new ControllerBlacklist)->ctrShowImg($clientid);

echo '<style>
.image-upload > input
{
    display: none;
}

.image-upload button
{
    width: 145px;
    cursor: pointer;
}</style>

<div class="row"><div class="col-sm-12"><a class="pop"><img class="profile-pic" src="views/files/'.$img_name.'" 
style="width: 15%;height: 116px;"></a>
<div class="image-upload">
    <label for="file-input">
       <p class="btn btn-light upload-button" >Change Profile</i></p>
    </label>';

    if($_SESSION['type']=="admin" ||  $_SESSION['type']=="bl_admin" ){
    echo'
    <input id="file-input" name="image[]" onchange="showDiv()" type="file"/>
    <input name="id" value="'.$id.'" type="text"/>';
    }
    echo'
</div>
</div></div>
<div class="row">
    <div id="actionDiv" style="display:none;" class="answer_list">
        <button class="btn btn-danger" type="submit" name="uploadProfile" id="uploadProfile">Save Profile</button>
        <button class="btn btn-info" type="cancel">Cancel</button>
    </div>
</div>
<div class="row mt-2"><div class="col-sm-4"><p>NAME</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$first_name.' '.$middle_name.' '.$last_name.'</p></div></div>
<div class="row"><div class="col-sm-4"><p>BANK</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$bank.'</p></div></div>
<div class="row"><div class="col-sm-4"><p>ACCOUNT NO.</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$account_number.'</p></div></div>
<div class="row"><div class="col-sm-4"><p>LENDING FIRM</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$lending_firm.'</p></div></div>
<div class="row"><div class="col-sm-4"><p>STATUS</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$status.'</p></div></div>
<div class="row"><div class="col-sm-4"><p>REMARKS</p></div><div class="col-sm-1"><p>:</p></div>
<div class="col-sm-7"><p>'.$remarks.'</p></div></div>
<div class="row"><div class="col-sm-12"><h6>Images</h6></div></div>
    <div class="row mt-2">';    foreach ($img as $key => $value) {
                            $img_name1 = $value["image_name"];
    echo' <div class="col-sm-1 mr-4"><a class="pop"><img src="views/files/'.$img_name1.'" 
    style="width: 95px; height: 95px; background-color: white;"></a></div>'; } echo' </div>';

    echo '<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="img_modal" style="width: 600px; background-color: white; margin-left: -34px;">              
      <div class="modal-body">
      	<button type="button" class="close" style="color: black; font-weight: bold; " id="x_modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%; height: 450px;" >
      </div>
    </div>
  </div>
</div>';
    echo"<script>
     $('.pop').click(function(){
        $('.imagepreview').attr('src', $(this).find('img').attr('src'));
        $('#imagemodal').modal('show');   
        })

        $('.close').click(function(){
        
            $('#imagemodal').modal('hide');   
            })
            function showDiv() {
                document.getElementById('actionDiv').style.display = 'block';
             }

             var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
              
                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
              
                    reader.readAsDataURL(input.files[0]);
                }
              }
              
        
        </script>";


   
