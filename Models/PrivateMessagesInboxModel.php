<?php
require_once '../Config/config.php.inc';
/**
 * id_private_message_inbox
 * id_user_send
 * id_user_get
 * theme
 * text
 * date
 * isRead
 */
class PrivateMessagesInboxModel{
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем всё из входящих сообщений
	 */
	public function getAllPrivateMessagesInbox() {
		$query = "SELECT id_private_message_inbox, id_user_send, id_user_get, theme, text, date, isRead
					FROM private_messages_inbox";
		return $this->getQuery($query, "Невозможно получить все inbox сообщения ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем все входящие сообщения данного юзера по ID
	 * @param ID юзера $id_user_get
	 */
	public function getInboxPrivateMessagesByUserId($id_user_get) {
		$query = "SELECT id_private_message_inbox, id_user_send, id_user_get, theme, text, date, isRead
							FROM private_messages_inbox WHERE id_user_get = {$id_user_get} ORDER BY date DESC";
		return $this->getQuery($query, "Невозможно получить все inbox сообщения ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем отправителя сообщения по id сообщения
	 * @param ID сообщения $id_private_message
	 */
	public function getUserSendByMessageId($id_private_message_inbox) {
		$query = "SELECT id_user_send FROM private_messages_inbox
				 WHERE id_private_message_inbox = {$id_private_message_inbox}";
		return $this->getQuery($query, "Невозможно получить id отправителя по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем получателя сообщения по id сообщения
	* @param ID сообщения $id_private_message
	*/
	public function getUserGetByMessageId($id_private_message_inbox) {
		$query = "SELECT id_user_get FROM private_messages_inbox
					 WHERE id_private_message_inbox = {$id_private_message_inbox}";
		return $this->getQuery($query, "Невозможно получить id получателя по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем тему по id сообщения
	 * @param ID cообщения $id_private_message_inbox
	 */
	public function getThemeByMessageId($id_private_message_inbox) {
		$query = "SELECT theme FROM private_messages_inbox
							 WHERE id_private_message_inbox = {$id_private_message_inbox}";
		return $this->getQuery($query, "Невозможно получить тему по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем текст сообщения по id сообщения
	 * @param ID сообщения $id_private_message_inbox
	 */
	public function getMessageByMessageId($id_private_message_inbox) {
		$query = "SELECT text FROM private_messages_inbox
								 WHERE id_private_message_inbox = {$id_private_message_inbox}";
		return $this->getQuery($query, "Невозможно получить текст сообщения по id сообщения ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Проверяем или сообщение было прочитано
	 * @param ID сообщения $id_private_message_inbox
	 */
	public function checkPrivateMessageIsRead($id_private_message_inbox) {
		$query = "SELECT isRead	FROM private_messages_inbox 
					WHERE id_private_message_inbox = {$id_private_message_inbox}";
		if ($this->getQuery($query, "Ошибка в  ", __FUNCTION__)->fetchColumn(0) == 1) {
			return true;
		}
			else return false;
	}
	/**
	 * 
	 * Обновляем isRead если пользователь прочитал сообщение
	 * @param ID сообщения $id_private_message_inbox
	 */
	public function setIsRead($id_private_message_inbox) {
		if ($this->checkPrivateMessageIsRead($id_private_message_inbox) == false) {
			$exec_query = "UPDATE private_messages_inbox SET isRead = 1 
							WHERE id_private_message_inbox = {$id_private_message_inbox}";
			return $this->getExec($exec_query, "Не возможно обновить isRead", __FUNCTION__);
		}
		else return null;
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
		$exec_query = "INSERT INTO private_messages_inbox(id_user_send, id_user_get, theme, text, date, isRead)
						VALUES(".$from_id_user.", ".$to_id_user.", '".$theme."', '".$text."', '".$date."', 0)";
		return $this->getExec($exec_query, "Невозможно добавить сообщение", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем количество непрочитанных сообщений по ID юзера
	 * @param ID юзера $id_user_get
	 */
	public function getUnreadAmount($id_user_get) {
		$query = "SELECT count(id_private_message_inbox) FROM private_messages_inbox WHERE id_user_get = {$id_user_get} AND isRead = 0";
		return $this->getQuery($query, "Невозможно получить количество непрочитанных сообщений по ID юзера ", __FUNCTION__)->fetchColumn(0);
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