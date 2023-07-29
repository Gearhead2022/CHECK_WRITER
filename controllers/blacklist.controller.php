<?php

class ControllerBlacklist{
	static public function ctrShowBlacklist(){
		$answer = (new ModelBlacklist)->mdlShowBlacklist();
		return $answer;
	}
	static public function ctrShowImg($clientid){
		
		$answer = (new ModelBlacklist)->mdlShowImg($clientid);
		return $answer;
	}
	static public function ctrLendingFirm(){
		$answer = (new ModelBlacklist)->mdlShowLendingFirm();
		return $answer;
	}
	static public function ctrCreateBlacklist(){	
		if(isset($_POST["add_records"])){
			$answer="";
			$table ="clients";
			$table1 ="images";
			$extension=array('jpeg','jpg','png','gif');

		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/'.$filename))
				{
				move_uploaded_file($filename_tmp, 'views/files/'.$filename);
				$finalimg=$filename;
				}else
				{
					$filename=str_replace('.','-',basename($filename,$ext));
					$newfilename=$filename.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/'.$newfilename);
					$finalimg=$newfilename;
				}
				$creattime=date('Y-m-d h:i:s');
				//insert
				
				$data1 = array("clientid"=>$_POST["clientid"],
							"image_name"=>$finalimg,
							"image_time"=>$creattime);
							$answer1 = (new ModelBlacklist)->mdlAddBlacklistImg($table1, $data1);
			
			}else
			{
			
			}
			
		}
		
		
		
		   	$data = array("first_name"=>$_POST["first_name"],
			  			 "clientid"=>$_POST["clientid"],
		   				  "middle_name"=>$_POST["middle_name"],
		   				  "last_name"=>$_POST["last_name"],
		   				  "bank"=>$_POST["bank"],
						  "account_number"=>$_POST["account_number"],
				          "remarks"=>$_POST["remarks"],
						  "status"=>$_POST["status"],
						  "lending_firm"=>$_POST["lending_firm"]);
							
						  $answer = (new ModelBlacklist)->mdlAddBlacklist($table, $data);
							
						 
		   	if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Account has been successfully appended!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "blacklist";
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

	

	static public function ctrDeleteImg(){
		if(isset($_GET["idClient"]) && isset($_GET["img_name"]) ){
			$table ="images";
			$data = $_GET["img_name"];
			$idClient = $_GET["idClient"];
			$file_name1 = $_GET["img_name"];
			if($file_name1 !=""){
				$filename = 'views/files/'.$file_name1;
				if (file_exists($filename)) {
					unlink($filename);
				}
			} 	
			$answer = (new ModelBlacklist)->mdlDeleteImg($table, $data);
			if($answer == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "Image has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {
									window.location = "index.php?route=blacklistedit&idClient="+'.$idClient.';
								}
							})
				</script>';
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
	static public function ctrDeleteBlacklist(){
		if(isset($_GET["idClient"])){
			$table ="clients";
			$table1 ="images";
			$data = $_GET["idClient"];
			$clientid = $_GET["clientid"];
			$file_name1 = $_GET["file_name"];
			if($file_name1 !=""){
				$filename = 'views/files/'.$file_name1;
				if (file_exists($filename)) {
					unlink($filename);
				}
			}
			
			$img =(new ControllerBlacklist)->ctrShowImg($clientid);

			foreach ($img as $key => $value) {
				$img_name = $value["image_name"];
				$img_name = 'views/files/'.$img_name;
				if (file_exists($img_name)){
					unlink($img_name);
				}
			} 
			 
			$answer1 = (new ModelBlacklist)->mdlDeleteAll($table1, $clientid);
			$answer = (new ModelBlacklist)->mdlDeleteBlacklist($table, $data);
			if($answer == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "Account has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {
								window.location = "blacklist";
								}
							})
				</script>';
			}		
		}
	}	

	static public function ctrChangeProfile(){
		if(isset($_POST["uploadProfile"])){
			$table = "clients";
			$extension=array('jpeg','jpg','png','gif');

		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/'.$filename))
				{
				move_uploaded_file($filename_tmp, 'views/files/'.$filename);
				$finalimg=$filename;
				}else
				{
					$filename=str_replace('.','-',basename($filename,$ext));
					$newfilename=$filename.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/'.$newfilename);
					$finalimg=$newfilename;
				}
				$data = array("id"=>$_POST["id"],
				"image_name"=>$finalimg);
				$answer = (new ModelBlacklist)->mdlChangeProfile($table, $data);
				if($answer == "ok"){
				
					echo'<script>
	
					swal({
						  type: "success",
						  title: "Image has been successfully appended!",
						  showConfirmButton: true,
						  confirmButtonText: "Ok"
						  }).then(function(result){
									if (result.value) {
									window.location = "blacklist";
									}
								})
					</script>';
				}
				
			
			}else
			{
				
			}
			
		}

		}
	}
	static public function ctrEditBlacklist(){
		if(isset($_POST["edit_save"])){
		  	 	$table = "clients";
			   $table1 ="images";
			   $extension=array('jpeg','jpg','png','gif');
   
		   foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			   $filename=$_FILES['image']['name'][$key];
			   $filename_tmp=$_FILES['image']['tmp_name'][$key];
			   echo '<br>';
			   $ext=pathinfo($filename,PATHINFO_EXTENSION);
   
			   $finalimg='';
			   if(in_array($ext,$extension))
			   {
				   if(!file_exists('views/files/'.$filename))
				   {
				   move_uploaded_file($filename_tmp, 'views/files/'.$filename);
				   $finalimg=$filename;
				   }else
	 			   {
					   $filename=str_replace('.','-',basename($filename,$ext));
					   $newfilename=$filename.time().".".$ext;
					   move_uploaded_file($filename_tmp, 'views/files/'.$newfilename);
					   $finalimg=$newfilename;
				   }
				   $creattime=date('Y-m-d h:i:s');
				   //insert
				   
				   $data1 = array("clientid"=>$_POST["clientid"],
							   "image_name"=>$finalimg,
							   "image_time"=>$creattime);
							   $answer1 = (new ModelBlacklist)->mdlAddBlacklistImg($table1, $data1);
			   
			   }else
			   {
			   
			   }
			   
		   }
			
		   	$data = array("id"=>$_POST["id"],
						"first_name"=>$_POST["first_name"],
		   				  "middle_name"=>$_POST["middle_name"],
		   				  "last_name"=>$_POST["last_name"],
		   				  "bank"=>$_POST["bank"],
						  "account_number"=>$_POST["account_number"],
				          "remarks"=>$_POST["remarks"],
						  "status"=>$_POST["status"],
						  "lending_firm"=>$_POST["lending_firm"]);

					
		   	$answer = (new ModelBlacklist)->mdlEditBlacklist($table, $data);

		   	if($answer == "ok"){
				

				echo'<script>
				swal({
					  type: "success",
					  title: "Account information has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
						if (result.value) {
						  window.location = "blacklist";
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

