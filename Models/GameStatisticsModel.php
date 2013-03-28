<?php


require_once '../Config/config.php.inc';

/**
 *
 * id_game_statistics
 * id_game
 * possession_owner
 * possesion_guest
 * shots_owner
 * shots_guest
 * shots_on_target_owner
 * shots_on_target_guest
 * shots_wide_owner
 * shots_wide_guest
 * corners_owner
 * corners_guest
 * offsides_owner
 * offsides_guest
 * saves_owner
 * saves_guest
 * fouls_owner
 * fouls_guest
 * yellow_cards_owner
 * yellow_cards_guest
 * red_cards_owner
 * red_cards_guest
 *
 */
class GameStatisticsModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}


	/**
	 * Получаем процент владения мячом хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getPossesionOwnerByGameId($id_game) {
		$query = "SELECT possession_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить процент владения мячом хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем процент владения мячом гостями по id игры
	 * @param id игры $id_game
	 */
	public function getPossesionGuestByGameId($id_game) {
		$query = "SELECT possession_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить процент владения мячом гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество ударов хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getShotsOwnerByGameId($id_game) {
		$query = "SELECT shots_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество ударов хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество ударов хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getShotsGuestByGameId($id_game) {
		$query = "SELECT shots_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество ударов гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество ударов в створ хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getShotsOnTargetOwnerByGameId($id_game) {
		$query = "SELECT shots_on_target_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество ударов в створ хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество ударов в створ хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getShotsOnTargetGuestByGameId($id_game) {
		$query = "SELECT shots_on_target_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество ударов в створ гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество ударов мимо хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function getShotsWideOwnerByGameId($id_game) {
		$query = "SELECT shots_wide_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество ударов мимо хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество ударов мимо гостями по id игры
	 * @param id игры $id_game
	 */
	public function getShotsWideGuestByGameId($id_game) {
		$query = "SELECT shots_wide_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество ударов мимо гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество угловых хозяев по id игры
	 * @param id игры $id_game
	 */
	public function getCornersOwnerByGameId($id_game) {
		$query = "SELECT corners_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество угловых хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество угловых гостей по id игры
	 * @param id игры $id_game
	 */
	public function getCornersGuestByGameId($id_game) {
		$query = "SELECT corners_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество угловых гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество офсайдов хозяев по id игры
	 * @param id игры $id_game
	 */
	public function getOffsidesOwnerByGameId($id_game) {
		$query = "SELECT offsides_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество офсайдов хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество офсайдов гостей по id игры
	 * @param id игры $id_game
	 */
	public function getOffsidesGuestByGameId($id_game) {
		$query = "SELECT offsides_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество офсайдов гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество сэйвов хозяев по id игры
	 * @param id игры $id_game
	 */
	public function getSavesOwnerByGameId($id_game) {
		$query = "SELECT saves_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество сэйвов хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество сэйвов гостей по id игры
	 * @param id игры $id_game
	 */
	public function getSavesGuestByGameId($id_game) {
		$query = "SELECT saves_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество сэйвов гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество нарушений хозяев по id игры
	 * @param id игры $id_game
	 */
	public function getFoulsOwnerByGameId($id_game) {
		$query = "SELECT fouls_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество нарушений хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество нарушений гостей по id игры
	 * @param id игры $id_game
	 */
	public function getFoulsGuestByGameId($id_game) {
		$query = "SELECT fouls_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество нарушений гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество жёлтых карточек хозяев по id игры
	 * @param id игры $id_game
	 */
	public function getYellowCardsOwnerByGameId($id_game) {
		$query = "SELECT yellow_cards_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество жёлтых карточек хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество жёлтых карточек гостей по id игры
	 * @param id игры $id_game
	 */
	public function getYellowCardsGuestByGameId($id_game) {
		$query = "SELECT yellow_cards_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество жёлтых карточек гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество красных карточек хозяев по id игры
	 * @param id игры $id_game
	 */
	public function getRedCardsOwnerByGameId($id_game) {
		$query = "SELECT red_cards_owner
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество жёлтых карточек хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Получаем количество красных карточек гостей по id игры
	 * @param id игры $id_game
	 */
	public function getRedCardsGuestByGameId($id_game) {
		$query = "SELECT red_cards_guest
		FROM game_statistics
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно получить количество красных карточек гостей по id игры ", __FUNCTION__)->fetchColumn(0);
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