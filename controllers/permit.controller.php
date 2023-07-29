<?php

class ControllerPermits{
    static public function ctrShowPermit($user_id){
		$answer = (new ModelPermit)->mdlShowPermit($user_id);
		return $answer;
	}
	static public function ctrShowPermitAdmin(){
		$answer = (new ModelPermit)->mdlShowPermitAdmin();
		return $answer;
	}
	 
	
    
    static public function ctrCreatePermit(){
		
        if(isset($_POST["add_permit"])){

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
				if(!file_exists('views/files/permit/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/permit/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/permit/'.$newfilename);
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
		 $wp_req_for =   $_POST['wp_req_for'];
		 $wp_req_for1 =nl2br($wp_req_for);
		 $wp_req_by1 =   $_POST['wp_req_by'];
		 $wp_req_by =nl2br($wp_req_by1);
		 $wp_chk_by1 =   $_POST['wp_chk_by'];
		 $wp_chk_by =nl2br($wp_chk_by1);
        $table = "working_permit";
        $data = array("ref_id"=>$_POST['ref_id'],
                        "wp_to"=>$_POST['wp_to'],
                        "wp_from"=>$_POST['wp_from'],
                        "wp_date"=>$_POST['wp_date'],
                        "wp_req_for"=> $wp_req_for1,
                        "branch"=>$_POST['branch'],
                        "wp_req_by"=>$wp_req_by,
                        "wp_chk_by"=>$wp_chk_by,
                        "wp_app_by"=>$_POST['wp_app_by'],
						"user_id"=>$_POST['user_id'],
                        "wp_app_by1"=>$_POST['wp_app_by1']); 
                        $answer = (new ModelPermit)->mdlAddPermit($table, $data);
							
						 
		   	if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully appended!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
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


	static public function ctrEditPermit(){
        if(isset($_POST["edit_permit"])){
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
				if(!file_exists('views/files/permit/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/permit/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/permit/'.$newfilename);
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



		$wp_req_for =   $_POST['wp_req_for'];
		$wp_req_for1 =nl2br($wp_req_for);
		$wp_req_by1 =   $_POST['wp_req_by'];
		$wp_req_by =nl2br($wp_req_by1);
		$wp_chk_by1 =   $_POST['wp_chk_by'];
		$wp_chk_by =nl2br($wp_chk_by1);
        $table = "working_permit";
        $data = array("id"=>$_POST['id'],
						"ref_id"=>$_POST['ref_id'],
                        "wp_to"=>$_POST['wp_to'],
                        "wp_from"=>$_POST['wp_from'],
                        "wp_date"=>$_POST['wp_date'],
                        "wp_req_for"=>$wp_req_for1,
                        "branch"=>$_POST['branch'],
                        "wp_req_by"=>$wp_req_by,
                        "wp_chk_by"=>$wp_chk_by,
                        "wp_app_by"=>$_POST['wp_app_by'],
                        "wp_app_by1"=>$_POST['wp_app_by1']); 
                        $answer = (new ModelPermit)->mdlEditPermit($table, $data);
							
						 
		   	if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
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
	static public function ctrDeletePermit(){
		if(isset($_GET["idClient"]) && $_GET["ref_id"]){
			$table ="working_permit";
			$table1 ="permit_files";
			$data = $_GET["idClient"];
			$ref_id = $_GET["ref_id"];

			$img =(new ControllerPermits)->ctrShowImg($table1, $ref_id);
			foreach ($img as $key => $value) {
				$img_name = $value["file_name"];
				$img_name = 'views/files/permit/'.$img_name;
				if (file_exists($img_name)){
					unlink($img_name);
				}
			} 
			$answer1 = (new ModelPermit)->mdlDeleteAll($table1, $ref_id);
			$answer = (new ModelPermit)->mdlDeletePermit($table, $data);
			if($answer == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "Request has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
								}
							})
				</script>';
			}		
		}
	}
	
	static public function ctrDone(){
		if(isset($_GET['idClient']) &&  isset($_GET['status'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			$wp_remarks = $_GET["wp_remarks"];
		
			$answer = (new ModelPermit)->mdlDone($table, $data, $wp_remarks);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
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
				$filename = 'views/files/permit/'.$file_name1;
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
									window.location = 'index.php?route=workingpermitedit&idClient=$idClient';
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
	static public function ctrApprove(){
		if(isset($_GET['idClient']) &&  isset($_GET['user'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			$username = $_SESSION["username"];
			

			$answer = (new ModelPermit)->mdlApprove($table, $data, $username);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
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
	static public function ctrCheck(){
		if(isset($_GET['idClient']) &&  isset($_GET['chk'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			
			

			$answer = (new ModelPermit)->mdlCheck($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
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

	static public function addFolder(){
		if(isset($_POST['addFolder'])){
			$table = "employee_folder";
			// $folderid =   $_POST['folderid'];
			// $folder_name =   $_POST['folder_name'];
			// $id_num =   $_POST['id_num'];
			// $employee_name =   $_POST['employee_name'];
			// $company =   $_POST['company'];

		
        $data = array("folderid"=>$_POST['folderid'],
						"id_num"=>$_POST['id_num'],
                        "folder_name"=>$_POST['folder_name'],
                        "employee_name"=>$_POST['employee_name'],
                        "company"=>$_POST['company']); 
                        $answer = (new ModelPermit)->mdlAddFolder($table, $data);
							
						 
		   	if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Folder has been successfully added!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "";
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

	static public function editFolder(){
		if(isset($_POST['editFolder'])){
			$table = "employee_folder";
        $data = array("id"=>$_POST['folder_id'],
						"folder_name"=>$_POST['folder_name']); 
                        $answer = (new ModelPermit)->mdlEditFolder($table, $data);
							
						 
		   	if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Folder has been successfully modified!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "";
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
	
	static public function ctrShowFolders($id_num){
	$answer = (new ModelPermit)->mdlShowFolder($id_num);
	return $answer;

	}
	static public function ctrGetFolder($folderid){
		$answer = (new ModelPermit)->mdlGetFolder($folderid);
		return $answer;
	
		}
		
		static public function ctrGetfiles($folderid){
			$answer = (new ModelPermit)->mdlGetFiles($folderid);
			return $answer;
		
			}
	

		static public function ctrAddFiles(){
			if(isset($_POST['add_files'])){

				$answer="";
				$table1 ="employee_files";
				$extension=array('jpeg','jpg','png','gif');
	
			foreach ($_FILES['image']['tmp_name'] as $key => $value) {
				$filename=$_FILES['image']['name'][$key];
				$filename_tmp=$_FILES['image']['tmp_name'][$key];
				echo '<br>';
				$ext=pathinfo($filename,PATHINFO_EXTENSION);
	
				$finalimg='';
				if(in_array($ext,$extension))
				{
					if(!file_exists('views/files/employees/'.$filename))
					{
					move_uploaded_file($filename_tmp, 'views/files/employees/'.$filename);
					$finalimg=$filename;
					}else
					{
						$filename=str_replace('.','-',basename($filename,$ext));
						$newfilename=$filename.time().".".$ext;
						move_uploaded_file($filename_tmp, 'views/files/employees/'.$newfilename);
						$finalimg=$newfilename;
					}
					
					
					$data1 = array("folderid"=>$_POST["folderid"],
								"image_name"=>$finalimg
								);
								$answer1 = (new ModelPermit)->mdlAddImg($table1, $data1);
				
				}else
				{
				
				}
				
			}		 
			echo'<script>

			swal({
				  type: "success",
				  title: "Image has been successfully added!",
				  showConfirmButton: true,
				  confirmButtonText: "Ok"
				  }).then(function(result){
							if (result.value) {
							window.location = "";
							}
						})
			</script>';
			}
			
		  
		}


		static public function ctrDeleteFolder(){
			if(isset($_GET["folder_id"])){
				$table ="employee_folder";
				
				$company = $_GET["company"];
				$id_num = $_GET["id_num"];
				$employee_name = $_GET["employee_name"];
				$folder_id = $_GET["folder_id"];
				$folderid = $_GET["folderid"];
	
				$answer = (new ModelPermit)->mdlDeleteFolder($table, $folder_id,$folderid);
		
				if($answer == "ok"){
	
					echo"<script>
					swal({
						  type: 'success',
						  title: 'Folder has been successfully deleted!',
						  showConfirmButton: true,
						  confirmButtonText: 'Close'
						  }).then(function(result){
									if (result.value) {
										window.location = 'index.php?route=documentadd&company=$company&id_num=$id_num&employee_name=$employee_name';
									}
								})
					</script>";
				}		
			}
		}
		
		
	

}