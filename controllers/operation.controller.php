<?php

class ControllerOperation{

    static public function ctrShowOperation($branch_name){
		$answer = (new ModelOperation)->mdlShowOperation($branch_name);
		return $answer;
	}

    static public function ctrGetGrossinBal($branch_name, $type){
		$answer = (new ModelOperation)->mdlGetGrossinBal($branch_name, $type);
		return $answer;
	}

	static public function ctrAddBeginningBalance(){
      
    if(isset($_POST["addBeginning"])){
        $table = "op_beginning_bal";
        $data = array("type"=>$_POST["type"],
        "date"=>$_POST["date"],
        "branch_name"=>$_POST["branch_name"],
        "amount"=>$_POST["amount"]);

            $answer = (new ModelOperation)->mdlAddBeginningBalance($table, $data);
            if($answer == "ok"){
            echo'<script>

            swal({
            type: "success",
            title: "Beginning Balance Succesfully Added!",
            showConfirmButton: true,
            confirmButtonText: "Ok"
            }).then(function(result){
                        if (result.value) {
                        window.location = "operations";
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

    static public function ctrAddGrossin(){
        if(isset($_POST['addGrossin'])){
            $table = "op_grossin";


            $data = array("branch_name"=>$_POST["branch_name"],
            "type"=>$_POST["type"],
            "walkin"=>$_POST["walkin"],
            "sales_rep"=>$_POST["sales_rep"],
            "returnee"=>$_POST["returnee"],
            "runners_agent"=>$_POST["runners_agent"],
            "transfer"=>$_POST["gros_transfer"],
            "date"=>$_POST["date"]);
    
            $answer = (new ModelOperation)->mdlAddGrossin($table, $data);
            if($answer == "ok"){
            echo'<script>

            swal({
            type: "success",
            title: "Record Succesfully Added!",
            showConfirmButton: true,
            confirmButtonText: "Ok"
            }).then(function(result){
                        if (result.value) {
                        window.location = "operations";
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
        static public function ctrAddOutGoing(){
            if(isset($_POST['addOutgoing'])){
                $table = "op_outgoing";
    
           
                
                $data = array("branch_name"=>$_POST["branch_name"],
                "type"=>$_POST["type"],
                "fully_paid"=>$_POST["fully_paid"],
                "deceased"=>$_POST["deceased"],
                "transfer"=>$_POST["transfer"],
                "gawad"=>$_POST["gawad"],
                "bad_accounts"=>$_POST["bad_accounts"],
                "date"=>$_POST["date"]);
    
        
                $answer = (new ModelOperation)->mdlAddOutgoing($table, $data);
                if($answer == "ok"){
                echo'<script>
    
                swal({
                type: "success",
                title: "Record Succesfully Added!",
                showConfirmButton: true,
                confirmButtonText: "Ok"
                }).then(function(result){
                            if (result.value) {
                            window.location = "operations";
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

    static public function ctrGetGrossinCumi($previousDate, $full_name){
        $answer = (new ModelOperation)->mdlGetGrossinCumi($previousDate, $full_name);
		return $answer;
    }
    static public function ctrGetOutgoingCumi($previousDate, $full_name){
        $answer = (new ModelOperation)->mdlGetOutgoingCumi($previousDate, $full_name);
		return $answer; 

    }

    static public function ctrShowGrossinIdOperation($id){
		$answer = (new ModelOperation)->mdlShowGrossinIdOperation($id);
		return $answer;
	}

    static public function ctrShowOutgoingIdOperation($id){
		$answer = (new ModelOperation)->mdlShowOutgoingIdOperation($id);
		return $answer;
	}

    static public function ctrEditGrossin(){

		if(isset($_POST["editGrossin"])){
			$table = "op_grossin";
						$data = array("id"=>$_POST["id"],
                                    "date"=>$_POST["date"],
									"walkin"=>$_POST["walkin"],
								"sales_rep"=>$_POST["sales_rep"],
								"returnee"=>$_POST["returnee"],
								"transfer"=>$_POST["gros_transfer"],
								"runners_agent"=>$_POST["runners_agent"]);
                

				$answer = (new ModelOperation)->mdlEditGrossin($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Record Update Succesfully!",
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
    static public function ctrEditOutGoing(){

		if(isset($_POST["editOutgoing"])){
			$table = "op_outgoing";
						$data = array("id"=>$_POST["id"],
                                    "date"=>$_POST["date"],
									"fully_paid"=>$_POST["fully_paid"],
								"deceased"=>$_POST["deceased"],
								"transfer"=>$_POST["transfer"],
								"gawad"=>$_POST["gawad"],
								"bad_accounts"=>$_POST["bad_accounts"]);
                

				$answer = (new ModelOperation)->mdlEditOutGoing($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Record Update Succesfully!",
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

    static public function ctrDeleteOperation(){
            if(isset($_GET['idClient']) && isset($_GET['type'])){

                $type = $_GET['type'];
                $id = $_GET['idClient'];
                if($type === "grossin"){
                    $table = "op_grossin";
                }elseif($type === "outgoing"){
                    $table = "op_outgoing";
                }
                
                $data = $_GET["idClient"];
            
                $answer = (new ModelOperation)->mdlDelete($table, $data);
                if($answer == "ok"){
                    
                    echo'<script>
    
                    swal({
                          type: "success",
                          title: "Record has been successfully deleted!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "operations";
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
        static public function ctrGetAllEMBBranches(){
            $answer = (new ModelOperation)->mdlShowEMBBranches();
            return $answer;
        }


        static public function ctrGetGrossinData($branch_name, $from, $to){
            $answer = (new ModelOperation)->mdlGetGrossinData($branch_name, $from, $to);
            return $answer;
        }

        static public function ctrGetOutgoingData($branch_name, $from, $to){
            $answer = (new ModelOperation)->mdlGetOutgoingData($branch_name, $from, $to);
            return $answer;
        }

        static public function ctrGetAllFCHBranches(){
            $answer = (new ModelOperation)->mdlGetAllFCHBranches();
            return $answer;
        }
        static public function ctrGetAllRLCBranches(){
            $answer = (new ModelOperation)->mdlGetAllRLCBranches();
            return $answer;
        }

        static public function ctrGetAllELCBranches(){
            $answer = (new ModelOperation)->mdlGetAllELCBranches();
            return $answer;
        }
        static public function ctrAddLSORBeginningBalance(){
      
            if(isset($_POST["addLSORBeginning"])){
                $table = "op_lsor_begin";
                $data = array("dateto"=>$_POST["dateto"],
                "datefrom"=>$_POST["datefrom"],
                "branch_name"=>$_POST["branch_name"],
                "amount"=>$_POST["amount"]);
                    $answer = (new ModelOperation)->mdlAddLSORBeginningBalance($table, $data);
                    if($answer == "ok"){
                    echo'<script>
                    swal({
                    type: "success",
                    title: "Beginning Balance Succesfully Added!",
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

            static public function ctrAddLSOR(){
      
                if(isset($_POST["add_lsor"])){
                    $table = "op_lsor";
                    $data = array("branch_name"=>$_POST["branch_name"],
                                "date"=>$_POST["date"],
                                "fin_stable"=>$_POST["fin_stable"],
                                "app_wc"=>$_POST["app_wc"],
                                "low_cashout"=>$_POST["low_cashout"],
                                "existing_loan"=>$_POST["existing_loan"],
                                 "other_resched_gawad"=>$_POST["other_resched_gawad"],
                                 "other_sched_gawad"=>$_POST["other_sched_gawad"],
                                 "sched_applynow"=>$_POST["sched_applynow"],
                                "ssp_overage"=>$_POST["ssp_overage"],
                                "lack_requirements"=>$_POST["lack_requirements"],
                                 "undecided"=>$_POST["undecided"],
                                 "refuse_transfer"=>$_POST["refuse_transfer"],
                                "inquired_only"=>$_POST["inquired_only"],
                                "new_policy"=>$_POST["new_policy"],
                                "not_goodcondition"=>$_POST["not_goodcondition"],
                                "guardianship"=>$_POST["guardianship"],
                                "plp"=>$_POST["plp"],
                                "not_qualified"=>$_POST["not_qualified"],
                                "eighteen_mos_sssloan"=>$_POST["eighteen_mos_sssloan"],
                                "on_process"=>$_POST["on_process"]);
            
                        $answer = (new ModelOperation)->AddLSOR($table, $data);
                        if($answer == "ok"){
                        echo'<script>
            
                        swal({
                        type: "success",
                        title: "Record Succesfully Added!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                        }).then(function(result){
                                    if (result.value) {
                                    window.location = "operationlsor";
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

                static public function ctrGetLSOR($branch_name, $currentDate){
                    $answer = (new ModelOperation)->mdlGetLSOR($branch_name, $currentDate);
                    return $answer;
                }

                static public function ctrGetBeginLSOR($branch_name){
                    $answer = (new ModelOperation)->mdlGetBeginLSOR($branch_name);
                    return $answer;
                }
                static public function ctrShowOperationLSOR($branch_name){
                    $table = "op_lsor";
                    $answer = (new ModelOperation)->mdlShowOperationLSOR($branch_name, $table);
                    return $answer;
                }

                static public function ctrGetBeginLSORReport($branch_name, $month){
                    $answer = (new ModelOperation)->mdlGetBeginLSORReport($branch_name, $month);
                    return $answer;
                }

                static public function ctrGetAllLSOR($branch_name, $firstDay, $lastDay){
                    $answer = (new ModelOperation)->mdlGetAllLSOR($branch_name, $firstDay, $lastDay);
                    return $answer;
                }


                static public function ctrEditLSOR(){
      
                    if(isset($_POST["edit_lsor"])){
                        $table = "op_lsor";
                        $data = array("id"=>$_POST["id"],
                                    "date"=>$_POST["date"],
                                    "fin_stable"=>$_POST["fin_stable"],
                                    "app_wc"=>$_POST["app_wc"],
                                    "low_cashout"=>$_POST["low_cashout"],
                                    "existing_loan"=>$_POST["existing_loan"],
                                     "other_resched_gawad"=>$_POST["other_resched_gawad"],
                                     "other_sched_gawad"=>$_POST["other_sched_gawad"],
                                     "sched_applynow"=>$_POST["sched_applynow"],
                                    "ssp_overage"=>$_POST["ssp_overage"],
                                    "lack_requirements"=>$_POST["lack_requirements"],
                                     "undecided"=>$_POST["undecided"],
                                     "refuse_transfer"=>$_POST["refuse_transfer"],
                                    "inquired_only"=>$_POST["inquired_only"],
                                    "new_policy"=>$_POST["new_policy"],
                                    "not_goodcondition"=>$_POST["not_goodcondition"],
                                    "guardianship"=>$_POST["guardianship"],
                                    "plp"=>$_POST["plp"],
                                    "not_qualified"=>$_POST["not_qualified"],
                                    "eighteen_mos_sssloan"=>$_POST["eighteen_mos_sssloan"],
                                    "on_process"=>$_POST["on_process"]);
                
                            $answer = (new ModelOperation)->mdlEditLSOR($table, $data);
                            if($answer == "ok"){
                            echo'<script>
                
                            swal({
                            type: "success",
                            title: "Record Succesfully Updated!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                            }).then(function(result){
                                        if (result.value) {
                                        window.location = "operationlsor";
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

                    static public function ctrDeleteLSOR(){
                        if(isset($_GET['idClient'])){
                         $table = "op_lsor";
                         $data = $_GET["idClient"];
                            $answer = (new ModelOperation)->mdlDelete($table, $data);
                            if($answer == "ok"){
                                echo'<script>
                
                                swal({
                                      type: "success",
                                      title: "Record has been successfully deleted!",
                                      showConfirmButton: true,
                                      confirmButtonText: "Ok"
                                      }).then(function(result){
                                                if (result.value) {
                                                window.location = "operationlsor";
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