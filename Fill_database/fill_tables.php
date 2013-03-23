<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
$start_time = microtime(true);
error_reporting(E_ALL);
define('DB_DSN', 'mysql:host=localhost;dbname=livescore');
define('DB_LOGIN', 'last');
define('DB_PASSWORD', '475730');

$flag = 0;
class FillTables {
	private $pdo;
	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}
	public function truncateAll() {
		$query1 = "TRUNCATE TABLE continents";
		$query2 = "TRUNCATE TABLE countries";
		$query3 = "TRUNCATE TABLE championships";
		$query4 = "TRUNCATE TABLE teams";
		$query5 = "TRUNCATE TABLE users";
		$query6 = "TRUNCATE TABLE players";
		$query7 = "TRUNCATE TABLE team_players";
		$query8 = "TRUNCATE TABLE referees";
		if (! $this->pdo->query($query1)) throw new PDOException($this->unnableToInsert("truncate continents"));
		if (! $this->pdo->query($query2)) throw new PDOException($this->unnableToInsert("truncate countries"));
		if (! $this->pdo->query($query3)) throw new PDOException($this->unnableToInsert("truncate championships"));
		if (! $this->pdo->query($query4)) throw new PDOException($this->unnableToInsert("truncate teams"));
		if (! $this->pdo->query($query5)) throw new PDOException($this->unnableToInsert("truncate users"));
		if (! $this->pdo->query($query6)) throw new PDOException($this->unnableToInsert("truncate players"));
		if (! $this->pdo->query($query7)) throw new PDOException($this->unnableToInsert("truncate team_players"));
		if (! $this->pdo->query($query8)) throw new PDOException($this->unnableToInsert("truncate referees"));
		
	}
	public function insertIntoContinents() {
		$continents = array('Other','Europe', 'Asia', 'South America',
						'North America', 'Africa', 'Australia', 'Oceania');
		for ($i = 0; $i < count($continents); $i++ ) {
			$query = "INSERT INTO continents(name)
								VALUES('{$continents[$i]}')";
			if (! $this->pdo->exec($query)) throw new PDOException($this->unnableToInsert("continents"));
		}
		$this->successToInsert("continents");
	}
	public function insertIntoCountries() {
		$countries = array('European Cups', 'International', 'England', 'Italy', 'Spain', 'Germany', 'France', 'Holland',
		'Belgium', 'Portugal', 'Scotland', 'Austria', 'Cyprus',	'Denmark',	
		'Finland', 'Greece', 'Iceland',	'Ireland',	'Norway',
		'Sweden', 'Switzerland', 'Turkey', 'Wales', 'Belarus', 'Bosnia-Herzeg.',
		'Bulgaria', 'Croatia', 'Czech Republic', 'Estonia',	'Hungary',
		'Israel', 'Latvia', 'Lithuania', 'Moldova', 'Montenegro', 'Poland',	
		'Romania', 'Russia', 'Serbia', 'Slovakia', 'Slovenia', 'Ukraine',
		'South America', 'Copa America', 'Argentina', 'Bolivia', 'Brazil',	
		'Chile', 'Colombia', 'Ecuador', 'Paraguay', 'Peru',	'Uruguay',	
		'Venezuela', 'CONCACAF', 'Mexico', 'USA', 'Costa Rica', 'El Salvador',	
		'Guatemala', 'Honduras', 'Asia', 'China', 'Japan', 'Korea Republic',
		'Singapore', 'Thailand', 'Vietnam', 'Armenia', 'Azerbaijan', 'Georgia',	
		'Kazakhstan', 'Kuwait', 'Iran', 'Oceania', 'Australia', 'Africa', 
		'Algeria', 'Egypt', 'Morocco', 'South Africa', 'Tunisia');
		$countries_continents = array('Other', 'Other', 'Europe', 'Europe',
		'Europe', 'Europe','Europe', 'Europe','Europe', 'Europe',
		'Europe', 'Europe','Europe', 'Europe','Europe', 'Europe',
		'Europe', 'Europe','Europe', 'Europe','Europe', 'Europe',
		'Europe', 'Europe','Europe', 'Europe','Europe', 'Europe',
	 	'Europe', 'Europe','Europe', 'Europe','Europe', 'Europe',
		'Europe', 'Europe','Europe', 'Europe','Europe', 'Europe',
		'Europe', 'Europe','South America','South America','South America','South America',
		'South America','South America','South America','South America',
		'South America','South America','South America','South America',
		'North America','North America','North America','North America',
		'North America','North America','North America', 'Asia',
		'Asia','Asia','Asia','Asia','Asia','Asia','Asia','Asia','Asia',
		'Asia','Asia','Asia','Oceania', 'Australia','Africa','Africa','Africa',
		'Africa','Africa', 'Africa');
		for ($i = 0; $i < count($countries); $i++ ) {
			$s = strtolower($countries[$i]);
			$query = "SELECT id_continent FROM continents WHERE name like '{$countries_continents[$i]}'";
			$row = $this->pdo->query($query)->fetch();
			$insert_query = "INSERT INTO countries(name, emblem, id_continent) 
					VALUES('{$countries[$i]}', 'flag_{$s}.png', '{$row['id_continent']}')";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("countries"));
		}
		$this->successToInsert("countries");
	}
	public function insertIntoChampionships(){
		$championships = array('Premier League', 'League Championship',	'League One',
			'League Two', 'Conference National', 'Conference North', 'Conference South', 
					'League Cup', 'League Trophy');
		$champ_countries = array('England');
		
		$championshipsInt = array('Champions League', 'Europe League',	'Super Cup');
		$champ_countries_int = array('European Cups');
		
		$championships2 = array('Liga BBVA');
		$champ_countries2 = array('Spain');
		
		for ($i = 0; $i < count($championships); $i++ ) {
			$query = "SELECT id_country FROM countries WHERE name like '{$champ_countries[0]}'";
			$row = $this->pdo->query($query)->fetch();
			$insert_query = "INSERT INTO championships(name, id_country)
								VALUES('{$championships[$i]}', '{$row['id_country']}')";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("championships"));
		}
		
		for ($i = 0; $i < count($championships2); $i++ ) {
			$query = "SELECT id_country FROM countries WHERE name like '{$champ_countries2[0]}'";
			$row = $this->pdo->query($query)->fetch();
			$insert_query = "INSERT INTO championships(name, id_country)
			VALUES('{$championships2[$i]}', '{$row['id_country']}')";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("championships2"));
		}
		
		for ($i = 0; $i < count($championshipsInt); $i++ ) {
			$query = "SELECT id_country FROM countries WHERE name like '{$champ_countries_int[0]}'";
			$row = $this->pdo->query($query)->fetch();
			$insert_query = "INSERT INTO championships(name, id_country)
										VALUES('{$championshipsInt[$i]}', '{$row['id_country']}')";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("championships"));
		}
		
		$update_query = "UPDATE championships SET canPlayInternational = 1 WHERE name like '%Premier League%'";
		if (! $this->pdo->exec($update_query)) throw new PDOException($this->unnableToInsert("championships"));
		$this->successToInsert("championships");
	} 
	public function insertIntoTeams() {
		$teams_england_name = array('Arsenal', 'Manchester City', 'Manchester Utd', 'Chelsea', 'Newcastle',
				'Liverpool', 'Tottenham', 'Stoke City', 'Aston Villa', 'Norwich City', 'Fulham',
				'Swansea', 'Bolton', 'Blackburn', 'Sunderland', 'Wolves',  'Everton',
				'West Brom', 'Wigan', 'QPR');
		$teams_england_name_championship = array('Premier League');
		
		$teams_spain_name = array('Real Madrid', 'Barcelona', 'Valencia', 'Levante', 'Espanyol',
				'Athletic Club', 'Atlético de Madrid', 'Málaga', 'Osasuna', 'Getafe', 'Sevilla',
				'Rayo Vallecano', 'Mallorca', 'Granada', 'Real Sociedad', 'Betis',  'Villarreal',
				'Racing', 'Sporting', 'Zaragoza');
		$teams_spain_name_championship = array('Liga BBVA');
		
		for ($i = 0; $i < count($teams_england_name); $i++) {
			$query = "SELECT id_championship FROM championships WHERE name like '{$teams_england_name_championship[0]}'";
			$row = $this->pdo->query($query)->fetch();
			$insert_query = "INSERT INTO teams(name, id_championship)
									VALUES('{$teams_england_name[$i]}', '{$row['id_championship']}')";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("teams"));
		}
		$this->successToInsert("teams");
		
		for ($i = 0; $i < count($teams_spain_name); $i++) {
			$query = "SELECT id_championship FROM championships WHERE name like '{$teams_spain_name_championship[0]}'";
			$row = $this->pdo->query($query)->fetch();
			$insert_query = "INSERT INTO teams(name, id_championship)
			VALUES('{$teams_spain_name[$i]}', '{$row['id_championship']}')";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("teams"));
		}
		$this->successToInsert("teams");
	}
	public function insertIntoUsers() {
		$pass = md5(md5("475730"));
		$insert_query = "INSERT INTO users(login, password, superadmin)
								VALUES('admin', '{$pass}', '1')";
		$insert_query2 = "INSERT INTO users(login, password, superadmin)
										VALUES('last', '{$pass}', '0')";
		if (! $this->pdo->exec($insert_query2)) throw new PDOException($this->unnableToInsert("users"));
		else $this->successToInsert("users");
		if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("users"));
		else $this->successToInsert("users");
	}
	public function insertIntoPlayers() {
		$insert_query = "INSERT INTO players (id_player, player_name,  birth)
								VALUES ('NULL', 'Manuel Almunia', '1975-01-24'),
									('NULL', 'Wojciech Szczesny', '1975-01-24'),
									('NULL', 'Lukasz Fabianski', '1975-01-24'),	
									('NULL', 'Vito Mannone', '1975-01-24'),
									('NULL', 'Bacary Sagna', '1975-01-24'),
									('NULL', 'Per Mertesacker', '1975-01-24'),
									('NULL', 'Thomas Vermaelen', '1975-01-24'),	
									('NULL', 'Laurent Koscielny', '1975-01-24'),
									('NULL', 'Andre Santos', '1975-01-24'),
									('NULL', 'Sebastien Squillaci', '1975-01-24'),
									('NULL', 'Johan Djourou', '1975-01-24'),
									('NULL', 'Carl Jenkinson', '1975-01-24'),
									('NULL', 'Kieran Gibbs', '1975-01-24'),
									('NULL', 'Abou Diaby', '1975-01-24'),
									('NULL', 'Tomas Rosicky', '1975-01-24'),
									('NULL', 'Aaron Ramsey', '1975-01-24'),
									('NULL', 'Alex Song', '1975-01-24'),	
									('NULL', 'Jack Wilshere','1975-01-24'),
									('NULL', 'Andrey Arshavin', '1975-01-24'),
									('NULL', 'Emmanuel Frimpong', '1975-01-24'),
									('NULL', 'Yossi Benayoun', '1975-01-24'),
									('NULL', 'Francis Coquelin', '1975-01-24'),
									('NULL', 'Ju-Young Park', '1975-01-24'),
									('NULL', 'Robin van Persie', '1975-01-24'),
									('NULL', 'Thierry Henry', '1975-01-24'),
									('NULL', 'Theo Walcott', '1975-01-24'),
									('NULL', 'Alex Oxlade-Chamberlain', '1975-01-24'),
									('NULL', 'Tomas Gervinho', '1975-01-24'),
									('NULL', 'Marouane Chamakh', '1975-01-24'),
									('NULL', 'Ryo Miyaichi', '1975-01-24');";
		$insert_query2 = "INSERT INTO players (id_player, player_name,  birth)
							VALUES ('NULL', 'Stuart Taylor', '1975-01-24'),
									('NULL', 'Gunnar Nielsen', '1975-01-24'),
									('NULL', 'Joe Hart', '1975-01-24'),
									('NULL', 'Micah Richards ', '1975-01-24'),
									('NULL', 'Vincent Kompany', '1975-01-24'),
									('NULL', 'Pablo Zabaleta', '1975-01-24'),
									('NULL', 'Joleon Lescott', '1975-01-24'),
									('NULL', 'Aleksandar Kolarov', '1975-01-24'),
									('NULL', 'Stefan Savić', '1975-01-24'),
									('NULL', 'Gaël Clichy', '1975-01-24'),
									('NULL', 'Kolo Touré', '1975-01-24'),
									('NULL', 'James Milner', '1975-01-24'),
									('NULL', 'David Pizarro', '1975-01-24'),
									('NULL', 'Adam Johnson', '1975-01-24'),
									('NULL', 'Gareth Barry', '1975-01-24'),
									('NULL', 'Samir Nasri', '1975-01-24'),
									('NULL', 'Owen Hargreaves', '1975-01-24'),
									('NULL', 'David Silva','1975-01-24'),
									('NULL', 'Yaya Touré', '1975-01-24'),
									('NULL', 'Edin Džeko', '1975-01-24'),
									('NULL', 'Sergio Agüero', '1975-01-24'),
									('NULL', 'Carlos Tévez', '1975-01-24'),
									('NULL', 'Mario Balotelli', '1975-01-24');";
		if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("players"));
		else $this->successToInsert("players");
		if (! $this->pdo->exec($insert_query2)) throw new PDOException($this->unnableToInsert("players2"));
		else $this->successToInsert("players2");
	}
	public function insertIntoTeamPlayers() {
		for ($i = 1; $i < 31; $i++) {
		$insert_query = "INSERT INTO team_players (id_player, id_team, player_number)
										VALUES ({$i}, 1, {$i})";
				if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("team_players"));
		else $this->successToInsert("team_players");
		}
		for ($i = 31; $i < 53; $i++) {
			$insert_query = "INSERT INTO team_players (id_player, id_team, player_number)
			VALUES ({$i}, 2, {$i})";
			if (! $this->pdo->exec($insert_query)) throw new PDOException($this->unnableToInsert("team_players2"));
					else $this->successToInsert("team_players2");
		}
		
	}
	public function updateTeamPlayers() {
		$update_query1 = "UPDATE team_players SET player_position = 'GK' WHERE id_player IN (1, 2, 3, 4);";
		$update_query2 = "UPDATE team_players SET player_position = 'D' WHERE id_player IN (5, 6, 7, 8, 9, 10, 11, 12, 13, 34, 35, 36, 37, 38, 39, 40, 41);";
		$update_query3 = "UPDATE team_players SET player_position = 'M' WHERE id_player IN (14, 15, 16, 17, 18, 42, 43, 44, 45, 46);";
		$update_query4 = "UPDATE team_players SET player_position = 'AM' WHERE id_player IN (19, 20, 21, 22, 23, 47, 48, 49);";
		$update_query5 = "UPDATE team_players SET player_position = 'ST' WHERE id_player IN (24, 25, 26, 27, 28, 29, 30, 50, 51, 52, 53);";
		//if (! $this->pdo->exec($update_query1)) throw new PDOException($this->unnableToInsert("update_team_players"));
		//else $this->successToInsert("update_team_players");
		if (! $this->pdo->exec($update_query2)) throw new PDOException($this->unnableToInsert("update_team_players"));
		else $this->successToInsert("update_team_players");
		if (! $this->pdo->exec($update_query3)) throw new PDOException($this->unnableToInsert("update_team_players"));
		else $this->successToInsert("update_team_players");
		if (! $this->pdo->exec($update_query4)) throw new PDOException($this->unnableToInsert("update_team_players"));
		else $this->successToInsert("update_team_players");
		if (! $this->pdo->exec($update_query5)) throw new PDOException($this->unnableToInsert("update_team_players"));
		else $this->successToInsert("update_team_players");
	}
	public function insertIntoReferees() {
		$referees = "INSERT INTO referees(id_referee, referee_name, birth, id_country)
						VALUES ('NULL', 'Martin Atkinson', '1971-03-31', 3),
								('NULL', 'Stephen Graham Bennett', '1961-01-17', 3),
								('NULL', 'Phil Dowd', '1963-01-26', 3)";
		if (! $this->pdo->exec($referees)) throw new PDOException($this->unnableToInsert("referees"));
			else $this->successToInsert("referees");
	}
	public function insertIntoStadiums() {
		$stadiums = "INSERT INTO stadiums(id_stadium, name, capacity, image, id_team)
						VALUES ('NULL', 'Emirates Stadium', '60,355', 'arsenal.jpg', 1),
								('NULL', 'Etihad Stadium', '47,726', 'mancity.jpg', 2),
								('NULL', 'Old Trafford', '75,957', 'manutd.jpg', 3),
								('NULL', 'Stamford Bridge', '42,449', 'chelsea.jpg', 4),
								('NULL', 'Sports Direct Arena', '52,387', 'newcastle.jpg', 5),
								('NULL', 'Anfield', '45,362', 'liverpool.jpg', 6),
								('NULL', 'White Hart Lane', '36,238', 'tottenham.jpg', 7),
								('NULL', 'Britannia Stadium', '28,384', 'stoke.jpg', 8),
								('NULL', 'Villa Park', '42,788', 'aston_villa.jpg', 9),
								('NULL', 'Carrow Road', '26,034', 'norwich.jpg', 10),
								('NULL', 'Craven Cottage', '26,000', 'fulham.jpg', 11),
								('NULL', 'Liberty Stadium', '20,532', 'swansea.jpg', 12),
								('NULL', 'Reebok Stadium', '28,723', 'bolton.jpg', 13),
								('NULL', 'Ewood Park', '31,367', 'blackburn.jpg', 14),
								('NULL', 'Stadium of Light', '49,000', 'sunderland.jpg', 15),
								('NULL', 'Halliwell Jones Stadium', '14,206', 'wolves.jpg', 16),
								('NULL', 'Goodison Park', '40,170', 'everton.jpg', 17),
								('NULL', 'The Hawthorns', '27,877', 'West_brom.jpg', 18),
								('NULL', 'DW Stadium', '25,138', 'wigan.jpg', 19),
								('NULL', 'Loftus Road', '19,148', 'QPR.jpg', 20)";
		if (! $this->pdo->exec($stadiums)) throw new PDOException($this->unnableToInsert("stadiums"));
		else $this->successToInsert("stadiums");
	}
	
	public function insertIntoTactics() {
		$tactics = "INSERT INTO tactics(id_tactic, tactic_name, tactic_image)
						VALUES ('NULL', '3-4-1-2', '3-4-1-2.jpg'),
								('NULL', '3-4-3', '3-4-3.jpg'),
								('NULL', '3-5-2', '3-5-2.jpg'),
								('NULL', '4-2-1-3', '4-2-1-3.jpg'),
								('NULL', '4-2-4', '4-2-4.jpg'),
								('NULL', '4-3-1-2', '4-3-1-2.jpg'),
								('NULL', '4-3-3', '4-3-3.jpg'),
								('NULL', '4-4-2', '4-4-2.jpg')";
		if (! $this->pdo->exec($tactics)) throw new PDOException($this->unnableToInsert("tactics"));
		else $this->successToInsert("tactics");
	}
	
	private function unnableToInsert($str) {
		return "<p style='color:red'>Невозможно добавить данные в  таблицу {<span style='color:blue'>".$str."</span>}</p>";
	}
	private function successToInsert($str) {
		echo "<div style='color:green'>Данные успешно добавлены в таблицу
				 {<span style='color:blue'>".$str."</span>}</div>";
	}
}
try {
$pdo = new PDO(DB_DSN, DB_LOGIN, DB_PASSWORD);
$fillTables = new FillTables($pdo);
$fillTables->truncateAll();
$fillTables->insertIntoContinents();
$fillTables->insertIntoCountries();
$fillTables->insertIntoChampionships();
$fillTables->insertIntoTeams();
$fillTables->insertIntoUsers();
$fillTables->insertIntoPlayers();
$fillTables->insertIntoTeamPlayers();
$fillTables->updateTeamPlayers();
$fillTables->insertIntoReferees();
$fillTables->insertIntoStadiums();
$fillTables->insertIntoTactics();
}
catch (PDOException $e) {
	echo $e->getMessage();
}
?>
