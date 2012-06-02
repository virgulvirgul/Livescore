<?php


define('DB_DSN', 'mysql:host=localhost;dbname=livescore');
define('DB_LOGIN', 'last');
define('DB_PASSWORD', '475730');


class Config {
	private static  $_instanceOf = NULL;
	private $pdo;
	private function __construct() {
		try {
			$this->pdo = new PDO(DB_DSN, DB_LOGIN, DB_PASSWORD);
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	public static function getInstance() {
		if (self::$_instanceOf == NULL) {
			self::$_instanceOf = new Config();
		}
		return self::$_instanceOf;
	}
	public function getPDO() {
		return $this->pdo;
	}
	public function ololo{}
}
?>
