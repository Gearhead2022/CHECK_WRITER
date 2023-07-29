<?php

class ControllerRequest{
    static public function ctrShowRequest($user_id){
		$answer = (new ModelRequest)->mdlShowRequest($user_id);
		return $answer;
	}
	static public function ctrShowRequestAll(){
		$answer = (new ModelRequest)->mdlShowRequestAll();
		return $answer;
	}
	 
	 
	
     
    static public function ctrCreateRequest(){
		
        if(isset($_POST["add_request"])){
 
		
		 $subject_body =   $_POST['subject_body'];
		 $subject_body1 =nl2br($subject_body);
		 $chk_bys =   $_POST['chk_by'];
		 $chk_by =nl2br($chk_bys);

		 $chk_by1 =   $_POST['chk_by1'];
		 $chk_by11 =nl2br($chk_by1);
		 $chk_by2 =   $_POST['chk_by2'];
		 $chk_by22=nl2br($chk_by2);
		 $req_by1 =   $_POST['req_by'];
		 $req_by=nl2br($req_by1);
		 $rec_app1 =   $_POST['rec_app'];
		 $rec_app =nl2br($rec_app1);
		 $app_by1 =   $_POST['app_by'];
		 $app_by=nl2br($app_by1);
		 $branch1 =   $_POST['branch'];
		 $branch=nl2br($branch1);
        $table = "request_forms";
        $data = array("ref_id"=>$_POST['ref_id'],
						"user_id"=>$_POST['user_id'],
                        "to"=>$_POST['to'],
                        "address"=>$_POST['address'],
                        "req_by"=>$req_by,
                        "branch"=>$branch,
                        "date"=>$_POST['date'],
                        "subject"=>$_POST['subject'],
                        "subject_body"=>$subject_body1,
                        "chk_by"=>$chk_by,
                        "chk_by1"=>$chk_by11,
                        "chk_by2"=>$chk_by22,
                        "rec_app"=>$rec_app,
                        "app_by"=>$app_by); 
                        $answer = (new ModelRequest)->mdlAddRequest($table, $data);
							
						 
		   	if($answer == "ok"){
                $table1 ="permit_files";
                $extension=array('jpeg','jpg','png','gif');
    
            foreach ($_FILES['image']['tmp_name'] as $key => $value) {
                $filename_img=$_FILES['image']['name'][$key];
                $filename_tmp=$_FILES['image']['tmp_name'][$key];
                echo '<br>';
                $ext=pathinfo($filename_img,PATHINFO_EXTENSION);
    
                $finalimg='';
                if(in_array($ext,$extension))
                {
                    if(!file_exists('views/files/request/'.$filename_img))
                    {
                    move_uploaded_file($filename_tmp, 'views/files/request/'.$filename_img);
                    $finalimg=$filename_img;
                    }else
                    {
                        $filename_img=str_replace('.','-',basename($filename_img,$ext));
                        $newfilename=$filename_img.time().".".$ext;
                        move_uploaded_file($filename_tmp, 'views/files/request/'.$newfilename);
                        $finalimg=$newfilename;
                    }
                    $creattime=date('Y-m-d h:i:s');
                    //insert
                    
                    $data1 = array("ref_id"=>$_POST["ref_id"],
                                    "file_name"=>$finalimg,
                                    "image_time"=>$creattime);
                                $answer1 = (new ModelPermit)->mdlAddPermitImg($table1, $data1);
                
                }else
                {
                
                }
                
            }
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully appended!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "request";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	

        }
	}

	static public function ctrEditRequest(){
        if(isset($_POST["edit_request"])){
			
            $subject_body =   $_POST['subject_body'];
            $subject_body1 =nl2br($subject_body);
			$chk_bys =   $_POST['chk_by'];
			$chk_by =nl2br($chk_bys);
   
			$chk_by1 =   $_POST['chk_by1'];
			$chk_by11 =nl2br($chk_by1);
   
			$chk_by2 =   $_POST['chk_by2'];
			$chk_by22=nl2br($chk_by2);

			$req_by1 =   $_POST['req_by'];
			$req_by=nl2br($req_by1);
			$rec_app1 =   $_POST['rec_app'];
			$rec_app =nl2br($rec_app1);
			$app_by1 =   $_POST['app_by'];
			$app_by=nl2br($app_by1);
			$branch1 =   $_POST['branch'];
			$branch=nl2br($branch1);

           $table = "request_forms";
           $data = array("id"=>$_POST['id'],
                        "ref_id"=>$_POST['ref_id'],
                           "to"=>$_POST['to'],
                           "address"=>$_POST['address'],
                           "req_by"=>$req_by,
                           "branch"=>$branch,
                           "date"=>$_POST['date'],
                           "subject"=>$_POST['subject'],
                           "subject_body"=>$subject_body1,
                           "chk_by"=>$chk_by,
                           "chk_by1"=>$chk_by11,
                           "chk_by2"=>$chk_by22,
                           "rec_app"=>$rec_app,
                           "app_by"=>$app_by); 
                        $answer = (new ModelRequest)->mdlEditRequest($table, $data);
							
						 
		   	if($answer == "ok"){
                $table1 ="permit_files";
			$extension=array('jpeg','jpg','png','gif');

		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename_img=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename_img,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/request/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/request/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/request/'.$newfilename);
					$finalimg=$newfilename;
				}
				$creattime=date('Y-m-d h:i:s');
				//insert
				
				$data1 = array("ref_id"=>$_POST["ref_id"],
								"file_name"=>$finalimg,
								"image_time"=>$creattime);
							$answer1 = (new ModelPermit)->mdlAddPermitImg($table1, $data1);
			
			}else
			{
			
			}
			
		}

				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "request";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	

        }
	}
	static public function ctrDeleteRequest(){
		if(isset($_GET["idClient"]) && $_GET["ref_id"]){
			$table ="request_forms";
			$table1 ="permit_files";
			$data = $_GET["idClient"];
			$ref_id = $_GET["ref_id"];
            $img =(new ControllerRequest)->ctrShowImg($table1, $ref_id);
            foreach ($img as $key => $value) {
                $img_name = $value["file_name"];
                $img_name = 'views/files/request/'.$img_name;
                if (file_exists($img_name)){
                    unlink($img_name);
                }
            } 
		
			$answer1 = (new ModelPermit)->mdlDeleteAll($table1, $ref_id);
			$answer = (new ModelRequest)->mdlDeleteRequest($table, $data);
			if($answer == "ok"){

             

				echo'<script>
				swal({
					  type: "success",
					  title: "Request has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {
								window.location = "request";
								}
							})
				</script>';
			}		
		}
	}
	
	static public function ctrDone(){
		if(isset($_GET['idClient']) &&  isset($_GET['status'])){
			$table = "request_forms";
			$data = $_GET["idClient"];
		
			$answer = (new ModelRequest)->mdlDone($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "request";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	


		}

	}
	static public function ctrShowImg($table, $ref_id){
		$answer = (new ModelPermit)->mdlShowImg($table, $ref_id);
		return $answer;
		
	}
	static public function ctrDeleteImg($table){
		if(isset($_GET["idClient"]) && isset($_GET["img_name"]) ){
			$data = $_GET["img_name"];
			$idClient = $_GET["idClient"];
			$file_name1 = $_GET["img_name"];
			if($file_name1 !=""){
				$filename = 'views/files/request/'.$file_name1;
				if (file_exists($filename)) {
					unlink($filename);
				}
			} 
			$answer = (new ModelClients)->mdlDeleteImg($table, $data);
			if($answer == "ok"){
				
				echo"<script>
				swal({
					  type: 'success',
					  title: 'Image has been successfully deleted!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=requestedit&idClient=$idClient';
								}
							})
				</script>";
			}elseif($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}		
		}
	}	
	
	

}