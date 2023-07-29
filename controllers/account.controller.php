<?php

class ControllerAccounts{
	static public function ctrCreateAccounts(){

		if(isset($_POST["signup"])){
			$table = "accounts";

				// $secretkey = "6LfxSZEeAAAAADedSqTHhvei0aZ9RUDolZB5dFu5";
				// $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretkey.'&response='.$_POST['g-recaptcha-response']);
				// $response = json_decode($verify);

				$data = array("type"=>$_POST["type"],
								"user_id"=>$_POST["user_id"],
								"full_name"=>$_POST["full_name"],
								"username"=>$_POST["username"],
								"password"=>$_POST["password"]);

				$answer = (new ModelAccounts)->mdlAddAccounts($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Account Registered Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "accounts";
									}
								})
					</script>';
				}elseif($answer == "error"){
					echo'<script>

					swal({
						type: "warning",
						title: "This username is already taken!",
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

	static public function ctrShowAccount(){
		$answer = (new ModelAccounts)->mdlShowAccount();
		return $answer;
	}

	static public function ctrEditAccount(){

		if(isset($_POST["editpass"])){
			$table = "accounts";
						$data = array("type"=>$_POST["type"],
									"id"=>$_POST["id"],
								"full_name"=>$_POST["full_name"],
								"username"=>$_POST["username"],
								"password"=>$_POST["password"]);

				$answer = (new ModelAccounts)->mdlEditAccounts($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Account Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "accounts";
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

	
	static public function ctrDeleteAccount(){
		if(isset($_GET['idClient'])){
			$table = "accounts";
			$data = $_GET["idClient"];
		
			$answer = (new ModelAccounts)->mdlDelete($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Account has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "accounts";
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