<?php
require_once "connection.php";

class ModelPastDue{
    static public function mdlShowPastDue($user_id){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "pastdue_user"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due");

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE user_id = '$user_id'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlAccountChecker($account_no, $branch_name){
		
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE account_no = '$account_no' AND branch_name = '$branch_name'");
		$stmt -> execute();
        $total = $stmt->rowCount();
        if($total > 0){
            return "not";
        }else{
            return "ok";
        }
	}
    static public function mdlShowBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE full_name LIKE 'EMB%' OR full_name LIKE 'ELC%' OR full_name LIKE 'FCH%' OR full_name LIKE 'RLC%' ORDER BY full_name");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowEMBBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE full_name LIKE 'EMB%' ORDER BY full_name");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowFCHBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE full_name LIKE 'FCH%' ORDER BY full_name");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShoRLCBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE full_name LIKE 'RLC%' ORDER BY full_name");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlShoELCBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE full_name LIKE 'ELC%' ORDER BY full_name");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowReportTarget($full_name, $date){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `past_due_targets` WHERE date = '$date' AND branch_name = '$full_name'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlShowFilterPastDueReport($table, $dateFrom, $dateTo, $branch_name, $class){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE refdate >= '$dateFrom' AND refdate <= '$dateTo' AND class = '$class' AND branch_name = '$branch_name' ORDER BY last_name;");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlShowFilterAllClass($table, $branch_name, $class){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE class = '$class' AND branch_name = '$branch_name' ORDER BY last_name");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlGetDay1($full_name, $day1){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT *, SUM(credit) AS total_day1 FROM `past_due_ledger` WHERE date = '$day1' AND credit >= 0 AND branch_name = '$full_name';");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}
    static public function mdlGetDay2($full_name, $day2){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT *, SUM(credit) AS total_day1 FROM `past_due_ledger` WHERE date = '$day2' AND credit >= 0  AND branch_name = '$full_name';");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}


    static public function mdlGetBelow6($full_name, $day1, $day5){

	    $stmt = (new Connection)->connect()->prepare("SELECT *, SUM(credit) AS total_below6 FROM `past_due_ledger` a 
        INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE  a.date >= '$day1' 
        AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.credit >= 0 AND b.refdate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlGet6And1year($full_name, $day1, $day5){

	    $stmt = (new Connection)->connect()->prepare("SELECT *, SUM(credit) AS total_below6and1 FROM `past_due_ledger` a INNER JOIN past_due b ON a.account_no = b.account_no  AND a.branch_name = b.branch_name
        WHERE  a.date >= '$day1' AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.credit >= 0 AND b.refdate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        AND b.refdate < DATE_SUB(CURDATE(), INTERVAL 6 MONTH)");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}


    static public function mdlGetAbove1($full_name, $day1, $day5){

	    $stmt = (new Connection)->connect()->prepare("SELECT *, SUM(credit) AS total_above1  FROM `past_due_ledger` a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name
         WHERE  a.date >= '$day1' AND a.date <= '$day5' AND a.branch_name = '$full_name'
          AND a.credit >= 0 AND b.refdate <= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlGetCumTota($full_name, $minRange, $maxRange){

	    $stmt = (new Connection)->connect()->prepare("SELECT *, SUM(credit) AS total  FROM `past_due_ledger`
         WHERE  date >= '$minRange' AND date <= '$maxRange' AND credit >= 0 AND branch_name = '$full_name'
         ");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlShowPastDueTarget(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_targets ORDER BY `date`");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlShowPastDueLedger($account_no, $branch_name){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger WHERE account_no = '$account_no' AND branch_name ='$branch_name'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlGetID($account_no){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE account_no = '$account_no'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlGetAllPastDue($idClient){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE id = '$idClient'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

static public function mdlShowGetPrevBalance($branch_name1, $account_no, $dateFrom, $dateTo){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(debit) as total_debit, SUM(credit) as total_credit  FROM past_due_ledger WHERE branch_name = '$branch_name1' AND account_no = '$account_no' AND date <= '$dateFrom'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowGetDebitAndCredit($branch_name1, $account_no, $dateFrom, $dateTo){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(debit) as get_debit, SUM(credit) as get_credit  FROM past_due_ledger WHERE branch_name = '$branch_name1' 
        AND account_no = '$account_no' AND date >= '$dateFrom' AND date <= '$dateTo' ");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowIDLedger($id){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger WHERE id = '$id'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlShowIDTarget($id){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_targets WHERE id = '$id'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	
    static public function get_id($due_id)
    {
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();
        $sql = 'SELECT id 
                FROM past_due
                WHERE due_id = :due_id';
        $statement = $pdo->prepare($sql);
		$sql1 = 'SELECT id 
                FROM past_due ORDER BY id
                 Desc limit 1';
        $statement1 = $pdo->prepare($sql1);
		$statement1->execute();
		$row2 =$statement1->fetch(PDO::FETCH_ASSOC);


        $statement->bindParam(':due_id', $due_id, PDO::PARAM_STR);
        if ($statement->execute()) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row !== false ? $row2['id'] : false;
        }
        return false;
    }

    static public function mdlAddPastDue($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		     $branch_name =  $data["branch_name"];
            $account_no =  $data["account_no"];

            $due_id =  $data["due_id"];
            $full_id1= (new ModelPastDue)->get_id($due_id);
            $last_id = $full_id1 + 1;
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $due_id;
            }

            $check= (new ModelPastDue)->mdlAccountChecker($account_no, $branch_name);
        
            
            if($check == "ok"){

			$stmt = $pdo->prepare("INSERT INTO $table(due_id, user_id, branch_name, account_no, last_name, first_name, middle_name, balance,
             bank, class, status, refdate, age, address, type) VALUES
             (:due_id, :user_id, :branch_name, :account_no, :last_name, :first_name, :middle_name, :balance, :bank, :class, :status, :refdate,
             :age, :address, :type)");
		
            $stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
			$stmt->bindParam(":balance", $data["balance"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
			$stmt->bindParam(":class", $data["class"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
            $stmt->bindParam(":refdate", $data["refdate"], PDO::PARAM_STR);
            $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
            $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
		
		
			$stmt->execute();
			$pdo->commit();
           
			return "ok";
            $stmt->close();
	    	$stmt = null;
            }
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		
    }



    static public function mdlAddPastDueAccounts($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		
            $due_id =  $data["due_id"];
            $branch_name =  $data["branch_name"];
            $account_no =  $data["account_no"];
            $due_id =  $data["due_id"];
            $full_id1= (new ModelPastDue)->get_id($due_id);
            $last_id = $full_id1 + 1;
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $due_id;
            }
            $check= (new ModelPastDue)->mdlAccountChecker($account_no, $branch_name);
        
            
            if($check == "ok"){

        

			$stmt = $pdo->prepare("INSERT INTO $table(due_id, user_id, branch_name, last_name, first_name, middle_name, account_no, age,
              address, balance, type, class, bank, refdate) VALUES
             (:due_id, :user_id, :branch_name, :last_name, :first_name, :middle_name, :account_no, :age, :address, :balance,
             :type, :class, :bank, :refdate)");
		
            $stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
            $stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
            $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":balance", $data["balance"], PDO::PARAM_STR);
            $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
            $stmt->bindParam(":class", $data["class"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
            $stmt->bindParam(":refdate", $data["refdate"], PDO::PARAM_STR);
        
		
		
			$stmt->execute();
			$pdo->commit();
			return "ok";

            $stmt->close();
		    $stmt = null;
            }else{
                return "error2";  
            }

		}
        catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
    }


    static public function mdlAddLedger($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

            $amountToCheck = $data["amount"];
            if($amountToCheck < 0){
                $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, debit) VALUES
                (:user_id, :branch_name, :account_no, :date, :refno, :amount)");
            }else{
                $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, credit) VALUES
                (:user_id, :branch_name, :account_no, :date, :refno, :amount)");
            }
	
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
			$stmt->bindParam(":refno", $data["refno"], PDO::PARAM_STR);
            $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);

			$stmt->execute();
			$pdo->commit();
			return "ok";
 
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		$stmt->close();
		$stmt = null;
    }
    

    
static public function mdlEditPastDueAccount($table, $data){
    
    $branch_name =  $data["branch_name"];
    $account_no =  $data["account_no"];
    $chkAcc =  $data["chkAcc"];
    if($chkAcc == $account_no){
        $check = "ok";
    }else{
        $check= (new ModelPastDue)->mdlAccountChecker($account_no, $branch_name);
    }

    if($check == "ok"){

	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET last_name = :last_name, first_name = :first_name, middle_name = :middle_name,
    branch_name = :branch_name, account_no = :account_no, age = :age, address = :address, balance = :balance, type = :type,
    class = :class, bank = :bank, refdate = :refdate, date_change = :date_change WHERE id = :id");
    
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
    $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
    $stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
    $stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
    $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
    $stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
    $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
    $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
    $stmt->bindParam(":balance", $data["balance"], PDO::PARAM_STR);
    $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
    $stmt->bindParam(":class", $data["class"], PDO::PARAM_STR);
    $stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
    $stmt->bindParam(":refdate", $data["refdate"], PDO::PARAM_STR);
    $stmt->bindParam(":date_change", $data["date_change"], PDO::PARAM_STR);
	


	if($stmt->execute()){
		return "ok";
        $stmt->close();
	    $stmt = null;
	}else{
		return "error";
	}
    }else{
        return "error2";
    }
	

}


static public function mdlAddLedgerAccount($table, $data)
{
    try{
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();

        $amountToCheck = $data["amount"];
        if($amountToCheck < 0){
            $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, debit, pay_mis, include_week) VALUES
            (:user_id, :branch_name, :account_no, :date, :refno, :amount, :pay_mis, :include_week)");
        }else{
            $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, credit, pay_mis, include_week) VALUES
            (:user_id, :branch_name, :account_no, :date, :refno, :amount, :pay_mis, :include_week)");
        }
    
        $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":refno", $data["refno"], PDO::PARAM_STR);  
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        $stmt->bindParam(":pay_mis", $data["pay_mis"], PDO::PARAM_STR);
        $stmt->bindParam(":include_week", $data["include_week"], PDO::PARAM_STR);

    
        $stmt->execute();
        $pdo->commit();
        return "ok";

    }catch(PDOException $exception){
        $pdo->rollBack();
        return "error";     
    }
    $stmt->close();
    $stmt = null;
}


static public function mdlEditLedger($table, $data){

    $amountToCheck = $data["amount"];

    if($amountToCheck < 0){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET date = :date, refno = :refno, credit = '', debit = :amount, pay_mis = :pay_mis, include_week = :include_week WHERE id = :id");
    }else{
        $stmt = (new Connection)->connect()->prepare("UPDATE $table SET date = :date, refno = :refno, debit = '', credit = :amount, pay_mis = :pay_mis, include_week = :include_week WHERE id = :id");
    }
    
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);   
    $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
    $stmt->bindParam(":refno", $data["refno"], PDO::PARAM_STR);  
    $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
    $stmt->bindParam(":pay_mis", $data["pay_mis"], PDO::PARAM_STR);
    $stmt->bindParam(":include_week", $data["include_week"], PDO::PARAM_STR);


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;

}


    static public function mdlDeleteTarget($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $data, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlDeletePastdue($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $data, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlDeleteLedger($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $data, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlAddPastDueTarget($table, $data)
{
    try{
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();

        $stmt1 = (new Connection)->connect()->prepare("SELECT * FROM past_due_targets WHERE branch_name = :branch_name AND date = :date  LIMIT 1");
        $stmt1->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt1->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $result1 = $stmt1 ->execute();

        if($stmt1->rowCount()>0){
            return "error";
        }else{

        $stmt = $pdo->prepare("INSERT INTO $table(branch_name, date, amount) VALUES
         (:branch_name, :date, :amount)");
  
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        $stmt->execute();
        $pdo->commit();
        return "ok";
        }

    }catch(PDOException $exception){
        $pdo->rollBack();
        return "error";     
    }
    $stmt->close();
    $stmt = null;
}


static public function mdlEditTarget($table, $data){

    
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET branch_name = :branch_name, date = :date, amount = :amount WHERE id = :id");
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);   
    $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
    $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
    $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;

}


static public function mdlShowDuplicate(){
	

    $stmt = (new Connection)->connect()->prepare("SELECT branch_name, first_name, last_name, COUNT(*) AS duplication_count
    FROM past_due
    GROUP BY first_name, last_name
    HAVING COUNT(*) > 1 AND COUNT(DISTINCT branch_name) = COUNT(*);");

    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}


static public function mdlCheckLedger(){
	

    $stmt = (new Connection)->connect()->prepare("SELECT p.account_no, P.branch_name
    FROM past_due_ledger p
    LEFT JOIN past_due pd ON p.account_no = pd.account_no AND p.branch_name = pd.branch_name
    WHERE pd.account_no is null ORDER by p.branch_name");

    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}


static public function mdlShowAllLedger(){
    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlCheckFullyPaid($branch_name, $account_no){
    $stmt = (new Connection)->connect()->prepare("SELECT
    (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS total_balance,
    (SELECT SUM(debit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS total_debit,
      (SELECT SUM(credit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS total_credit,
    (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name' AND account_no = '$account_no') + 
    (SELECT SUM(debit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no')+ 
    (SELECT SUM(credit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS result;");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}
static public function mdlGetAllPDRPerBranch($selectedbranch_name){
    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE branch_name = '$selectedbranch_name'");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

}