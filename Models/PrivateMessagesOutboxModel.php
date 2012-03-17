<?php
require_once '../Config/config.php.inc';
/**
 * id_private_message_outbox
 * id_user_send
 * id_user_get
 * theme
 * text
 * date
 */
class PrivateMessagesOutboxModel{
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем всё из исходящих сообщений
	 */
	public function getAllPrivateMessagesOutbox() {
		$query = "SELECT id_private_message_outbox, id_user_send, id_user_get, theme, text, date
					FROM private_messages_outbox";
		return $this->getQuery($query, "Невозможно получить все outbox сообщения ", __FUNCTION__);
	}
	/**
	*
	* Получаем все исходящие сообщения данного юзера по ID
	* @param ID юзера $id_user_send
	*/
	public function getOutboxPrivateMessagesByUserId($id_user_send) {
		$query = "SELECT id_private_message_outbox, id_user_send, id_user_get, theme, text, date
								FROM private_messages_outbox WHERE id_user_send = ".$id_user_send." ORDER BY date DESC";
		return $this->getQuery($query, "Невозможно получить все outbox сообщения ", __FUNCTION__);
	}
	/**
	 * 
	 * Добавляем сообщение
	 * @param ID юзера отправителя $from_id_user
	 * @param ID юзера плучателя $to_id_user
	 * @param тема сообщения $theme
	 * @param текст сообщения $text
	 */
	public function addPrivateMessage($from_id_user, $to_id_user, $theme, $text) {
		$date = date("Y-m-d H:i:s");
		$exec_query = "INSERT INTO private_messages_outbox(id_user_send, id_user_get, theme, text, date)
						VALUES(".$from_id_user.", ".$to_id_user.", '".$theme."', '".$text."', '".$date."')";
		return $this->getExec($exec_query, "Невозможно добавить сообщение в outbox", __FUNCTION__);
	}
	/**
	*  Получаем отправителя сообщения по id сообщения
	* @param ID сообщения $id_private_message_outbox
	*/
	public function getUserSendByMessageId($id_private_message_outbox) {
		$query = "SELECT id_user_send FROM private_messages_outbox
					 WHERE id_private_message_outbox = {$id_private_message_outbox}";
		return $this->getQuery($query, "Невозможно получить id отправителя по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 *
	 * Получаем получателя сообщения по id сообщения
	 * @param ID сообщения $id_private_message
	 */
	public function getUserGetByMessageId($id_private_message_outbox) {
		$query = "SELECT id_user_get FROM private_messages_outbox
						 WHERE id_private_message_outbox = {$id_private_message_outbox}";
		return $this->getQuery($query, "Невозможно получить id получателя по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 *
	 * Получаем тему по id сообщения
	 * @param ID cообщения $id_private_message_inbox
	 */
	public function getThemeByMessageId($id_private_message_outbox) {
		$query = "SELECT theme FROM private_messages_outbox
								 WHERE id_private_message_outbox = {$id_private_message_outbox}";
		return $this->getQuery($query, "Невозможно получить тему по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 *
	 * Получаем текст сообщения по id сообщения
	 * @param ID сообщения $id_private_message_inbox
	 */
	public function getMessageByMessageId($id_private_message_outbox) {
		$query = "SELECT text FROM private_messages_outbox
									 WHERE id_private_message_outbox = {$id_private_message_outbox}";
		return $this->getQuery($query, "Невозможно получить текст сообщения по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 *
	 * Проверяем или сообщение было прочитано
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