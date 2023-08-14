<?php
// Connect to the MySQL database

class ControllerPastdue{

    static public function ctrShowPastDue($user_id){
		$answer = (new ModelPastDue)->mdlShowPastDue($user_id);
		return $answer;
	}
    static public function ctrShowBranches(){
		$answer = (new ModelPastDue)->mdlShowBranches();
		return $answer;
	}

	static public function ctrShowEMBBranches(){
		$answer = (new ModelPastDue)->mdlShowEMBBranches();
		return $answer;
	}

	static public function ctrShowFCHNBranches(){
		$answer = (new ModelPastDue)->mdlShowFCHNBranches();
		return $answer;
	}
	static public function ctrShowFCHMBranches(){
		$answer = (new ModelPastDue)->mdlShowFCHMBranches();
		return $answer;
	}

	static public function ctrShowFCHBranches(){
		$answer = (new ModelPastDue)->mdlShowFCHBranches();
		return $answer;
	}

	static public function ctrShowRLCBranches(){
		$answer = (new ModelPastDue)->mdlShoRLCBranches();
		return $answer;
	}
	static public function ctrShowELCBranches(){
		$answer = (new ModelPastDue)->mdlShoELCBranches();
		return $answer;
	}

    static public function ctrShowReportTarget($full_name, $date){
		$answer = (new ModelPastDue)->mdlShowReportTarget( $full_name, $date);
		return $answer;
	}

	static public function ctrShowFilterPastDueReport($table, $dateFrom, $dateTo, $branch_name, $class){
		$answer = (new ModelPastDue)->mdlShowFilterPastDueReport($table, $dateFrom, $dateTo, $branch_name, $class);
		return $answer;
	}

	static public function ctrShowFilterAllClass($table, $branch_name, $class){
		$answer = (new ModelPastDue)->mdlShowFilterAllClass($table, $branch_name, $class);
		return $answer;
	}

    static public function ctrGetDay1($full_name, $day1){
		$answer = (new ModelPastDue)->mdlGetDay1( $full_name, $day1);
		return $answer;
	}
    static public function ctrGetDay2($full_name, $day2){
		$answer = (new ModelPastDue)->mdlGetDay2( $full_name, $day2);
		return $answer;
	}

    static public function ctrGetDay3($full_name, $day2){
		$answer = (new ModelPastDue)->mdlGetDay2( $full_name, $day2);
		return $answer;
	}

	static public function ctrGetBelow6($full_name, $minRange, $day5){
		$answer = (new ModelPastDue)->mdlGetBelow6( $full_name, $minRange, $day5);
		return $answer;
	}
	static public function ctrGet6And1year($full_name, $minRange, $day5){
		$answer = (new ModelPastDue)->mdlGet6And1year( $full_name, $minRange, $day5);
		return $answer;
	}

	static public function ctrGetAbove1($full_name, $minRange, $day5){
		$answer = (new ModelPastDue)->mdlGetAbove1( $full_name, $minRange, $day5);
		return $answer;
	}

	static public function ctrGetCumTotal($full_name, $minRange, $maxRange){
		$answer = (new ModelPastDue)->mdlGetCumTota( $full_name, $minRange, $maxRange);
		return $answer;
	}

    static public function ctrShowPastDueTarget(){
		$answer = (new ModelPastDue)->mdlShowPastDueTarget();
		return $answer;
	}


    static public function ctrGetID($account_no){
		$answer = (new ModelPastDue)->mdlGetID($account_no);
		return $answer;
	}

	static public function ctrGetAllPastDue($idClient){
		$answer = (new ModelPastDue)->mdlGetAllPastDue($idClient);
		return $answer;
	}

	static public function ctrShowGetPrevBalance($branch_name1, $account_no, $dateFrom, $dateTo){
		$answer = (new ModelPastDue)->mdlShowGetPrevBalance($branch_name1, $account_no, $dateFrom, $dateTo);
		return $answer;
	}

	static public function ctrShowGetDebitAndCredit($branch_name1, $account_no, $dateFrom, $dateTo){
		$answer = (new ModelPastDue)->mdlShowGetDebitAndCredit($branch_name1, $account_no, $dateFrom, $dateTo);
		return $answer;
	}
 

    static public function ctrShowPastDueLedger($account_no, $branch_name){
		$answer = (new ModelPastDue)->mdlShowPastDueLedger($account_no, $branch_name);
		return $answer;
	}
    static public function ctrShowIDLedger($id){
		$answer = (new ModelPastDue)->mdlShowIDLedger($id);
		return $answer;
	}

    static public function ctrShowIDTarget($id){
		$answer = (new ModelPastDue)->mdlShowIDTarget($id);
		return $answer;
	}
	
	
	static public function addPastDueRecords(){
        if(isset($_POST['addPastDue'])){
            $table = "past_due";
            $file = $_FILES['file']['tmp_name'];
            // Open the DBF file
       
            $dbf = dbase_open($file, 0);
         
            if ($dbf === false) {
                echo'<script>

                swal({
                      type: "warning",
                      title: "Only DBF Files!",
                      showConfirmButton: true,
                      confirmButtonText: "Ok"
                      }).then(function(result){
                                if (result.value) {
                                    window.location = "";
                                }
                            })
                </script>';
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
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;  
            $user_id = $_POST['user_id'];
            $branch_name = $_POST['branch_name'];

            $account_no = $record[0];
            $last_name1 =  str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record[1]));
            $first_name = $record[2];
            $middle_name = $record[3];
            $balance = $record[4];
            $bank = $record[5];
            $class = $record[6];
            $status = $record[7];
            $refdate1 = $record[8];
            $age = $record[9];
            $address = str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record[10]));
            $type = $record[11];
            if(ctype_space($refdate1)){
				$refdate="";
			}else{
				$refdate = date("Y-m-d", strtotime($refdate1));
			}
          
			// Remove special characters using preg_replace()
		
			
			// Remove backslashes using str_replace()
			$last_name = str_replace('\\', '', $last_name1);

          
            $id1++;

            $data=array("due_id"=>$id_holder,
                        "account_no"=>$account_no,
                        "user_id"=>$user_id,
                        "branch_name"=>$branch_name,
                        "last_name"=>$last_name,
                        "first_name"=>$first_name,
                        "middle_name"=>$middle_name,
                        "balance"=>$balance,
                        "bank"=>$bank,
                        "class"=>$class,
						"status"=>$status,
                        "refdate"=>$refdate,
                        "age"=>$age,
                        "address"=>$address,
                        "type"=>$type
                       );
				if(ctype_space($account_no)){
					
				}else{
					$answer = (new ModelPastDue)->mdlAddPastDue($table, $data);
					if($answer == "ok"){
						$chk = "ok";
					}else{
						$chk = "error";
					}
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
                        window.location = "pastdue";
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

    static public function addLedgerRecord(){
        if(isset($_POST['addLedger'])){
            $table = "past_due_ledger";
            $file = $_FILES['file']['tmp_name'];
            // Open the DBF file
       
            $dbf = dbase_open($file, 0);
         
            if ($dbf === false) {
                echo'<script>

                swal({
                      type: "warning",
                      title: "Only DBF Files!",
                      showConfirmButton: true,
                      confirmButtonText: "Ok"
                      }).then(function(result){
                                if (result.value) {
                                    window.location = "";
                                }
                            })
                </script>';
                exit;
            }

             // Get the number of records in the file
    $num_records = dbase_numrecords($dbf);
 
 
    // Insert the records into the database
    for ($i = 1; $i <= $num_records; $i++) {
        $record = dbase_get_record($dbf, $i);

       
        if ($record !== false) {
            
        
            $user_id = $_POST['user_id'];
            $branch_name = $_POST['branch_name'];

            $account_no = $record[0];
            $date1 = $record[1];
            $refno = $record[2];
            $amount = $record[3];
			if(ctype_space($date1)){
				$date="";
			}else{
				$date = date("Y-m-d", strtotime($date1));
			}
           
         

            $data=array("account_no"=>$account_no,
                        "user_id"=>$user_id,
                        "branch_name"=>$branch_name,
                        "date"=>$date,
                        "refno"=>$refno,
                        "amount"=>$amount
                       );

					   if(ctype_space($account_no)){
					
					   }else{
							$answer = (new ModelPastDue)->mdlAddLedger($table, $data);
							if($answer == "ok"){
								$chk = "ok";
							}else{
								$chk = "error";
							}
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
                        window.location = "pastdue";
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


    static public function ctrAddPastDueAccounts(){
		if(isset($_POST["addPastDueAccount"])){
			$table = "past_due";
				$data = array(
					"due_id" =>$_POST["due_id"],
					"user_id" => $_POST["user_id"],
					"branch_name" => strtoupper($_POST["branch_name"]),
					"last_name" => strtoupper($_POST["last_name"]),
					"first_name" => strtoupper($_POST["first_name"]),
					"middle_name" => strtoupper($_POST["middle_name"]),
					"account_no" => $_POST["account_no"],
					"age" => $_POST["age"],
					"address" => strtoupper($_POST["address"]),
					"balance" => $_POST["balance"],
					"type" => strtoupper($_POST["type"]),
					"class" => strtoupper($_POST["class"]),
					"bank" => strtoupper($_POST["bank"]),
					"refdate" => $_POST["refdate"]
				);
			

                       

				$answer = (new ModelPastDue)->mdlAddPastDueAccounts($table, $data);

				if($answer == "ok"){

					echo"<script>
				swal({
					  type: 'success',
					  title: 'Past Due Account Successfully Added!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'pastdue';
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
				}elseif($answer == "error2"){
					echo'<script>

					swal({
						type: "warning",
						title: "There is already an account number '.$_POST['account_no'].' in '.$_POST['branch_name'].'!",
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

    static public function ctrEditPastDueAccounts(){

		if(isset($_POST["editPastDueAccount"])){
			$table = "past_due";
			$chkAcc = $_GET['account_no'];
				$data = array("chkAcc"=>$chkAcc,
								"id"=>$_POST["id"],
								"last_name"=>strtoupper($_POST["last_name"]),
								"first_name"=>strtoupper($_POST["first_name"]),
								"middle_name"=>strtoupper($_POST["middle_name"]),
                                "branch_name"=>$_POST["branch_name"],
								"account_no"=>$_POST["account_no"],
                                "age"=>$_POST["age"],
                                "address"=>strtoupper($_POST["address"]),
                                "balance"=>$_POST["balance"],
                                "type"=>strtoupper($_POST["type"]),
                                "class"=>strtoupper($_POST["class"]),
                                "bank"=>strtoupper($_POST["bank"]),
								"date_change"=>$_POST["date_change"],
                                "refdate"=>$_POST["refdate"]);
								

				
				$answer = (new ModelPastDue)->mdlEditPastDueAccount($table, $data);

				if($answer == "ok"){

					echo"<script>
				swal({
					  type: 'success',
					  title: 'Record Successfully Updated!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'pastdue';
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
				}elseif($answer == "error2"){
					echo'<script>

					swal({
						type: "warning",
						title: "There is already an account number '.$_POST['account_no'].' in '.$_POST['branch_name'].'!",
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



    static public function ctrAddLedger(){

		if(isset($_POST["addLedgerAccount"])){

			if(isset($_POST['pay_mis'])){
				$pay_mis = 1;
				
			}else{
				$pay_mis = 0;
			}

			if(isset($_POST['include_week'])){
				$include_week = 1;
				
			}else{
				$include_week = 0;
			}


			$table = "past_due_ledger";
                $id = $_REQUEST['idClient'];
				$data = array("user_id"=>$_POST["user_id"],
								"branch_name"=>$_POST["branch_name"],
                                "account_no"=>$_POST["account_no"],
                                "date"=>$_POST["date"],
                                "refno"=>$_POST["refno"],
								"pay_mis"=>$pay_mis,
								"include_week"=>$include_week,
                                "amount"=>$_POST["amount"]);

                       

				$answer = (new ModelPastDue)->mdlAddLedgerAccount($table, $data);

				if($answer == "ok"){

                    echo"<script>
                    swal({
                          type: 'success',
                          title: 'Record Succesfully Added!',
                          showConfirmButton: true,
                          confirmButtonText: 'Close'
                          }).then(function(result){
                                    if (result.value) {
                                        window.location = '';
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

    static public function ctrEditLedger(){

		if(isset($_POST["editLedgerAccount"])){
			$table = "past_due_ledger";

			
			if(isset($_POST['pay_mis'])){
				$pay_mis = 1;
				
			}else{
				$pay_mis = 0;
			}
			if(isset($_POST['include_week'])){
				$include_week = 1;
				
			}else{
				$include_week = 0;
			}

            $data = array( "id"=>$_POST["id"],
                            "date"=>$_POST["date"],
                             "refno"=>$_POST["refno"],
                            "amount"=>$_POST["amount"],
							"include_week"=>$include_week,
							"pay_mis"=>$pay_mis);

                       

				$answer = (new ModelPastDue)->mdlEditLedger($table, $data);

				if($answer == "ok"){

					echo"<script>
				swal({
					  type: 'success',
					  title: 'Ledger Successfully Updated!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = '';
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


    static public function ctrDeletePastdue(){
		if(isset($_GET['idClient'])){
			$table = "past_due";
			$data = $_GET["idClient"];
			
		
			$answer = (new ModelPastDue)->mdlDeletePastdue($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "pastdue";
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


    static public function ctrDeleteLedger(){
		if(isset($_GET['id'])){
			$table = "past_due_ledger";
			$data = $_GET["id"];
            $idClient = $_GET["idClient"];
            $account_no = $_GET["account_no"];
			
		
			$answer = (new ModelPastDue)->mdlDeleteLedger($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
                                    window.location = "index.php?route=ledger&idClient='.$idClient.'&account_no='.$account_no.'";
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

    
    static public function ctrAddPastDueTarget(){

		if(isset($_POST["addTarget"])){
			$table = "past_due_targets";
             
				$data = array("branch_name"=>$_POST["branch_name"],
                                "date"=>$_POST["date"],
                                "amount"=>$_POST["amount"]);

                       

				$answer = (new ModelPastDue)->mdlAddPastDueTarget($table, $data);

				if($answer == "ok"){

                    echo"<script>
                    swal({
                          type: 'success',
                          title: 'Record Succesfully Added!',
                          showConfirmButton: true,
                          confirmButtonText: 'Close'
                          }).then(function(result){
                                    if (result.value) {
                                        window.location = '';
                                    }
                                })
                    </script>";

				}elseif($answer == "error"){
					echo'<script>

					swal({
						type: "warning",
						title: "Targets have already been added for that branch name and date!",
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

    static public function ctrEditTarget(){

		if(isset($_POST["editTarget"])){
			$table = "past_due_targets";
            $data = array( "id"=>$_POST["id"],
                            "branch_name"=>$_POST["branch_name"],
                            "date"=>$_POST["date"],
                            "amount"=>$_POST["amount"]);

                       

				$answer = (new ModelPastDue)->mdlEditTarget($table, $data);

				if($answer == "ok"){

					echo"<script>
				swal({
					  type: 'success',
					  title: 'Record Successfully Updated!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = '';
								}
							})
				</script>";

				}elseif($answer == "error"){
					echo'<script>

					swal({
						type: "warning",
						title: "Targets have already been added for that branch name and date!",
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


    static public function ctrDeleteTarget(){
		if(isset($_GET['idClient'])){
			$table = "past_due_targets";
			$data = $_GET["idClient"];
			
		
			$answer = (new ModelPastDue)->mdlDeleteTarget($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "pastduetarget";
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

	static public function ctrShowDuplicate(){
		$answer = (new ModelPastDue)->mdlShowDuplicate();
		return $answer;
	}
	static public function ctrCheckLedger(){
		$answer = (new ModelPastDue)->mdlCheckLedger();
		return $answer;
	}
	static public function ctrShowAllLedger(){
		$answer = (new ModelPastDue)->mdlShowAllLedger();
		return $answer;
	}

	static public function ctrCheckFullyPaid($branch_name, $account_no){
		$answer = (new ModelPastDue)->mdlCheckFullyPaid($branch_name, $account_no);
		return $answer;
	}

	static public function ctrGetAllPDRPerBranch($selectedbranch_name){
		$answer = (new ModelPastDue)->mdlGetAllPDRPerBranch($selectedbranch_name);
		return $answer;
	}

	static public function ctrGetAllBadAccounts($branch_name, $lastMonth){
		$lastMonth = date("Y-m-d", strtotime($lastMonth));
		$answer = (new ModelPastDue)->mdlGetAllBadAccounts($branch_name, $lastMonth);
		return $answer;
	}


	static public function ctrDeletePastDueLedger(){
		if(isset($_GET['idClient'])){
			$table = "past_due_ledger";
			$data = $_GET["idClient"];

			$answer = (new ModelPastDue)->mdlDeleteLedger($table, $data);
			if($answer == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
									window.location = "pastdueledger";
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

	static public function ctrGetAllGoodToBad($branch_name, $month, $lastDay){
		$answer = (new ModelPastDue)->mdlGetGoodToBad($branch_name, $month, $lastDay);
		return $answer;
	}

	static public function ctrGetAllGoodToBad1($account_no, $branch_name, $refdate){
		$answer = (new ModelPastDue)->mdlGetGoodToBad1($account_no, $branch_name, $refdate);
		return $answer;
	}
	
	static public function ctrGetMiscellaneous($branch_name, $month, $lastDay){
		$answer = (new ModelPastDue)->mdlGetMiscellaneous($branch_name, $month, $lastDay);
		return $answer;
	}

	static public function ctrGetPDRWrittenOff($branch_name, $month, $lastDay){
		$answer = (new ModelPastDue)->mdlGetPDRWrittenOff($branch_name, $month, $lastDay);
		return $answer;
	}
	static public function ctrGetFullyPaid($branch_name, $month, $lastDay){
		$answer = (new ModelPastDue)->mdlGetFullyPaid($branch_name, $month, $lastDay);
		return $answer;
	}


    
}