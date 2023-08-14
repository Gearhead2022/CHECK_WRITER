<?php

class ControllerOperation{

    static public function ctrShowOperation($branch_name){
		$answer = (new ModelOperation)->mdlShowOperation($branch_name);
		return $answer;
	}

    static public function ctrGetBeginningBal($full_name){
		$answer = (new ModelOperation)->mdlGetBeginningBal($full_name);
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
            "transfer"=>$_POST["transfer"],
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
}