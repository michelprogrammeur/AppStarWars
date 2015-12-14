<?php 


class Connect {
	
	public static $pdo = null;  //  persiste dans la classe Connect

	public static function set(array $database) {
		$options = [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		];

		self::$pdo = new PDO($database['dsn'], $database['username'], $database['password'], $options);
	}
}


// Connect::set([]);
// Connect::$pdo;