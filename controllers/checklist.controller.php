<?php

class ControllerChecklist{
	static public function ctrCreateChecklist(){

		if(isset($_POST["addChecklist"])){
			$table = "checklist";

				// $secretkey = "6LfxSZEeAAAAADedSqTHhvei0aZ9RUDolZB5dFu5";
				// $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretkey.'&response='.$_POST['g-recaptcha-response']);
				// $response = json_decode($verify);

				$data = array("chk_date"=>$_POST["chk_date"],
								"chk_id"=>$_POST["chk_id"],
								"full_name"=>$_POST["full_name"]);

				$answer = (new ModelChecklist)->mdlAddChecklist($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Checklist Succesfully Created!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "checklist";
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
									window.location = "";
									}
								})
					</script>';
				}

		}
	}
 

	static public function ctrCreateChecklistReport(){

		if(isset($_POST["addChecklistReport"])){
			$table = "checklist_report";
			$chk_id = $_REQUEST["idClient"];
			$chk_date = $_REQUEST["chk_date"];
				// $secretkey = "6LfxSZEeAAAAADedSqTHhvei0aZ9RUDolZB5dFu5";
				// $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretkey.'&response='.$_POST['g-recaptcha-response']);
				// $response = json_decode($verify);

				$data = array("chk_id"=>$_POST["chk_id"],
								"chk_task"=>$_POST["chk_task"],
								"chk_prio"=>$_POST["chk_prio"],
								"chk_start"=>$_POST["chk_start"],
								"chk_end"=>$_POST["chk_end"],
								"chk_status"=>$_POST["chk_status"],
								"chk_notes"=>$_POST["chk_notes"]);

				$answer = (new ModelChecklist)->mdlAddChecklistReport($table, $data);

				if($answer == "ok"){

					echo"<script>
				swal({
					  type: 'success',
					  title: 'Checklist Report Succesfully Added!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=checklistadd&idClient=$chk_id&chk_date=$chk_date';
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
									window.location = "";
									}
								})
					</script>';
				}

		}
	}



	
	static public function ctrCheckAccounts(){
		if(isset($_POST["login"])){

		   	$username = $_POST["email"];
		   	$password = $_POST["password"];

		   	$answer = (new ModelAccounts)->mdlCheckAccounts($username, $password);
		   	if($answer == "ok"){

		   		$_SESSION['status'] = "true";
				$_SESSION['mode'] = "light";

				echo'<script>

				swal({
					  type: "success",
					  title: "Successfully Verified!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "index.php";
								}
							})
				</script>';
			}else{
				echo'<script>

				swal({
					  type: "warning",
					  title: "Incorrect Username and Password!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "index.php";
								}
							})
				</script>';

			}		

		
		   
		}
	
	}

	static public function ctrShowChecklist(){
		$answer = (new ModelChecklist)->mdlShowChecklist();
		return $answer;
	}
	static public function ctrShowChecklistID($id){
		$answer = (new ModelChecklist)->mdlShowChecklistID($id);
		return $answer;
	}
	

	static public function ctrShowChecklistReport($chk_id){
		$answer = (new ModelChecklist)->mdlShowChecklistReport($chk_id);
		return $answer;
	}
	static public function ctrShowChecklistReportID($chk_id,$id){
		$answer = (new ModelChecklist)->mdlShowChecklistReportID($chk_id,$id);
		return $answer;
	}

	static public function ctrCreateEditChecklist(){

		if(isset($_POST["editChecklist"])){
			$table = "checklist";
						$data = array("id"=>$_POST["id"],
								"chk_date"=>$_POST["chk_date"]);

				$answer = (new ModelChecklist)->mdlEditChecklist($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Checklist Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "checklist";
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
									window.location = "";
									}
								})
					</script>';
				}

		}
	}

	
	static public function ctrDeleteReport(){
		if(isset($_GET['id'])){
			$table = "checklist_report";
			$data = $_GET["id"];
			$chk_id = $_REQUEST["idClient"];
			$chk_date = $_REQUEST["chk_date"];
		
			$answer = (new ModelChecklist)->mdlDeleteReport($table, $data);
			if($answer == "ok"){
				
				echo"<script>
				swal({
					  type: 'success',
					  title: 'Checklist Report Succesfully Added!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=checklistadd&idClient=$chk_id&chk_date=$chk_date';
								}
							})
				</script>";
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


	static public function ctrCopyChecklistReport(){

		if(isset($_POST["copyChecklistReport"])){
			$table = "checklist_report";
			$chk_date = $_REQUEST["chk_date"];
			$chk_id_req = $_REQUEST["idClient"];
			$chk_id = $_POST["boxID"];

			$chk_data = $_POST["chk_data"];
			
			
			
	
			foreach ($chk_data as $id) {
				$copy = (new ControllerChecklist)->ctrShowChecklistReportID($chk_id, $id);
				foreach ($copy as $key => $row) {
					$data = array("chk_id"=>$chk_id_req,
									"chk_task"=>$row["chk_task"],
									"chk_prio"=>$row["chk_prio"],
									"chk_start"=>$row["chk_start"],
									"chk_end"=>$row["chk_end"],
									"chk_status"=>$row["chk_status"],
									"chk_notes"=>$row["chk_notes"]);
									$answer = (new ModelChecklist)->mdlAddChecklistReport($table, $data);
				}
		
				
				
			}
		
			

			

				if($answer == "ok"){

					echo"<script>
				swal({
					  type: 'success',
					  title: 'Checklist Report has been successfully copied!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=checklistadd&idClient=$chk_id_req&chk_date=$chk_date';
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
									window.location = "";
									}
								})
					</script>';
				}

		}
	}
	

	static public function ctrCreateEditChecklistReport(){

		if(isset($_POST["editChecklistReport"])){
			$chk_date = $_REQUEST["chk_date"];
			$chk_id_req = $_REQUEST["idClient"];
			$table = "checklist_report";

					$data = array("id"=>$_POST["id"],
					"chk_task"=>$_POST["chk_task"],
					"chk_prio"=>$_POST["chk_prio"],
					"chk_start"=>$_POST["chk_start"],
					"chk_end"=>$_POST["chk_end"],
					"chk_status"=>$_POST["chk_status"],
					"chk_notes"=>$_POST["chk_notes"]);;

				$answer = (new ModelChecklist)->mdlEditChecklistReport($table, $data);

				if($answer == "ok"){
					echo"<script>
				swal({
					  type: 'success',
					  title: 'Checklist Report has been successfully updated!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=checklistadd&idClient=$chk_id_req&chk_date=$chk_date';
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
									window.location = "";
									}
								})
					</script>';
				}

		}
	}

	static public function ctrDeleteChecklist(){
		if(isset($_GET['idClient'])){
			$table = "checklist";
			$data = $_GET["idClient"];
			$chk_id = $_GET["chk_id"];
		
			$answer = (new ModelChecklist)->mdlDeleteChecklist($table, $data, $chk_id);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Checklist has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "checklist";
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



}