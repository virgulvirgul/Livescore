<?php
/**
 * 
 *	id_game	 	 	 	 	 
 * 	date	 	 	 	 	 	 	 
 *	id_team_owner 	 	 	 	 	 	 
 *	id_team_guest 	 	 	 	 	 	 
 *	score_owner	varchar(2)	latin1_swedish_ci		Да	?		 	 	 	 	 	 	 
 *	score_guest	varchar(2)	latin1_swedish_ci		Да	?		 	 	 	 	 	 	 
 *	id_championship	int(6)			Нет	Нет		 	 	 	 	 	 	 
 *	tour	tinyint(2)			Да	NULL		 	 	 	 	 	 	 
 *	id_referee	int(8)			Нет	Нет		 	 	 	 	 	 	 
 *	id_stadium	int(8)			Нет	Нет		 	 
 *	break 
 *	finished	 	 	 	 	 
 *	more_info
 *
 */

require_once '../Config/config.php.inc';

class GamesModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * Получааем данные по игре по id
	 * @param id игры $id_game
	 */
	public function getGameByGameId($id_game) {
		$query = "SELECT id_game, date, id_team_owner, id_team_guest, score_owner, score_guest,
						tour, id_referee, id_stadium, break, finished, more_info, id_championship
					FROM games
						WHERE id_game  = {$id_game}";
		return $this->getQuery($query, "Невозможно получить иру по id ", __FUNCTION__);
	}
	/**
	 * Получаем предыдущие встречи между командами
	 * @param id команды хозяев $id_team_owner
	 * @param id команды гостей $id_team_guest
	 */
	public function getPreviousMeetingsByTeamOwnerAndGuestId($id_team_owner, $id_team_guest) {
		$query = "SELECT id_game, DATE(date) as date, id_team_owner, id_team_guest, score_owner, score_guest,
						tour, id_referee, id_stadium, break, finished, more_info, id_championship
					FROM games
						WHERE (id_team_owner  = {$id_team_owner} AND id_team_guest = {$id_team_guest})
							OR (id_team_owner  = {$id_team_guest} AND id_team_guest = {$id_team_owner})
						ORDER BY date";
		return $this->getQuery($query, "Невозможно получить предыдущие встречи по id команд", __FUNCTION__);
	}
	/**
	 * Получаем все игры по id чемпионата
	 * @param id чемпионата $id_championship
	 */
	public function getGamesByChampionshipId($id_championship) {
		$query = "SELECT id_game, date, id_team_owner, id_team_guest, score_owner, score_guest,
						 tour, id_referee, id_stadium, break, finished, more_info
					FROM games 
						WHERE id_championship  = {$id_championship} ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все игры по ID чемпионата ", __FUNCTION__);
	}
	/**
	 * Получаем все ближайшие матчи
	 */
	public function getAllNearestGames() {
		$query = "SELECT DISTINCT DATE(date) as date, id_team_owner
					FROM games
						WHERE DATEDIFF(date, SYSDATE()) = 0 ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все ближайшие матчи", __FUNCTION__);
	}
	/**
	 * Получаем все ближайшие даты
	 */
	public function getAllNearestDatesByIdChampionship($id_championship) {
		$query = "SELECT DISTINCT DATE(date) as date
					FROM games 
						WHERE ( DATEDIFF(date, SYSDATE()) = 0 OR DATEDIFF(date, SYSDATE()) = 1 )
							AND id_championship  = {$id_championship}  ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все ближайшие даты", __FUNCTION__);
	}
	/**
	 * Получаем список лет (для архива)
	 */
	public function getGamesYears() {
		$query = "SELECT DISTINCT YEAR(date) as date
					FROM games";
		return $this->getQuery($query, "Невозможно получить список лет ", __FUNCTION__);
	}
	/**
	 * Получаем список лет (для архива)
	 * @param id чемпионата $id_championship
	 */
	public function getGamesYearsByChampionshipId($id_championship) {
		$query = "SELECT DISTINCT YEAR(date) as date
					FROM games WHERE id_championship = {$id_championship}";
		return $this->getQuery($query, "Невозможно получить список лет по id чемпионата", __FUNCTION__);
	}
	/**
	 * Получаем список месяцев по году (для архива)
	 * @param год $year
	 */
	public function getMonthesByYear($year) {
		$query = "SELECT DISTINCT MONTH(date) as date
					FROM games
						WHERE YEAR(date) = '".$year."'";
		return $this->getQuery($query, "Невозможно получить список месяцев по году ", __FUNCTION__);
	}
	/**
	 * Получаем список месяцев по году (для архива) и id чемпионата
	 * @param год $year
	 * @param id чемпионата $id_championship
	 */
	public function getMonthesByYearAndChampionshipId($year, $id_championship) {
		$query = "SELECT DISTINCT MONTH(date) as date
					FROM games
						WHERE YEAR(date) = '".$year."' AND id_championship = {$id_championship}";
		return $this->getQuery($query, "Невозможно получить список месяцев по году и id чемпионата", __FUNCTION__);
	}
	/**
	 * Получаем список игр по году и месяцу
	 * @param год $year
	 * @param месяц $month
	 * @param id чемпионата $id_championship
	 */
	public function getGamesByYearMonthChampionshipId($year, $month, $id_championship) {
		$query = "SELECT DISTINCT DATE(date) as date
					FROM games
						WHERE YEAR(date) = '".$year."' AND MONTH(date) = '".$month."'
							AND id_championship = {$id_championship} ORDER BY date";
		return $this->getQuery($query, "Невозможно получить список игр по месяцу году и чемпионату", __FUNCTION__);
	}
	/**
	 * Получаем дату игры по её id
	 * @param id игры $id_game
	 */
	public function getGameDateById($id_game) {
		$query = "SELECT date
					FROM games
						WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить дату игры по ID ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Получуаем даты матчей по id чемпионата
	 * @param id чемпионата $id_championship
	 */
	public function getAllDatesByChampionshipId($id_championship) {
		$query = "SELECT DISTINCT DATE(date) AS date
					FROM games
						WHERE id_championship = {$id_championship} ORDER BY date";
		return $this->getQuery($query, "Невозможно получить дату игры по ID ", __FUNCTION__);
	}
	/**
	 * Получаем все матчи по дате
	 * @param год $year
	 * @param месяц $month
	 * @param день $day
	 */
	public function getAllGamesByDate($year, $month, $day) {
		$query = "SELECT id_game, TIME(date) as date, id_team_owner, id_team_guest, score_owner,
					 score_guest, tour, id_referee, id_stadium, break, finished, more_info
					FROM games
						WHERE YEAR(date) like '".$year."' AND MONTH(date) like '".$month."'
							AND DAY(date) like '".$day."' ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все игры по дате", __FUNCTION__);
	}
	/**
	 * Получаем id чемпионатов по дате
	 * @param год $year
	 * @param месяц $month
	 * @param день $day
	 */
	public function getChampionshipIdByDate($year, $month, $day) {
		$query = "SELECT DISTINCT id_championship
					FROM games
						WHERE YEAR(date) like '".$year."' AND MONTH(date) like '".$month."'
							AND DAY(date) like '".$day."' ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все игры по дате", __FUNCTION__);
	}
	/**
	 * Получаем сыгранное на данный момент количество минут
	 * @param id игры $id_game
	 */
	public function getMinutesByGameId($id_game) {
		$query = "SELECT time_to_sec(TIMEDIFF(NOW(), date)) / 60 as date
					FROM games
						WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить сыгранное на данный момент количество минут", __FUNCTION__)->fetchColumn(0);
	}
	
	/**
	 * Получаем id другой команды
	 * @param id команды $id_team
	 * @param id игры $id_game
	 */
	public function getAnotherTeamByTeamAndGameId($id_team, $id_game) {
		$query = "SELECT id_team_guest FROM games WHERE id_team_owner = {$id_team} AND id_game = {$id_game}";
		
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			return $this->getQuery($query, "Невозможно получить id команды", __FUNCTION__)->fetchColumn(0);
		}
		else {
			$query = "SELECT id_team_owner FROM games WHERE id_team_guest = {$id_team} AND id_game = {$id_game}";
			return $this->getQuery($query, "Невозможно получить id команды", __FUNCTION__)->fetchColumn(0);
		}
	}
	
	/**
	 * Получаем все матчи по дате
	 * @param год $year
	 * @param месяц $month
	 * @param день $day
	 */
	public function getAllGamesByDateAndChampioshipId($year, $month, $day, $id_championship) {
		$query = "SELECT id_game, TIME(date) as date, id_team_owner, id_team_guest, score_owner,
		score_guest, tour, id_referee, id_stadium, break, finished, more_info
		FROM games
		WHERE YEAR(date) like '".$year."' AND MONTH(date) like '".$month."'
		AND DAY(date) like '".$day."' AND id_championship = {$id_championship} ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все игры по дате", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем id команды хозяев по ID игры
	 * @param id игры $id_game
	 */
	public function getTeamOwnerIdByGameId($id_game) {
		$query = "SELECT id_team_owner
							FROM games
								WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить id команды хозяев по ID игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем id команды гостей по ID игры
	* @param id игры $id_game
	*/
	public function getTeamGuestIdByGameId($id_game) {
		$query = "SELECT id_team_guest
								FROM games
									WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить id команды гостей по ID игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Получаем кол-во забитых голов хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getScoreOwnerByGameId($id_game) {
		$query = "SELECT score_owner
									FROM games
										WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить кол-во забитых голов хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	* Получаем кол-во забитых голов гостями по id игры
	* @param id игры $id_game
	*/
	public function getScoreGuestByGameId($id_game) {
		$query = "SELECT score_guest
									FROM games
											WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить кол-во забитых голов гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	* Получаем id чемпионата по id игры
	* @param id игры $id_game
	*/
	public function getChampionshipIdByGameId($id_game) {
		$query = "SELECT id_championship
										FROM games
												WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить id чемпионата по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	* Получаем номер тура id игры
	* @param id игры $id_game
	*/
	public function getTourByGameId($id_game) {
		$query = "SELECT tour
							FROM games
									WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить номер тура по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	* Получаем id судьи id игры
	* @param id игры $id_game
	*/
	public function getRefereeIdByGameId($id_game) {
		$query = "SELECT id_referee
								FROM games
										WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить id судьи по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	* Получаем id стадиона id игры
	* @param id игры $id_game
	*/
	public function getStadiumIdByGameId($id_game) {
		$query = "SELECT id_stadium
									FROM games
											WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить id стадиона по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	* Получаем дополнительную инфо об игре id игры
	* @param id игры $id_game
	*/
	public function getMoreInfoByGameId($id_game) {
		$query = "SELECT more_info
									FROM games
											WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить дополнительную инфо по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Получаем последний вставленный id игры в таблице
	 */
	public function getLastInsertedGameId() {
		return $this->pdo->lastInsertId();
	}
	/**
	 * 
	 * Добавляем игру
	 * @param дата игры $date
	 * @param id команды хозяев $id_team_owner
	 * @param id команды гостей $id_team_guest
	 * @param id чемпионата $id_championship
	 * @param номер тура $tour
	 * @param id судьи $id_referee
	 * @param id стадиона $id_stadium
	 * @param дополнительная информация $more_info
	 */
	public function addGame($date, $id_team_owner, $id_team_guest, $id_championship, $tour, $id_referee,
								$id_stadium, $more_info) {
		$exec_query = "INSERT INTO games(id_game, date, id_team_owner, id_team_guest, id_championship, tour,
					id_referee, id_stadium, more_info) 
						VALUES(NULL, '".$date."', {$id_team_owner}, {$id_team_guest},
								{$id_championship}, '".$tour."', {$id_referee}, {$id_stadium}, '".$more_info."')";
		return $this->getExec($exec_query, "Невозможно добавить игру", __FUNCTION__);
	}
	/**
	 * 
	 * Изменяем кол-во забитых голов хозяевами по id игры
	 * @param кол-во забитых голов $score_owner
	 * @param id игры $id_game
	 */
	public function setScoreOwnerByGameId($score_owner, $id_game) {
		$exec_query = "UPDATE games SET score_owner = ".$score_owner." WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно изменить score_owner по id игры", __FUNCTION__);
	}	
	
	/**
	*
	* Изменяем кол-во забитых голов гостями по id игры
	* @param кол-во забитых голов $score_guest
	* @param id игры $id_game
	*/
	public function setScoreGuestByGameId($score_guest, $id_game) {
		$exec_query = "UPDATE games SET score_guest = ".$score_guest." WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно изменить score_guest по id игры", __FUNCTION__);
	}
	/**
	 * Если игра уже началась ставим вместо ? - 0
	 */
	public function setScores($id_game) {
		$exec_query = "UPDATE games SET score_guest = 0, score_owner = 0 WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно изменить ?  на 0", __FUNCTION__);
	}
	/**
	 * При голе меняем значение голов у команды на +1
	 * @param id игры $id_game
	 * @param id команды $id_team
	 */
	public function updateScoreByGameId($id_game, $id_team) {
		$query = "SELECT id_game FROM games WHERE id_team_guest = {$id_team} AND id_game = {$id_game}";
		
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			$exec_query = "UPDATE games SET score_guest = score_guest + 1 WHERE id_game = {$id_game} AND id_team_guest = {$id_team}";
		}
		else {
			$exec_query = "UPDATE games SET score_owner = score_owner + 1 WHERE id_game = {$id_game} AND id_team_owner = {$id_team}";
			
		}
		
		$this->getExec($exec_query, "Невозможно изменить значение голов", __FUNCTION__);
	}
	/**
	 * При автоголе меняем значение голов у другой команды на +1
	 * @param id игры $id_game
	 * @param id команды $id_team
	 */
	public function updateOwnGoalScoreByGameId($id_game, $id_team) {
		$query = "SELECT id_game FROM games WHERE id_team_guest = {$id_team} AND id_game = {$id_game}";
	
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() == 0) {
			$exec_query = "UPDATE games SET score_guest = score_guest + 1 WHERE id_game = {$id_game} AND id_team_owner = {$id_team}";
		}
		else {
			$exec_query = "UPDATE games SET score_owner = score_owner + 1 WHERE id_game = {$id_game} AND id_team_guest = {$id_team}";
		}
	
		$this->getExec($exec_query, "Невозможно изменить значение автогола", __FUNCTION__);
	}
	/**
	 * Если в данный момент идёт перерыв то получаем 1, в противном случае 0
	 * @param id игры $id_game
	 */
	public function getBreakByGameId($id_game) {
		$query = "SELECT break
					FROM games
						WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить перерыв", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Если матч закончен получаем 1 в противном случае получаем 0
	 * @param id игры $id_game
	 */
	public function getFinishedByGameId($id_game) {
		$query = "SELECT finished
					FROM games
						WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить конец матча", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Если начался перерыв то пишим 1 в break
	 * @param id игры $id_game
	 */
	public function updateBreakByGameId($id_game) {
		$exec_query = "UPDATE games
						SET break = 1
							WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно записать начало перерыва", __FUNCTION__);
	}
	/**
	 * Если закончился перерыв то пишим 0 в break
	 * @param id игры $id_game
	 */
	public function updateBreakEndByGameId($id_game) {
		$exec_query = "UPDATE games
						SET break = 0
							WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно записать конец перерыва", __FUNCTION__);
	}
	/**
	 * Если закончился матч то пишим 1 в finished
	 * @param id игры $id_game
	 */
	public function updateFinishedByGameId($id_game) {
		$exec_query = "UPDATE games
						SET finished = 1
							WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно записать конец матча", __FUNCTION__);
	}
	/**
	 * Получаем была ли серия пенальти (1 - была, 0 - не была)
	 * @param id игры $id_game
	 */
	public function getPenaltyShootoutByGameId($id_game) {
		$query = "SELECT penalty_shootout
					FROM games
						WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить серию пенальти", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Получаем кол-во забитых пенальти хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getPenaltyShootoutOwnerScoreByGameId($id_game) {
		$query = "SELECT penalty_shootout_owner_score
					FROM games
						WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить кол-во забитых пенальти хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Получаем кол-во забитых пенальти гостями по id игры
	 * @param id игры $id_game
	 */
	public function getPenaltyShootoutGuestScoreByGameId($id_game) {
		$query = "SELECT penalty_shootout_guest_score
						FROM games
							WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить кол-во забитых пенальти гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Если началась серия пенальти ставим 1 в столбец penalty_shootout
	 * @param id игры  $id_game
	 */
	public function setPealtyShootoutByGameId($id_game) {
		$exec_query = "UPDATE games
							SET penalty_shootout = 1
								WHERE id_game = {$id_game}";
		return $this->getExec($exec_query, "Невозможно записать начало серии пенальти", __FUNCTION__);
	}
	/**
	 * При забитом пенальти меняем значения на +1
	 * @param id команды $id_team
	 * @param id игры $id_game
	 */
	public function updatePenaltyScoredByTeamAndGameId($id_team, $id_game) {
		$query = "SELECT id_game FROM games WHERE id_team_guest = {$id_team} AND id_game = {$id_game}";
		
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			$exec_query = "UPDATE games SET penalty_shootout_guest_score = penalty_shootout_guest_score + 1 WHERE id_game = {$id_game} AND id_team_guest = {$id_team}";
		}
		else {
			$exec_query = "UPDATE games SET penalty_shootout_owner_score = penalty_shootout_owner_score + 1 WHERE id_game = {$id_game} AND id_team_owner = {$id_team}";
		}
		
		$this->getExec($exec_query, "Невозможно изменить значение пенальти", __FUNCTION__);
	}
	/**
	*
	* Выполняем запрос
	* @param запрос $query
	* @param сообщение исключения $exception_message
	* @param имя функции $function
	* @throws PDOException
	*/
	private function getQuery($query, $exception_message, $function) {
		$exec = $this->pdo->query($query);
		if (! $exec) {
			throw new PDOException($exception_message."{".__CLASS__.".".$function."}");
		}
			else return $exec;
	}
	/**
	 *
	 * Выполняем запрос exec (на update delete insert)
	 * @param запрос $query
	 * @param сообщение исключения $exception_message
	 * @param имя функции $function
	 * @throws PDOException
	 */
	private function getExec($exec_query, $exception_message, $function) {
		$exec = $this->pdo->exec($exec_query);
		if (! $exec) {
			throw new PDOException($exception_message."{".__CLASS__.".".$function."}");
		}
			else return $exec;
	}
	
}

?>