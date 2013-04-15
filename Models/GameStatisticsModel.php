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
	 * Добавление статистики при добавлении новой игры
	 * @param id игры $id_game
	 */
	public function addGameStatistics($id_game) {
		$exec_query = "INSERT INTO game_statistics(id_game_statistics, id_game)
				VALUES ('NULL', ".$id_game.")";
		return $this->getExec($exec_query, "Невозможно добавить статистику при добавлении новой игры ", __FUNCTION__);
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
	 * Обновляем процент владения мячом (на +1) хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function updatePossesionOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET possession_owner = possession_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить процент владения мячом хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем процент владения мячом (на +1) хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function updatePossesionGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET possession_guest = possession_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить процент владения мячом гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем процент владения мячом (на -1) хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function updatePossesionDecOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET possession_owner = possession_owner - 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить процент владения мячом хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем процент владения мячом (на -1) хозяевами по id игры
		* @param id игры $id_game
		*/
	public function updatePossesionDecGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET possession_guest = possession_guest - 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить процент владения мячом гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Обновляем количество ударов хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateShotsOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET shots_owner = shots_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество ударов хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество ударов гостей по id игры
		* @param id игры $id_game
		*/
	public function updateShotsGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET shots_guest = shots_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество ударов гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем количество ударов в створ хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function updateShotsOnTargetOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET shots_on_target_owner = shots_on_target_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество ударов по воротам хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество ударов в створ гостей по id игры
		* @param id игры $id_game
		*/
	public function updateShotsOnTargetGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET shots_on_target_guest = shots_on_target_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество ударов по воротам гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем количество ударов мимо хозяевами по id игры
	 * @param id игры $id_game
	 */
	public function updateShotsWideOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET shots_wide_owner = shots_wide_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество ударов по мимо хозяевами по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество ударов мимо гостями по id игры
		* @param id игры $id_game
		*/
	public function updateShotsWideGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET shots_wide_guest = shots_wide_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество ударов мимо гостями по id игры ", __FUNCTION__)->fetchColumn(0);
	}


	/**
	 * Обновляем количество угловых хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateCornersOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET corners_owner = corners_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество угловых хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество угловых гостей по id игры
		* @param id игры $id_game
		*/
	public function updateCornersGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET corners_guest = corners_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество угловых гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем количество офсайдов хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateOffsidesOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET offsides_owner = offsides_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество офсайдов хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество офсайдов гостей по id игры
		* @param id игры $id_game
		*/
	public function updateOffsidesGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET offsides_guest = offsides_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество офсайдов гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем количество сэйвов хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateSavesOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET saves_owner = saves_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество сэйвов хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
	 * Обновляем количество сэйвов гостей по id игры
	 * @param id игры $id_game
	 */
	public function updateSavesGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET saves_guest = saves_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество сэйвов гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Обновляем количество нарушений хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateFoulsOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET fouls_owner = fouls_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество нарушений хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество нарушений гостей по id игры
		* @param id игры $id_game
		*/
	public function updateFoulsGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET fouls_guest = fouls_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество нарушений гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Обновляем количество жёлтых карточек хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateYellowCardsOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET yellow_cards_owner = yellow_cards_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество жёлтых карточек хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество жёлтых карточек гостей по id игры
		* @param id игры $id_game
		*/
	public function updateYellowCardsGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET yellow_cards_guest = yellow_cards_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество жёлтых карточек гостей по id игры ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * Обновляем количество красных карточек хозяев по id игры
	 * @param id игры $id_game
	 */
	public function updateRedCardsOwnerByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET red_cards_owner = red_cards_owner + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество красных карточек хозяев по id игры ", __FUNCTION__)->fetchColumn(0);
	}

	/**
		* Обновляем количество красных карточек гостей по id игры
		* @param id игры $id_game
		*/
	public function updateRedCardsGuestByGameId($id_game) {
		$query = "UPDATE game_statistics
		SET red_cards_guest = red_cards_guest + 1
		WHERE id_game = {$id_game}";
		return $this->getQuery($query, "Невозможно обновить количество красных карточек гостей по id игры ", __FUNCTION__)->fetchColumn(0);
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