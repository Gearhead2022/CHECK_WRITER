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

    static public function mdlGetBeginningBal($full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM op_beginning_bal WHERE branch_name = '$full_name'");
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
	
	
}