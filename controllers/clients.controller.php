<?php

class ControllerClients{
	static public function ctrShowClients(){
		$answer = (new ModelClients)->mdlShowClients();
		return $answer;
		
	} 
	static public function ctrShowImg($company, $id_num){
		$answer = (new ModelClients)->mdlShowImg($company,$id_num );
		return $answer;
		
	}

	static public function ctrFilter(){
	
			if(isset($_POST["add_records"])){
				$emb = new ControllerClients();
				$emb -> ctrCreateClient();
			}
		
	}
	
	static public function ctrCreateClient(){	
			$type = $_POST['company'];
			$answer="";
			$table="";
			if($type == "EMB"){
				$table ="application_form";
			}elseif($type == "FCH"){
				$table ="fch_form";
			}elseif($type == "PSPMI"){
				$table ="pspmi_form";
			}elseif($type == "RLC"){
				$table ="rlc_form";
			}
			
			$table1 ="files";
			$extension=array('jpeg','jpg','png','gif');

		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename_img=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename_img,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/attachments/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/attachments/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/attachments/'.$newfilename);
					$finalimg=$newfilename;
				}
				$creattime=date('Y-m-d h:i:s');
				//insert
				
				$data1 = array("company"=>$_POST["company"],
								"id_num"=>$_POST["id_num"],
								"file_name"=>$finalimg,
								"image_time"=>$creattime);
							$answer1 = (new ModelClients)->mdlAddClientImg($table1, $data1);
			
			}else
			{
			
			}
			
		}
		
			if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0){
				$newExtension = 'jpg';
				  
				$target_dir = "views/files/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				$file_name = pathinfo($target_file, PATHINFO_FILENAME);

				$upload_files = $target_dir."/".$file_name.".".$newExtension;

				$new_file = $file_name.".".$newExtension;
				
				// $filename = $_FILES["fileToUpload"]["tmp_name"].'.'.$newExtension;
				
				// Check if file already exists
				// if (file_exists($target_file)) {
				//   echo " <script> alert('Sorry, file already exists.');</script>";
				//   $uploadOk = 0;
				// }
				
				// Check file size
				// if ($_FILES["fileToUpload"]["size"] > 500000) {
				//   echo "<script> alert('Sorry, your file is too large.');</script>";
				//   $uploadOk = 0;
				// }
				
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				  echo "  <script> alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
				  $uploadOk = 0;
				}
			  
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				  echo "<script> alert('Sorry, your file was not uploaded');</script>.";
				// if everything is ok, try to upload file
				} else {
				  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $upload_files)) {
					  
				  } else {
					echo "Sorry, there was an error uploading your file.";
				  }
				}
			}else{
				$new_file="";
			}


		   	$data = array("id_num"=>$_POST["id_num"],
						"fname"=>$_POST["fname"],
			  			 "mname"=>$_POST["mname"],
		   				  "lname"=>$_POST["lname"],
		   				  "company"=>$_POST["company"],
		   				  "blood_type"=>$_POST["blood_type"],
						  "birth_date"=>$_POST["birth_date"],
				          "home_address"=>$_POST["home_address"],
						  "sss_num"=>$_POST["sss_num"],
						  "tin_num"=>$_POST["tin_num"],
						  "phil_num"=>$_POST["phil_num"],
						  "pagibig_num"=>$_POST["pagibig_num"],
						  "date_hired"=>$_POST["date_hired"],
						  "status"=>$_POST["status"],
						  "em_fname"=>$_POST["em_fname"],
						  "em_mname"=>$_POST["em_mname"],
						  "em_lname"=>$_POST["em_lname"],
						  "em_phone"=>$_POST["em_phone"],
						  "em_address"=>$_POST["em_address"],
						  "upload_files"=>$new_file);
							
						  $answer = (new ModelClients)->mdlAddClient($table, $data);
							
						 
						  
						
		   


		   	if($answer == "ok"){
				if($type == "EMB"){
				echo'<script>

				swal({
					  type: "success",
					  title: "Account has been successfully appended!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "clients";
								}
							})
				</script>';
						}elseif($type == "FCH"){ 
							echo'<script>

							swal({
								  type: "success",
								  title: "Account has been successfully appended!",
								  showConfirmButton: true,
								  confirmButtonText: "Ok"
								  }).then(function(result){
											if (result.value) {
											window.location = "fch";
											}
										})
							</script>';

						}elseif($type == "PSPMI"){ 
							echo'<script>

							swal({
								  type: "success",
								  title: "Account has been successfully appended!",
								  showConfirmButton: true,
								  confirmButtonText: "Ok"
								  }).then(function(result){
											if (result.value) {
											window.location = "pspmi";
											}
										})
							</script>';

						}elseif($type == "RLC"){ 
							echo'<script>

							swal({
								  type: "success",
								  title: "Account has been successfully appended!",
								  showConfirmButton: true,
								  confirmButtonText: "Ok"
								  }).then(function(result){
											if (result.value) {
											window.location = "rlc";
											}
										})
							</script>';

						}
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
	static public function ctrDeleteClient(){
		if(isset($_GET["idClient"]) && $_GET["company"]){
			$table ="application_form";
			$data = $_GET["idClient"];
			$id_num = $_GET["id_num"];
			$company = $_GET["company"];
			$file_name1 = $_GET["file_name"];
			if($file_name1 !=""){
				$filename = 'views/files/'.$file_name1;
				if (file_exists($filename)) {
					unlink($filename);
				}
			}

			$img =(new ControllerClients)->ctrShowImg($company, $id_num);

			foreach ($img as $key => $value) {
				$img_name = $value["file_name"];
				$img_name = 'views/files/attachments/'.$img_name;
				if (file_exists($img_name)){
					unlink($img_name);
				}
			} 
			
			$answer1 = (new ModelClients)->mdlDeleteAll($company, $id_num);
			$answer = (new ModelClients)->mdlDeleteClient($table, $data);
			if($answer == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "Account has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {
								window.location = "clients";
								}
							})
				</script>';
			}		
		}
	}	
	static public function ctrEditClient(){
		if(isset($_POST["edit_save"])){
			$type = $_POST['company'];
			$table ="";
			if($type == "EMB"){
				$table = "application_form";
			}elseif($type == "FCH"){
				$table = "fch_form";
			}elseif($type == "PSPMI"){
				$table = "pspmi_form";
			}elseif($type == "RLC"){
				$table = "rlc_form";
			}
			$table1 ="files";
			$extension=array('jpeg','jpg','png','gif');
 
		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename_img=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename_img,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/attachments/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/attachments/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/attachments/'.$newfilename);
					$finalimg=$newfilename;
				}
				$creattime=date('Y-m-d h:i:s');
				//insert
				
				$data1 = array("company"=>$_POST["company"],
								"id_num"=>$_POST["id_num"],
								"file_name"=>$finalimg,
								"image_time"=>$creattime);
							$answer1 = (new ModelClients)->mdlAddClientImg($table1, $data1);
			
			}else
			{
			
			}
			
		}
		


			$to_change="";
			$file_name = $_POST['file_name'];
		
			   if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0){
				$upload_files = $_FILES["fileToUpload"]["name"];
				$to_change="true";
				$target_dir = "views/files/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				
				// Check if file already exists
				// if (file_exists($target_file)) {
				//   echo " <script> alert('Sorry, file already exists.');</script>";
				//   $uploadOk = 0;
				// }
				
				// // Check file size
				// if ($_FILES["fileToUpload"]["size"] > 500000) {
				//   echo "<script> alert('Sorry, your file is too large.');</script>";
				//   $uploadOk = 0;
				// }
				
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				  echo "  <script> alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
				  $uploadOk = 0;
				}
			  
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				  echo "<script> alert('The photo wasn't updated.');</script>.";
				// if everything is ok, try to upload file
				} else {
				  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					  
				  } else {
					echo "Sorry, there was an error uploading your file.";
				  }
				}
			}else{
				$upload_files=$file_name;
				$to_change="false";
			}
	
		   
			$data = array("id"=>$_POST["id"],
			"id_num"=>$_POST["id_num"],
			"fname"=>$_POST["fname"],
			   "mname"=>$_POST["mname"],
				 "lname"=>$_POST["lname"],
				 "company"=>$_POST["company"],
				 "blood_type"=>$_POST["blood_type"],
			  "birth_date"=>$_POST["birth_date"],
			  "home_address"=>$_POST["home_address"],
			  "sss_num"=>$_POST["sss_num"],
			  "tin_num"=>$_POST["tin_num"],
			  "phil_num"=>$_POST["phil_num"],
			  "pagibig_num"=>$_POST["pagibig_num"],
			  "date_hired"=>$_POST["date_hired"],
			  "status"=>$_POST["status"],
			  "em_fname"=>$_POST["em_fname"],
			  "em_mname"=>$_POST["em_mname"],
			  "em_lname"=>$_POST["em_lname"],
			  "em_phone"=>$_POST["em_phone"],
			  "em_address"=>$_POST["em_address"],
			  "upload_files"=>$upload_files);

					
		   	$answer = (new ModelClients)->mdlEditClient($table, $data);

		   	if($answer == "ok"){
				if($to_change=="true"){
					$filename = 'views/files/'.$file_name;
					if (file_exists($filename) &&  $file_name != $upload_files) {
						unlink($filename);
					}
				}if($type == "EMB"){ 

					echo'<script>
					swal({
						  type: "success",
						  title: "Account information has been successfully updated!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {
							  window.location = "clients";
							}
						})
					</script>';
				}elseif($type == "FCH"){
					echo'<script>
					swal({
						  type: "success",
						  title: "Account information has been successfully updated!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {
							  window.location = "fch";
							}
						})
					</script>';
				}elseif($type == "PSPMI"){
					echo'<script>
					swal({
						  type: "success",
						  title: "Account information has been successfully updated!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {
							  window.location = "pspmi";
							}
						})
					</script>';
				}elseif($type == "RLC"){
					echo'<script>
					swal({
						  type: "success",
						  title: "Account information has been successfully updated!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {
							  window.location = "rlc";
							}
						})
					</script>';
				}
					
			

			
			}
		}
	}
	static public function ctrDeleteImg(){
		if(isset($_GET["idClient"]) && isset($_GET["img_name"]) ){
			$table ="files";
			$data = $_GET["img_name"];
			$type = $_GET["type"];
			$idClient = $_GET["idClient"];
			$file_name1 = $_GET["img_name"];
			if($file_name1 !=""){
				$filename = 'views/files/attachments/'.$file_name1;
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
									window.location = 'index.php?route=clientedit&idClient=$idClient&type=$type';
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


	

	// static public function ctrLoanClient(){
	// 	if(isset($_POST["newAnnual"])){
	// 	   	$table = "clients";

	// 	   	$data = array("id"=>$_POST["idClient"],
	// 	   		          "cliendid"=>$_POST["editClientid"],
	// 			          "income"=>$_POST["newAnnual"],
	// 			          "loan"=>$_POST["newLoan"],
	// 			          "interest"=>$_POST["newInterest"],
	// 			          "top"=>$_POST["newTop"],
	// 	   	 			  "amt"=>$_POST["newAmount"],
	// 					  "due"=>$_POST["newDue"]);
						

	// 	   	$answer = (new ModelClients)->mdlLoanClient($table, $data);

	// 	   	if($answer == "ok"){
	// 			echo'<script>
	// 			swal({
	// 				  type: "success",
	// 				  title: "Loan information has been successfully updated!",
	// 				  showConfirmButton: true,
	// 				  confirmButtonText: "Close"
	// 				  }).then(function(result){
	// 					if (result.value) {
	// 					  window.location = "clients";
	// 					}
	// 				})
	// 			</script>';
	// 		}
	// 	}
	// }
		

	
	// static public function ctrPrint(){
	// 		$table = "clients";
	// 		$data = $_GET["category"];
	// 		$answer = (new ModelClients)->mdlPrint($table, $data);
	// 		return $answer;
	// }	

}

