<?php
error_reporting(E_ALL);
define('DB_DSN', 'mysql:host=localhost;');
define('DB_DSN_NEW', 'mysql:host=localhost;dbname=livescore');
define('DB_LOGIN', 'last');
define('DB_PASSWORD', '475730');
$flag = 0;
class CreateDBStructure {
	private $pdo;
	private $pdo1;
	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}
	public function deleteDB() {
		$deleteDB = "DROP DATABASE livescore";
		$delete_pdo = new PDO(DB_DSN, DB_LOGIN, DB_PASSWORD);
		if ($delete_pdo->exec($deleteDB)) echo "<div style='color:green'>База данных успешно удалена</div>";
		else throw new PDOException("<div style='color:res'>Невозможно удалить базу данных</div>");
	}
	public function createDB() {
		$createDB = "CREATE DATABASE IF NOT EXISTS livescore";
		if ($this->pdo->query($createDB)) echo "<div style='color:green'>База данных успешно создана</div>";
			else throw new PDOException("<div style='color:res'>Невозможно создать базу данных</div>");
		$this->pdo = null;
		$this->pdo1 = new PDO(DB_DSN_NEW, DB_LOGIN, DB_PASSWORD);
	}
	public function createTableContinents() {
		$continents = "CREATE TABLE IF NOT EXISTS continents (
								id_continent tinyint(2) primary key auto_increment,
								name varchar(100) NOT NULL)";
		if ($this->pdo1->query($continents)) $this->successToCreate("continents");
			else throw new PDOException($this->unnableToCreate("continents"));
	}
	public function createTableCountries() {
		$countries = "CREATE TABLE IF NOT EXISTS countries (
							id_country tinyint(3) primary key auto_increment,
							name varchar(100) NOT NULL, emblem varchar(200) NOT NULL, id_continent tinyint(2) NOT NULL)";
		if ($this->pdo1->query($countries)) $this->successToCreate("countries");
			else throw new PDOException($this->unnableToCreate("countries"));
	}
	public function createTableChampionships() {
		$championships = "CREATE TABLE IF NOT EXISTS championships (
						id_championship tinyint(4) primary key auto_increment,
						name varchar(100) NOT NULL, 
						id_country tinyint(3) NOT NULL,
						canPlayInternational tinyint(1) DEFAULT 0)";
			if ($this->pdo1->query($championships)) $this->successToCreate("championships");
		else throw new PDOException($this->unnableToCreate("championships"));
	}
	public function createTableTeams() {
		$teams = "CREATE TABLE IF NOT EXISTS teams (
					id_team int(8) primary key auto_increment,
					name varchar(100), id_championship varchar(10))";
		if ($this->pdo1->query($teams)) $this->successToCreate("teams");
		else throw new PDOException($this->unnableToCreate("teams"));
	}
	public function createTableStadiums() {
		$stadiums = "CREATE TABLE IF NOT EXISTS stadiums (
						id_stadium int(8) primary key auto_increment,
						name varchar(100) NOT NULL, 
						description text(400) NOT NULL,
						id_team int(8) NOT NULL)";
		if ($this->pdo1->query($stadiums)) $this->successToCreate("stadiums");
		else throw new PDOException($this->unnableToCreate("stadiums"));
	}
	public function createTablePlayers() {
		$players = "CREATE TABLE IF NOT EXISTS  players (
					id_player int(6) primary key auto_increment,
					player_name varchar(100) NOT NULL, 
					birth DATE NOT NULL )";
		if ($this->pdo1->query($players)) $this->successToCreate("players");
		else throw new PDOException($this->unnableToCreate("players"));
	}
	public function createTableTeamPlayers() {
		$team_players = "CREATE TABLE IF NOT EXISTS  team_players (
						id_team_player int(8) primary key auto_increment,
						id_player int(6) NOT NULL, 
						id_team int(6) NOT NULL, 
						player_number tinyint(2) NOT NULL, 
						player_position varchar(2) NOT NULL)";
		if ($this->pdo1->query($team_players)) $this->successToCreate("team_players");
		else throw new PDOException($this->unnableToCreate("team_players"));
	}
	public function createTableTeamGamePlayers() {
		////////Игроки на игре
		$team_game_players = "CREATE TABLE IF NOT EXISTS team_game_players (
								id_team_game_player int(8) primary key auto_increment,
								id_players varchar(100) NOT NULL, 
								red_card varchar (200) DEFAULT '',
								yellow_card varchar(200) DEFAULT '', 
								substitution varchar(200) DEFAULT '', 
								score varchar(100) DEFAULT '',
								id_game int(8) NOT NULL)";
		if ($this->pdo1->query($team_game_players)) $this->successToCreate("team_game_players");
		else throw new PDOException($this->unnableToCreate("team_game_players"));
	}
	public function createTableGames() {
		$games = "CREATE TABLE IF NOT EXISTS games (
										id_game int(8) primary key auto_increment,
										date DATETIME, 
										id_team_owner int(6) NOT NULL,
										id_team_guest int(6) NOT NULL, 
										score_owner varchar(2) DEFAULT '?',
										score_guest varchar(2) DEFAULT '?', 
										id_championship int(6) NOT NULL,
										tour tinyint(2) NOT NULL, 
										id_referee int(8) NOT NULL,
										id_stadium int(8) NOT NULL,
										more_info varchar(200) DEFAULT '')";
		if ($this->pdo1->query($games)) $this->successToCreate("games");
		else throw new PDOException($this->unnableToCreate("games"));
	}
	public function createTableUsers() {
		$users = "CREATE TABLE IF NOT EXISTS users (
						id_user tinyint(4) primary key auto_increment,
						login varchar(50), password varchar(200), superadmin tinyint(1))";
		if ($this->pdo1->query($users)) $this->successToCreate("users");
		else throw new PDOException($this->unnableToCreate("users"));
	}
	public function createTablePrivateMessagesInbox() {
		$privateMessagesInbox = "CREATE TABLE IF NOT EXISTS `private_messages_inbox` (
  				`id_private_message_inbox` int(11) NOT NULL auto_increment,
 				`id_user_send` int(11) NOT NULL,
 				`id_user_get` int(11) NOT NULL,
  				`theme` varchar(200) collate utf8_bin NOT NULL,
 				`text` text collate utf8_bin NOT NULL,
 				`date` datetime NOT NULL,
  				`isRead` tinyint(1) NOT NULL,
  					PRIMARY KEY  (`id_private_message_inbox`) )";
		if ($this->pdo1->query($privateMessagesInbox)) $this->successToCreate("privateMessagesInbox");
		else throw new PDOException($this->unnableToCreate("privateMessagesInbox"));
	}
	public function createTablePrivateMessagesOutbox() {
		$privateMessagesOutbox = "CREATE TABLE IF NOT EXISTS `private_messages_outbox` (
	  				`id_private_message_outbox` int(11) NOT NULL auto_increment,
	 				`id_user_send` int(11) NOT NULL,
	 				`id_user_get` int(11) NOT NULL,
	  				`theme` varchar(200) collate utf8_bin NOT NULL,
	 				`text` text collate utf8_bin NOT NULL,
	 				`date` datetime NOT NULL,
	  					PRIMARY KEY  (`id_private_message_outbox`) )";
		if ($this->pdo1->query($privateMessagesOutbox)) $this->successToCreate("privateMessagesOutbox");
		else throw new PDOException($this->unnableToCreate("privateMessagesOutbox"));
	}
	public function createTableReferees() {
		$referees = "CREATE TABLE IF NOT EXISTS referees (
													id_referee int(8) primary key auto_increment,
													first_name varchar(20) NOT NULL,
													last_name varchar(40) NOT NULL,
													birth DATE NOT NULL,
													id_country tinyint(2) NOT NULL)";
		if ($this->pdo1->query($referees)) $this->successToCreate("referees");
		else throw new PDOException($this->unnableToCreate("referees"));
	}
	private function unnableToCreate($str) {
		return "<p style='color:red'>Невозможно создать таблицу {<span style='color:blue'>".$str."</span>}</p>";
	}
	private function successToCreate($str) {
		echo "<div style='color:green'>Таблица {<span style='color:blue'>".$str."</span>} успешно создана</div>";
	}
}
try {
$pdo = new PDO(DB_DSN, DB_LOGIN, DB_PASSWORD);
$createStructure = new CreateDBStructure($pdo);
$createStructure->deleteDB();
$createStructure->createDB(); 
$createStructure->createTableContinents();
$createStructure->createTableCountries();
$createStructure->createTableChampionships();
$createStructure->createTableTeams();
$createStructure->createTablePlayers();
$createStructure->createTableTeamPlayers();
$createStructure->createTableTeamGamePlayers();
$createStructure->createTableGames();
$createStructure->createTableUsers();
$createStructure->createTablePrivateMessagesInbox();
$createStructure->createTablePrivateMessagesOutbox();
$createStructure->createTableReferees();
$createStructure->createTableStadiums();
}
catch (PDOException $e) {
	echo $e->getMessage();
}
?>

