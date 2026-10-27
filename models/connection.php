<?php

class Connection
{
	public function connect()
	{
		$host = getenv('DB_HOST') ?: 'mysql';
		$port = getenv('DB_PORT') ?: '3306';
		$database = getenv('DB_NAME') ?: 'emb_appform';
		$username = getenv('DB_USER') ?: 'emb_user';
		$password = getenv('DB_PASSWORD') ?: 'your_password';

		$link = new PDO(
			"mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
			$username,
			$password,
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			]
		);

		return $link;
	}
}