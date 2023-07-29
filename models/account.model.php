<?php

require_once "connection.php";

class ModelAccounts{

	static public function get_user_id($user_id)
		{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$sql = 'SELECT id 
					FROM accounts 
					WHERE user_id = :user_id';
			$statement = $pdo->prepare($sql);

			$statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
			if ($statement->execute()) {
				$row = $statement->fetch(PDO::FETCH_ASSOC);
				return $row !== false ? $row['id'] : false;
			}
			return false;
		}
	static public function mdlAddAccounts($table, $data){

		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
		$user_id =  $data["user_id"];
		$user_id1= (new ModelAccounts)->get_user_id($user_id);
		$last_id = $user_id1 + 1;
		$id_holder = "UI" . str_repeat("0",5-strlen($last_id)).$last_id;   
		if (!$user_id1) {
			$id_holder = $user_id;
		}

			$stmt1 = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE username = :username LIMIT 1");
			$stmt1->bindParam(":username", $data["username"], PDO::PARAM_STR);
			$result1 = $stmt1 ->execute();
			if($result1){
				$check = $stmt1->fetch(PDO::FETCH_ASSOC);
				if($stmt1->rowCount()>0){
					return "error";
				}else{
					$stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, user_id, full_name, username, password) VALUES (:type, :user_id, :full_name, :username, :password)");
					
					$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
					$stmt->bindParam(":user_id", $id_holder, PDO::PARAM_STR);
					$stmt->bindParam(":full_name", $data["full_name"], PDO::PARAM_STR);
					$stmt->bindParam(":username", $data["username"], PDO::PARAM_STR);
					$stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
					if($stmt->execute()){
						return "ok";
					}
					$stmt->close();
					$stmt = null;
				}
			}

		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}
	static public function mdlCheckAccounts($username, $password){
		
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE username = ? AND password = ? LIMIT 1");
			$result = $stmt ->execute([$username, $password]);
			if($result){
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount()>0){
				session_regenerate_id();
				$_SESSION['type']=$user['type'];
				$_SESSION['user_id']=$user['user_id'];
				$_SESSION['username']=$user['username'];
				$_SESSION['branch_name']=$user['full_name'];
				return "ok";


			}else{
				return "error";
			}
			$stmt->close();
			$stmt = null;
		}
	
}
static public function mdlEditAccounts($table, $data){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `type` = :type, full_name = :full_name, 
	username = :username, `password` = :password WHERE id = :id");
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
	$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
	$stmt->bindParam(":full_name", $data["full_name"], PDO::PARAM_STR);
	$stmt->bindParam(":username", $data["username"], PDO::PARAM_STR);
	$stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;

}	
static public function mdlShowAccount(){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE `status` = '0' ORDER BY id");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	

static public function mdlDelete($table, $data){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='1' WHERE id = :id");
	$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
	if($stmt -> execute()){
		return "ok";
	}else{
		return "error";	
	}
	$stmt -> close();
	$stmt = null;

}

	


	
}