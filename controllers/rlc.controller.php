<?php

class ControllerRlc{
    static public function ctrShowRlc(){
		$answer = (new ModelRlc)->mdlShowRlc();
		return $answer;
	}
    static public function ctrDeleteRlc(){
		if(isset($_GET["idClient"])){
			$table ="rlc_form";
			$data = $_GET["idClient"];
			$file_name1 = $_GET["file_name"];
			$id_num = $_GET["id_num"];
			$company = $_GET["company"];
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

			$answer = (new ModelFch)->mdlDeleteFch($table, $data);
			if($answer == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "Account has been successfully deleted!",
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