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
	 * Получаем все игры по id чемпионата
	 * @param id чемпионата $id_championship
	 */
	public function getGamesByChampionshipId($id_championship) {
		$query = "SELECT id_game, date, id_team_owner, id_team_guest, score_owner, score_guest, tour, id_referee, id_stadium, more_info
					FROM games 
						WHERE id_championship  = {$id_championship} ORDER BY date";
		return $this->getQuery($query, "Невозможно получить все игры по ID чемпионата ", __FUNCTION__);
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
						WHERE id_championship = {$id_championship}";
		return $this->getQuery($query, "Невозможно получить дату игры по ID ", __FUNCTION__);
	}
	/**
	 * Получаем все матчи по дате
	 * @param год $year
	 * @param месяц $month
	 * @param день $day
	 */
	public function getAllGamesByDate($year, $month, $day) {
		$query = "SELECT id_game, TIME(date) as date, id_team_owner, id_team_guest, score_owner, score_guest, tour, id_referee, id_stadium, more_info
					FROM games
						WHERE YEAR(date) like '".$year."' AND MONTH(date) like '".$month."'
							AND DAY(date) like '".$day."'";
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