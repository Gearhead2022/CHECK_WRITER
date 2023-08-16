<?php

require_once "connection.php";

class ModelOperation{

    static public function mdlShowOperation($branch_name){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "pastdue_user"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT id, type, branch_name, date FROM op_grossin
            UNION ALL
            SELECT id, type, branch_name, date FROM op_outgoing");

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT id, type, branch_name, date FROM op_grossin WHERE branch_name = '$branch_name'
            UNION ALL
            SELECT id, type, branch_name, date FROM op_outgoing WHERE branch_name = '$branch_name'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlGetGrossinBal($branch_name, $type){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM op_beginning_bal WHERE branch_name = '$branch_name' AND type = '$type'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function get_user_id($chk_id)
		{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$sql = 'SELECT id 
					FROM checklist 
					WHERE chk_id = :chk_id';
			$statement = $pdo->prepare($sql);

			$statement->bindParam(':chk_id', $chk_id, PDO::PARAM_STR);
			if ($statement->execute()) {
				$row = $statement->fetch(PDO::FETCH_ASSOC);
				return $row !== false ? $row['id'] : false;
			}
			return false;
		}
	static public function mdlAddBeginningBalance($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, date, branch_name, amount) VALUES (:type, :date, :branch_name, :amount)");
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}
    static public function mdlAddGrossin($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, date, branch_name, walkin, sales_rep, returnee, runners_agent, transfer) 
        VALUES (:type, :date, :branch_name, :walkin, :sales_rep, :returnee, :runners_agent, :transfer)");
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":walkin", $data["walkin"], PDO::PARAM_INT);
        $stmt->bindParam(":sales_rep", $data["sales_rep"], PDO::PARAM_INT);
        $stmt->bindParam(":returnee", $data["returnee"], PDO::PARAM_INT);
        $stmt->bindParam(":runners_agent", $data["runners_agent"], PDO::PARAM_INT);
        $stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}
    static public function mdlAddOutgoing($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, date, branch_name, fully_paid, deceased, transfer, gawad, bad_accounts) 
        VALUES (:type, :date, :branch_name, :fully_paid, :deceased, :transfer, :gawad, :bad_accounts)");
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":fully_paid", $data["fully_paid"], PDO::PARAM_INT);
        $stmt->bindParam(":deceased", $data["deceased"], PDO::PARAM_INT);
        $stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_INT);
        $stmt->bindParam(":gawad", $data["gawad"], PDO::PARAM_INT);
        $stmt->bindParam(":bad_accounts", $data["bad_accounts"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


	static public function mdlGetGrossinCumi($previousDate, $full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT sum(walkin) + SUM(sales_rep) + SUM(returnee) + SUM(runners_agent) + SUM(transfer) as total_cumi 
		FROM `op_grossin` WHERE branch_name = '$full_name' AND date <= '$previousDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetOutgoingCumi($previousDate, $full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT sum(fully_paid) + SUM(deceased) + SUM(transfer) + SUM(gawad) + SUM(bad_accounts) as total_cumi 
		FROM `op_outgoing` WHERE branch_name = '$full_name' AND date <= '$previousDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowGrossinIdOperation($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_grossin` WHERE id = '$id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowOutgoingIdOperation($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_outgoing` WHERE id = '$id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlEditGrossin($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `date` = :date, walkin = :walkin, 
		sales_rep = :sales_rep, `returnee` = :returnee, `transfer` = :transfer, `runners_agent` = :runners_agent WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
		$stmt->bindParam(":walkin", $data["walkin"], PDO::PARAM_STR);
		$stmt->bindParam(":sales_rep", $data["sales_rep"], PDO::PARAM_STR);
		$stmt->bindParam(":returnee", $data["returnee"], PDO::PARAM_STR);
		$stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_STR);
		$stmt->bindParam(":runners_agent", $data["runners_agent"], PDO::PARAM_STR);
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}
	static public function mdlEditOutGoing($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `date` = :date, fully_paid = :fully_paid, 
		deceased = :deceased, `transfer` = :transfer, `gawad` = :gawad, `bad_accounts` = :bad_accounts WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
		$stmt->bindParam(":fully_paid", $data["fully_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":deceased", $data["deceased"], PDO::PARAM_STR);
		$stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_STR);
		$stmt->bindParam(":gawad", $data["gawad"], PDO::PARAM_STR);
		$stmt->bindParam(":bad_accounts", $data["bad_accounts"], PDO::PARAM_STR);
	
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}  
	static public function mdlDelete($table, $id){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
		$stmt ->bindParam(":id", $id, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}

	static public function mdlShowEMBBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'EMB%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlGetGrossinData($branch_name, $from, $to){
	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(walkin) as walkin, SUM(sales_rep) as sales_rep , SUM(returnee) as returnee, SUM(runners_agent) as runners_agent,
		SUM(transfer) as transfer FROM `op_grossin` WHERE branch_name = '$branch_name' AND date >= '$from' AND date <= '$to'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetOutgoingData($branch_name, $from, $to){
	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(fully_paid) as fully_paid, SUM(deceased) as deceased,
		 SUM(gawad) as gawad, SUM(bad_accounts) as bad_accounts,
		SUM(transfer) as transfer FROM `op_outgoing` WHERE branch_name = '$branch_name' AND date >= '$from' AND date <= '$to'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllFCHBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'FCH%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllRLCBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'RLC%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllELCBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'ELC%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}
	
	
}