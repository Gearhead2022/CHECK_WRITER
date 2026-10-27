<?php   
    class ControllerCheckWriter{

        static public function ctrShowAllBNKCHCKList($collDate, $branch_name){
            date_default_timezone_set('Asia/Manila');
        
            $dsn = "odbc:Database";
            $user = ''; // Leave blank if not required
            $password = ''; // Leave blank if not required
    
            try {
                // Open the ODBC connection
                $pdo = new PDO($dsn, $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $datenew = date('n/d/Y', strtotime($collDate));
    
                // Prepare and execute a query to select records from the DBF file
                $sql = "SELECT * FROM BNKCHCK WHERE CDATE = :datenew AND CHKSTAT = 'P'"; // Assuming the table name is 'bnkchck'
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':datenew', $datenew, PDO::PARAM_STR); // Bind parameter to avoid SQL injection
                $stmt->execute();
    
                // Fetch all records
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // print_r($records);

                // Loop through the result set
                return $records;
            } catch (PDOException $e) {
                // Handle connection errors
                echo '<script>
                    swal({
                        type: "warning",
                        title: "Failed to connect to ODBC data source: ' . $e->getMessage() . '",
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
        }

        static public function ctrShowBNKCHKDetails($docno, $cdate){
            
            $dsn = "odbc:Database";
            $user = ''; // Leave blank if not required
            $password = ''; // Leave blank if not required
    
            try {
                // Open the ODBC connection
                $pdo = new PDO($dsn, $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $datenew = date('n/d/Y', strtotime($cdate));
    
                    // Prepare and execute a query to select records from the DBF file
                $sql = "SELECT * FROM BNKCHCK WHERE CDATE = :datenew AND DOCNO = :docno"; // Assuming the table name is 'bnkchck'
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':datenew', $datenew, PDO::PARAM_STR); // Bind parameter to avoid SQL injection
                $stmt->bindParam(':docno', $docno, PDO::PARAM_STR);
                $stmt->execute();
    
                // Fetch all records
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // print_r($records);

                // Loop through the result set
                return $records;
            } catch (PDOException $e) {
                // Handle connection errors
                echo '<script>
                    swal({
                        type: "warning",
                        title: "Failed to connect to ODBC data source: ' . $e->getMessage() . '",
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

        }

        static public function ctrGetBankBalance($bnk_code){
            $answer = (new ModelCheckWriter)->mdlGetBankBalance($bnk_code);
            return $answer;
        }

        static public function ctrGetBankValue($bnk_name){
            $answer = (new ModelCheckWriter)->mdlGetBankValue($bnk_name);
            return $answer;
        }

    	static public function ctrAddBankBal(){
            if(isset($_POST['btnAddBankBal'])){
               
                $bnk_code = $_POST["bnk_code"];
			    $bnk_amount = $_POST["bnk_amount"]; 
            
                $bal = (new ModelCheckWriter)->mdlGetBankBalance($bnk_code);
                
                if (!empty($bal)) {
                    $prev_bal = $bal[0]['bnk_bal'];
                    $cur_bal = floatval($bnk_amount); // Replace 'propertyName' with the actual key name
                }else{
                    $prev_bal = '0';
                    $cur_bal = $bnk_amount;
                }

                $data = array("bnk_code"=>$bnk_code,
                        "bnk_bal"=>$cur_bal);
            $request = (new ModelCheckWriter)->mdlGetCheckID();
            if(empty($request)){
                $id = 0;
            }else{
                $id = $request[0]['id'];
            }
            $last_id = $id + 1;
            $id_holder = "BK" . str_repeat("0",5-strlen($last_id)).$last_id;     
                      
               $docno =$id_holder;
           
                self::ctrBnkChckLogs($bnk_code, $docno, $bnk_amount, $prev_bal, $cur_bal, 'Add Bank Balance');

                $answer = (new ModelCheckWriter)->mdlAddBankBalance($data);
                if($answer == "ok"){
                    echo'<script>
    
                    swal({
                          type: "success",
                          title: "Amount has been successfully Updated!",
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
                                        window.location = "";
                                    }
                                })
                    </script>';
    
                }	
            }
        }

        static public function ctrAddBank(){
            if(isset($_POST['btnAddBank'])){
               
                $data = array("bnk_code"=>$_POST["bnk_code1"],
                        "bnk_name"=>$_POST["bnk_name"],
                        "mnt_bal"=>$_POST["mnt_bal"]);

                $answer = (new ModelCheckWriter)->mdlAddBank($data);

                if($answer == "ok"){
                    
                    echo'<script>
                    swal({
                          type: "success",
                          title: "Bank has been successfully Added!",
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
                                        window.location = "";
                                    }
                                })
                    </script>';
    
                }	
    
    
            }
        }
        
        static public function ctrShowAllBank(){
            $answer = (new ModelCheckWriter)->mdlShowAllBank();
            return $answer;
        }

        static public function ctrDeductToBankAmountBalance($bnk_code, $bank_amt){
            $answer = (new ModelCheckWriter)->mdlDeductToBankAmountBalance($bnk_code, $bank_amt);
            return $answer;
        }

        //appended 06/04/24 //
       
        static public function ctrBnkChckLogs($bnkcd, $docno, $chkamt, $pres_bal, $pres_bal_left, $action){
            $answer = (new ModelCheckWriter)->mdlBnkChckLogs($bnkcd, $docno, $chkamt, $pres_bal, $pres_bal_left, $action);
            return $answer;
        }

        static public function ctrShowAllBNKCHCKLOGS(){
            $answer = (new ModelCheckWriter)->mdlShowAllBNKCHCKLOGS();
            return $answer;
        }

        
        static public function ctrCheckPrint($docno){
            $answer = (new ModelCheckWriter)->mdlCheckPrint($docno);
            return $answer;
        }


        static public function ctrCheckBankCheck($bnkcd){
            $answer = (new ModelCheckWriter)->mdlCheckBankCheck($bnkcd);
            return $answer;
        }

        static public function ctrUpdateBank($bnkcd, $update_balance){
            $answer = (new ModelCheckWriter)->ctrUpdateBank($bnkcd, $update_balance);
            return $answer;
        }

        static public function ctrUpdateCheckAmount($docno, $chkamt){
            $answer = (new ModelCheckWriter)->mdlUpdateCheckAmount($docno, $chkamt);
            return $answer;
        }

        static public function ctrBankUpdateLogs($data){
            $answer = (new ModelCheckWriter)->mdlBankUpdateLogs($data);
            return $answer;
        }

        static public function ctrGetLogsID($id){
            $answer = (new ModelCheckWriter)->mdlGetLogsID($id);
            return $answer;
        }


        static public function ctrUpdateBankStatus($id){
            $answer = (new ModelCheckWriter)->mdlUpdateBankStatus($id);
            return $answer;
        }

        static public function ctrShowAllBranches(){
            $answer = (new ModelCheckWriter)->mdlShowAllBranches();
            return $answer;
        }

        static public function ctrTransferBank(){
            if(isset($_POST["bnkTransfer"])){
                $table = "bnkchck";

                $bnkcd = $_POST["tbnkcd"];
                $getBalance = (new ControllerCheckWriter)->ctrCheckBankCheck($bnkcd);
                $balance = $getBalance[0]["bnk_bal"];
                $updatedBalance = $balance - $_POST["tchkamt"];


                $data = array("bnkcd"=>$_POST["tbnkcd"],
                            "payto"=>$_POST["tpayto"],
                            "branch_name"=>$_POST["tbranch_name"],
                            "docno"=>$_POST["tdocno"],
                            "chkamt"=>$_POST["tchkamt"],
                            "cdate"=>$_POST["tcdate"],
                            "remarks"=>$_POST["tremarks"],
                            "updatedBalance"=>$updatedBalance,
                            "prev_bal"=>$balance);
               
                          
                $answer = (new ModelCheckWriter)->mdlTransferBank($table, $data);

                if($answer == "ok"){
                    
                    echo'<script>
                    swal({
                          type: "success",
                          title: "Bank has been successfully Added!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                        window.location = "";
                                    }
                                })
                    </script>';
                }else{
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


        static public function ctrCancelBankUpdateLogs($data){
            $answer = (new ModelCheckWriter)->mdlCancelBankUpdateLogs($data);
            return $answer;
        }



        static public function ctrCheckDocno($docno){
            $answer = (new ModelCheckWriter)->mdlCheckDocno($docno);
            return $answer;
        }

        // added 06-27-24 //
        static public function ctrShowFilterTransaction($bnk_chck_from, $bnk_chck_to, $bnk_chck_bank){
            $answer = (new ModelCheckWriter)->mdlShowFilterTransaction($bnk_chck_from, $bnk_chck_to, $bnk_chck_bank);
            return $answer;
        }

        static public function ctrGetBegBal($prevDate, $bnkcd){
            $answer = (new ModelCheckWriter)->mdlGetBegBal($prevDate, $bnkcd);
            return $answer;
        }

        static public function ctrGetEndBal($curDate, $bnkcd){
            $answer = (new ModelCheckWriter)->mdlGetEndBal($curDate, $bnkcd);
            return $answer;
        }

        static public function ctrShowLiaisonList(){
            $answer = (new ModelCheckWriter)->mdlShowLiaisonList();
            return $answer;
        }

           static public function ctrAddNewLiaison(){
            if(isset($_POST["addLiaison"])){
                $table = "liaison_officers";

                $data = array("full_name"=>$_POST["full_name"],
                            "address"=>$_POST["address"],
                            "contact_no"=>$_POST["contact_no"],
                            "sex"=>$_POST["sex"],
                             "type_of_id"=>$_POST["type_of_id"],
                            "id_no"=>$_POST["id_no"],
                            "birth_date"=>$_POST["birth_date"],
                            "birth_place"=>$_POST["birth_place"],
                            "nationality"=>$_POST["nationality"],
                            "citizenship"=>$_POST["citizenship"],
                );
                $answer = (new ModelCheckWriter)->mdlAddNewLiaison($table, $data);

                if($answer == "ok"){
                    
                    echo'<script>
                    swal({
                          type: "success",
                          title: "Liaison has been successfully Added!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                        window.location = "";
                                    }
                                })
                    </script>';
                }else{
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

    static public function ctrGetLiaisonInfo($l_id){
        $answer = (new ModelCheckWriter)->mdlGetLiaisonInfo($l_id);
		return $answer; 
    }

     static public function ctrEditLiaison(){

		if(isset($_POST["editLiaison"])){
			$table = "liaison_officers";

            $data = array("l_id"=>$_POST["l_id"],
                "full_name"=>$_POST["full_name"],
                "address"=>$_POST["address"],
                "contact_no"=>$_POST["contact_no"],
                "sex"=>$_POST["sex"],
                "type_of_id"=>$_POST["type_of_id"],
                "id_no"=>$_POST["id_no"],
                "birth_date"=>$_POST["birth_date"],
                "birth_place"=>$_POST["birth_place"],
                "nationality"=>$_POST["nationality"],
                "citizenship"=>$_POST["citizenship"],
            );

            $answer = (new ModelCheckWriter)->mdlEditLiaison($table, $data);

            if($answer == "ok"){
                echo'<script>

                swal({
                    type: "success",
                    title: "Liaison info Updated Succesfully!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                    }).then(function(result){
                                if (result.value) {
                                window.location = "";
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

    static public function ctrDeleteLiaison(){
		if(isset($_GET["l_id"])){
			$table ="liaison_officers";
			$l_id = $_GET["l_id"];
			$answer = (new ModelCheckWriter)->mdlDeleteLiaison($table, $l_id);
			if($answer == "ok"){

				echo'<script>
				swal({
                    type: "success",
                    title: "Account has been successfully deleted!",
                    showConfirmButton: true,
                    confirmButtonText: "Close"
                    }).then(function(result){
                        if (result.value) {
                        window.location = "checkWriter";
                        }
                    })
				</script>';
			}		
		}
	}	

}
    