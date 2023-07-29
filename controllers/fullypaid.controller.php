<?php
// Connect to the MySQL database

class ControllerFullypaid{

    static public function ctrShowFullyPaid($user_id){
		$answer = (new ModelFullyPaid)->mdlShowFullyPaid($user_id);
		return $answer;
	}
	static public function ctrShowFilterReport($table, $startDateFormatted, $dateTotDateFormatted, $selectedValue){
		$answer = (new ModelFullyPaid)->mdlShowFilterReport($table, $startDateFormatted, $dateTotDateFormatted, $selectedValue);
		return $answer;
	}

	static public function addRecords(){
        if(isset($_POST['submit'])){
            $table = "fully_paid";
            $file = $_FILES['file']['tmp_name'];
            // Open the DBF file
       
            $dbf = dbase_open($file, 0);
         
            if ($dbf === false) {
                echo "Error opening DBF file";
                exit;
            }

             // Get the number of records in the file
    $num_records = dbase_numrecords($dbf);
    $id1 =  $_POST['id'];
 
    // Insert the records into the database
    for ($i = 1; $i <= $num_records; $i++) {
        $record = dbase_get_record($dbf, $i);
       
        if ($record !== false) {
            $last_id = $id1 + 1;
            $id_holder = "FP" . str_repeat("0",5-strlen($last_id)).$last_id;  

            $id = $record[0];
            $name =  str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record[1]));
            $out_date = $record[2];
            $bank = $record[3];
            $status = $record[4];
            $branch_name = $_POST['branch_name'];
            $user_id = $_POST['user_id'];
			$address = $record[8] . $record[9];
            $id1++;

            $data=array("full_id"=>$id_holder,
                        "fpid"=>$id,
                        "user_id"=>$user_id,
                        "name"=>$name,
                        "out_date"=>$out_date,
                        "bank"=>$bank,
                        "status"=>$status,
						"address"=>$address,
                        "branch_name"=>$branch_name
                       );
                        $answer = (new ModelFullyPaid)->mdlAddFullyPaid($table, $data);
                        if($answer == "ok"){
                            $chk = "ok";
                        }else{
                            $chk = "error";
                        }
        }
    } 
    if($chk == "ok"){
				
        echo'<script>

        swal({
              type: "success",
              title: "Records have been successfully added!",
              showConfirmButton: true,
              confirmButtonText: "Ok"
              }).then(function(result){
                        if (result.value) {
                        window.location = "fullypaid";
                        }
                    })
        </script>';
    }else if($chk == "error"){
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
    static public function ctrEditFullyPaid(){

		if(isset($_POST["edit_fullpaid"])){
			$table = "fully_paid";
						$data = array("id"=>$_POST["id"],
									"prrno"=>$_POST["prrno"],
								"prrdate"=>$_POST["prrdate"],
								"atm_status"=>$_POST["atm_status"],
								"date_claimed"=>$_POST["date_claimed"],
                                "remarks"=>$_POST["remarks"]);

				$answer = (new ModelFullyPaid)->mdlEditFullyPaid($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Records Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "fullypaid";
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

    static public function ctrDeleteRecord(){
		if(isset($_GET['idClient'])){
			$table = "fully_paid";
			$data = $_GET["idClient"];
		
			$answer = (new ModelFullyPaid)->mdlDelete($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "fullypaid";
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
    static public function ctrReport1FullyPaid(){

		if(isset($_POST["s_report1"])){
			$table = "fp_report1";
            $idClient = $_POST['idClient'];
			$full_id = $_POST['full_id'];
				$data = array("report_id1"=>$_POST["report_id1"],
								"full_id"=>$_POST["full_id"],
								"branch_name"=>$_POST["branch_name"],
								"branch_address"=>$_POST["branch_address"],
								"branch_tele"=>$_POST["branch_tele"],
                                "branch_phone"=>$_POST["branch_phone"],
                                "pens_name"=>$_POST["pens_name"],
                                "pens_address"=>$_POST["pens_address"],
                                "date_now"=>$_POST["date_now"],
                                "date_collect"=>$_POST["date_collect"],
                                "branch_avail"=>$_POST["branch_avail"],
                                "branch_head"=>$_POST["branch_head"]
                            );
				$answer = (new ModelFullyPaid)->mdlAddReport1($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Report Created Successfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "index.php?route=fullypaidreport1&idClient='.$idClient.'&full_id='.$full_id.'";
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

	static public function ctrEditReport1FullyPaid(){
		if(isset($_POST["e_report1"])){
		$table = "fp_report1";
            $idClient = $_POST['idClient'];
			$full_id = $_POST['full_id'];
				$data = array("report_id1"=>$_POST["report_id1"],
								"full_id"=>$_POST["full_id"],
								"branch_name"=>$_POST["branch_name"],
								"branch_address"=>$_POST["branch_address"],
								"branch_tele"=>$_POST["branch_tele"],
                                "branch_phone"=>$_POST["branch_phone"],
                                "pens_name"=>$_POST["pens_name"],
                                "pens_address"=>$_POST["pens_address"],
                                "date_now"=>$_POST["date_now"],
                                "date_collect"=>$_POST["date_collect"],
                                "branch_avail"=>$_POST["branch_avail"],
                                "branch_head"=>$_POST["branch_head"]
                            );
				$answer = (new ModelFullyPaid)->mdlEditReport1($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Report Update Successfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "index.php?route=fullypaidreport1&idClient='.$idClient.'&full_id='.$full_id.'";
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
	static public function ctrReport2FullyPaid(){

		if(isset($_POST["s_report2"])){
			$table = "fp_report2";
            $idClient = $_POST['idClient'];
			$full_id = $_POST['full_id'];
				$data = array("report_id2"=>$_POST["report_id2"],
								"full_id"=>$_POST["full_id"],
								"name"=>$_POST["name"],
								"address"=>$_POST["address"],
								"branch_name"=>$_POST["branch_name"],
								"branch_address"=>$_POST["branch_address"],
								"branch_tele"=>$_POST["branch_tele"],
                                "branch_phone"=>$_POST["branch_phone"],
                                "amount_up"=>$_POST["amount_up"],
                                "amount_promo"=>$_POST["amount_promo"],
                                "date_now"=>$_POST["date_now"],
                                "branch_ophead"=>$_POST["branch_ophead"]
                            );

						
				$answer = (new ModelFullyPaid)->mdlAddReport2($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Report Created Successfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "index.php?route=fullypaidreport2&idClient='.$idClient.'&full_id='.$full_id.'";
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

	static public function ctrEditReport2FullyPaid(){
		if(isset($_POST["e_report2"])){
		$table = "fp_report2";
            $idClient = $_POST['idClient'];
			$full_id = $_POST['full_id'];
					$data = array("report_id2"=>$_POST["report_id2"],
					"full_id"=>$_POST["full_id"],
					"name"=>$_POST["name"],
					"branch_name"=>$_POST["branch_name"],
					"branch_address"=>$_POST["branch_address"],
					"branch_tele"=>$_POST["branch_tele"],
					"branch_phone"=>$_POST["branch_phone"],
					"amount_up"=>$_POST["amount_up"],
					"amount_promo"=>$_POST["amount_promo"],
					"date_now"=>$_POST["date_now"],
					"branch_ophead"=>$_POST["branch_ophead"]
				);
				$answer = (new ModelFullyPaid)->mdlEditReport2($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Report Update Successfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "index.php?route=fullypaidreport2&idClient='.$idClient.'&full_id='.$full_id.'";
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
}