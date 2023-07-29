<?php

class ControllerBackup{
    // static public function ctrShowPermit($user_id){
	// 	$answer = (new ModelPermit)->mdlShowPermit($user_id);
	// 	return $answer;
	// }
	static public function ctrShowBackup($user_id){
		$answer = (new ModelBackup)->mdlShowBackup($user_id);
		return $answer;
	}
	static public function ctrGetBackup($table, $data){
		$answer = (new ModelBackup)->mdlGetBackup($table, $data);
		return $answer;
	}
	

	static public function ctrGetAllBranch(){
		$answer = (new ModelBackup)->mdlGetAllBranch();
		return $answer;
	}

	static public function ctrCheckDate($date_now){
		$answer = (new ModelBackup)->mdlCheckDate($date_now);
		return $answer;
	}
	static public function ctrShowFilter($filter){
		$answer = (new ModelBackup)->mdlShowFilter($filter);
		return $answer;
	}
	static public function ctrShowFilterYear($filterYear, $branch_name){
		$answer = (new ModelBackup)->mdlShowFilterYear($filterYear, $branch_name);
		return $answer;
	}
	static public function ctrShowFilterMonth($filterYear, $branch_name, $filterMonth){
		$answer = (new ModelBackup)->mdlShowFilterMonth($filterYear, $branch_name,$filterMonth);
		return $answer;
	}
	static public function ctrShowBackupFiles($table, $backup_id){
		$answer = (new ModelBackup)->mdlShowFiles($table, $backup_id);
		return $answer;
		
	}

	static public function ctrCheckBackup($startDateFormatted){
		$answer = (new ModelBackup)->mdlCheckBackup($startDateFormatted);
		return $answer;
	}
    static public function ctrCreateBackup(){
		 
        if(isset($_POST["add_backup"])){

			
			$table ="backup";
			$table1 ="backup_files";
			$date_now = $_POST['wp_date'];
			$formatted_date = date("F d, Y", strtotime($date_now));
			$chk_date = (new ControllerBackup)->ctrCheckDate($date_now); 
			$subject1 = $_POST['subject'];

		
		

			// Remove special characters using preg_replace()
			$subject = preg_replace('/[^\w\s\r\n]/', '', $subject1);

			// Remove double spaces and line breaks using preg_replace()
			$subject = preg_replace('/\s+/', ' ', $subject);
		
			// Remove backslashes using str_replace()
			$subject = str_replace('\\', '', $subject);
		


		
			if(empty($chk_date)){
				
        $data = array("backup_id"=>$_POST['backup_id'],
                        "user_id"=>$_POST['user_id'],
						"subject"=>$subject,
						"wp_date"=>$_POST['wp_date'],
                        "branch_name"=>$_POST['branch_name']); 
                        $answer = (new ModelBackup)->mdlAddBackup($table, $data);
						 
		   	if($answer != "error"){
				$newBackup_id = $answer;
						
					// Set the upload directory
					$uploadDir = 'views/files/Backup/';

					// Retrieve the current year, month, and date
					$branch_name = $_POST["branch_name"];
					$year = date("Y", strtotime($date_now));
					$month = date("F", strtotime($date_now));
					$date = date("F j, Y", strtotime($date_now));
					

					// Create the directory structure if it does not exist
					if (!file_exists($uploadDir . $branch_name)) {
						mkdir($uploadDir . $branch_name);
					}
					if (!file_exists($uploadDir . $branch_name . '/' . $year)) {
						mkdir($uploadDir . $branch_name . '/' . $year);
					}
					if (!file_exists($uploadDir . $branch_name . '/' . $year . '/' . $month)) {
						mkdir($uploadDir . $branch_name . '/' . $year . '/' . $month);
					}
					if (!file_exists($uploadDir . $branch_name . '/' . $year . '/' . $month . '/' . $date)) {
						mkdir($uploadDir . $branch_name . '/' . $year . '/' . $month . '/' . $date);
					}
					foreach ($_FILES['image']['tmp_name'] as $key => $value) {
					

						$filename_img=$_FILES['image']['name'][$key];
						$filename_tmp=$_FILES['image']['tmp_name'][$key];
						$creattime=date('F j, Y');
						$finalimg='';
						
						$ext=pathinfo($filename_img,PATHINFO_EXTENSION);
						$targetFilePath = $uploadDir . $branch_name .'/' . $year . '/' . $month . '/' . $date . '/' . basename($filename_img);

						if(!file_exists($targetFilePath))
						{
						move_uploaded_file($filename_tmp, $targetFilePath);
						$finalimg=$filename_img;
						}else
						{
							$filename_img=str_replace('.','-',basename($filename_img,$ext));
							$newfilename=$filename_img.time().".".$ext;
							$targetFilePath = $uploadDir . $branch_name .'/' . $year . '/' . $month . '/' . $date . '/' . basename($newfilename);
							move_uploaded_file($filename_tmp, $targetFilePath);
							$finalimg=$newfilename;
						}
		
						$creattime=date('Y-m-d h:i:s');
						//insert
						if ($_FILES['image']['error'][0] != 4) {
						$data1 = array("user_id"=>$_POST["user_id"],
										"backup_id"=>$newBackup_id,
										"file_name"=>$finalimg,
										"add_time"=>$creattime);
									$answer1 = (new ModelBackup)->mdlAddBackupFiles($table1, $data1);
						}
				}
			
				echo'<script>

				swal({
					  type: "success",
					  title: "Backup has been successfully appended!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "backups";
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
		else{
			echo'<script>

			swal({
				  type: "warning",
				  title: "There is already a backup as of '.$formatted_date.'",
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


	static public function doneBackup(){
		if(isset($_GET['answer']) && isset($_GET['backup_id'])  ){
			$table = "backup";
			$backup_id = $_GET["backup_id"];
			$status = $_GET["status"];

			$data = array("backup_id"=>$backup_id,
			"status"=>$status);
			
			$answer = (new ModelBackup)->mdlDoneBackup($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Daily backup has been successfully received!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "backups";
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
	static public function ctrDeleteBackup(){
		if(isset($_GET["idClient"]) &&  isset($_GET["backup_id"]) ){
			$table ="backup";
			$table1 ="backup_files";
			$data = $_GET["idClient"];
			$backup_id = $_GET["backup_id"];
			$img =(new ControllerBackup)->ctrGetBackup($table, $data);

			$answer1 = (new ModelBackup)->mdlDeleteAll($table1, $backup_id);
			$answer = (new ModelBackup)->mdlDeleteBackup($table, $data);
			if($answer == "ok"){
				
		
			foreach ($img as $key => $value) {
				$branch_name = $value["branch_name"];
				$date_time = $value["date_time"];
				$year = date('Y', strtotime($date_time));
				$month = date('F', strtotime($date_time));
				$new_date = date('F j, Y',  strtotime($date_time));
				$folder_path = 'views/files/Backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$new_date.''; // Replace with the path to your folder

			}

			if (is_dir($folder_path)) {
				$files = glob($folder_path . '/*');
			 
				foreach($files as $file) {
				   if(is_file($file)) {
					  unlink($file);
				   }
				}
			 
				$success = rmdir($folder_path);
				if ($success) {
					echo'<script>
					swal({
						  type: "success",
						  title: "Backup has been successfully deleted!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {
									window.location = "backups";
									}
								})
					</script>';
				 } else {
					echo 'Unable to delete folder';
				 }
			} else {
				echo 'Folder does not exist';
			}

			}
				
		}
	}
	
	static public function ctrShowImg($table, $ref_id){
		$answer = (new ModelPermit)->mdlShowImg($table, $ref_id);
		return $answer;
		
	}
	

	static public function ctrDeleteImg(){
		if(isset($_GET["idClient"]) && isset($_GET["file_name"]) && isset($_GET["branch_name"]) ){
			$data = $_GET["file_id"];
			$branch_name = $_GET["branch_name"];
			$new_date = $_GET["new_date"];
			$table = "backup_files";
			$idClient = $_GET["idClient"];
			$file_name1 = $_GET["file_name"];
			$dateFormatted = date('F j, Y', strtotime($new_date));
			

			$answer = (new ModelBackup)->mdlDeleteImg($table, $data);
			if($answer == "ok"){
				$year = date('Y', strtotime($new_date));
				$month = date('F', strtotime($new_date));

				if($file_name1 !=""){
					$filename = 'views/files/Backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$dateFormatted.'/'.$file_name1;
					if (file_exists($filename)) {
						unlink($filename);
					}
				} 
				echo"<script>
				swal({
					  type: 'success',
					  title: 'The files have been successfully deleted!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=backupedit&idClient=$idClient';
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
	static public function ctrEditBackup(){
        if(isset($_POST["edit_backup"])){
			$table = "backup";

			$edit_date = $_POST['edit_date']; 
			$new_date = $_POST['new_date']; 
			$branch_name = $_POST["branch_name"];
			$oldYear = date('Y', strtotime($edit_date));
			$oldMonth = date('F', strtotime($edit_date));
			$oldDate = date("F j, Y", strtotime($edit_date));
			$formatted_date = date("F d, Y", strtotime($new_date));

			$subject1 = $_POST['subject'];
			// Remove special characters using preg_replace()
			$subject = preg_replace('/[^\w\s\r\n]/', '', $subject1);

			// Remove double spaces and line breaks using preg_replace()
			$subject = preg_replace('/\s+/', ' ', $subject);
			// Remove backslashes using str_replace()
			$subject = str_replace('\\', '', $subject);

			if($edit_date != $new_date){
				$chk_date = (new ControllerBackup)->ctrCheckDate($new_date); 
				if(empty($chk_date)){
					$result ="ok";
					$transfer ="yes";
				}else{
					$result ="error";
					$transfer ="no";
				}
			}else{
				$result ="ok";
				$transfer ="no";
			}

		

			if($result == "ok"){

			$data = array(
			"subject"=>$subject,
			"status"=>$_POST['status'],
			"new_date"=>$_POST['new_date'],
			"backup_id"=>$_POST['backup_id']); 

			$answer = (new ModelBackup)->mdlEditBackup($table, $data);
							
						 
		   	if($answer == "ok"){
				$table1 ="backup_files";
				// Set the upload directory
				$uploadDir = 'views/files/Backup/';
	
				// Retrieve the current year, month, and date
				$branch_name = $_POST["branch_name"];
				
	
				$year = date('Y', strtotime($new_date));
				$month = date('F', strtotime($new_date));
				$date = date("F j, Y", strtotime($new_date));


				
					// Handle the case where the file is empty
			
				
					foreach ($_FILES['image']['tmp_name'] as $key => $value) {
				
	
						$filename_img=$_FILES['image']['name'][$key];
						$filename_tmp=$_FILES['image']['tmp_name'][$key];
						$creattime=date('F j, Y');
						$finalimg='';
					
						$ext=pathinfo($filename_img,PATHINFO_EXTENSION);
						$targetFilePath = $uploadDir . $branch_name .'/' . $year . '/' . $month . '/' . $date . '/' . basename($filename_img);
		
						if(!file_exists($targetFilePath))
						{
						move_uploaded_file($filename_tmp, $targetFilePath);
						$finalimg=$filename_img;
						}else
						{
							$filename_img=str_replace('.','-',basename($filename_img,$ext));
							$newfilename=$filename_img.time().".".$ext;
							$targetFilePath = $uploadDir . $branch_name .'/' . $year . '/' . $month . '/' . $date . '/' . basename($newfilename);
							move_uploaded_file($filename_tmp, $targetFilePath);
							$finalimg=$newfilename;
						}
		
						$creattime=date('Y-m-d h:i:s');
						
						//insert	
						if ($_FILES['image']['error'][0] != 4) {
							$data1 = array("user_id"=>$_POST["user_id"],
										"backup_id"=>$_POST["backup_id"],
										"file_name"=>$finalimg,
										"add_time"=>$creattime);
									$answer1 = (new ModelBackup)->mdlAddBackupFiles($table1, $data1);
							// At least one file was selected
							// You can proceed with processing the files here
						} else {
							// No files were selected
							// You may want to display an error message to the user or handle the situation differently
						}
						
	
				
	
				
		}
			if($result == "ok" && $transfer == "yes") {
				// Set the original folder path, new folder name, and destination folder path

					$oldFolderPath = 'views/files/Backup/'.$branch_name.'/'.$oldYear.'/'.$oldMonth.'/'.$oldDate.'';
					$newFolderName = $formatted_date;
					// Set the upload directory
					$uploadDir = 'views/files/Backup/';

					// Retrieve the current year, month, and date
					$branch_name = $_POST["branch_name"];
					$newYear = date("Y", strtotime($new_date));
					$newMonth = date("F", strtotime($new_date));
					$newDate = date("F j, Y", strtotime($new_date));
					

					// Create the directory structure if it does not exist
					if (!file_exists($uploadDir . $branch_name)) {
						mkdir($uploadDir . $branch_name);
					}
					if (!file_exists($uploadDir . $branch_name . '/' . $newYear)) {
						mkdir($uploadDir . $branch_name . '/' . $newYear);
					}
					if (!file_exists($uploadDir . $branch_name . '/' . $newYear . '/' . $newMonth)) {
						mkdir($uploadDir . $branch_name . '/' . $newYear . '/' . $newMonth);
					}
					
					$destinationFolderPath = 'views/files/Backup/'.$branch_name.'/'.$newYear.'/'.$newMonth.'';

					// Rename the folder by replacing its name with the new folder name
					if (rename($oldFolderPath, dirname($oldFolderPath) . '/' . $newFolderName)) {
						// Create the destination folder if it does not exist
						if (!is_dir($destinationFolderPath)) {
							mkdir($destinationFolderPath);
						}
						// Move the renamed folder to the destination folder
						$newFolderPath = $destinationFolderPath . '/' . $newFolderName;
						if (rename(dirname($oldFolderPath) . '/' . $newFolderName, $newFolderPath)) {
							// Remove the old folder
						
							echo'<script>

								swal({
									type: "success",
									title: "Backup has been successfully updated!",
									showConfirmButton: true,
									confirmButtonText: "Ok"
									}).then(function(result){
												if (result.value) {
												window.location = "backups";
												}
											})
								</script>';
						} else {
							echo 'Error: Could not move folder to destination folder.';
						}
					} else {
						echo 'Error: Could not rename folder.';
					}

				
			}else{
				echo'<script>

				swal({
					  type: "success",
					  title: "Backup has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "backups";
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
			else{

				echo'<script>

			swal({
				  type: "warning",
				  title: "There is already a backup as of '.$formatted_date.'",
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
	static public function ctrDownloadFiles(){
		if(isset($_GET["idClient"]) && isset($_GET["file_name"]) && isset($_GET["new_date"])){
			
			$date = $_GET["new_date"];
			$branch_name = $_GET["branch_name"];
			$year = date('Y', strtotime($date));
			$month = date('F', strtotime($date));
			$file_name = $_GET["file_name"];
			$file_path = 'views/files/Backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$date.'/'.$file_name; // Set the path to the file
			 // Set the name of the file
			 // Set headers for file download
			 if(file_exists($file_path)){
				
			  header('Content-Type: image/jpeg');
			  header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
			  header('Content-Length: ' . filesize($file_path));
		
			 // Read and output the file contents
			 ob_end_clean();
			 readfile($file_path);
			 }else{
				echo "WALA GID";
			 }
		}
	}

}