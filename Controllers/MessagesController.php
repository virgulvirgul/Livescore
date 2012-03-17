<?php
//session_start();
require_once '../Models/PrivateMessagesInboxModel.php';
require_once '../Models/PrivateMessagesOutboxModel.php';
require_once '../Models/UsersModel.php';
/**
*
* Блок личных сообщений
*/
class MessagesController {
	
	private $privateMessagesInboxModel;
	private $privateMessagesOutboxModel;
	private $usersModel;
	
	public function __construct($string) {
		$this->privateMessagesInboxModel = new PrivateMessagesInboxModel();
		$this->privateMessagesOutboxModel = new PrivateMessagesOutboxModel();
		$this->usersModel = new UsersModel();
		if ($string == 'messages') $this->getMessagesContent();
			else if ($string == 'read') $this->getMessagesReadContent();
			else if ($string == 'send') $this->getMessageSendingContent();
	}
	/**
	*
	* Блок личных сообщений
	*/
	public function getMessagesContent() {
		//echo $this->privateMessagesInboxModel->getInboxPrivateMessagesByUserId(2);
		echo "<h2>Личные сообщения</h2>";
		echo "<br><center><span id='messages'>
			<a href='index.php?messages=inbox'>Входящие</a> 
			| <a href='index.php?messages=outbox'>Исходящие</a></span></center><br>";
	
		/**
		 * Проверяем что показывать (входящие или исходящие)
		 * @param  $getMessage  делаем запрос к определённой таблице
		 * @param меняем название заголовка в зависимости от выбранного типа сообщений
			*/
		if ($_GET['messages'] == "inbox") {
			$getMessages = $this->privateMessagesInboxModel->getInboxPrivateMessagesByUserId($_SESSION['id_user']);
			$mess = "Входящие";
			$colName = "От кого";
			$button = "<a href='index.php?action=sendMsg'>
			 	<input type='button' class='send_message_button' value='Написать сообщение'></a>";
		}
		else if ($_GET['messages'] == "outbox"){
			$getMessages = $this->privateMessagesOutboxModel->getOutboxPrivateMessagesByUserId($_SESSION['id_user']);
			$mess = "Исходящие";
			$colName = "Кому";
		}
		echo "<center><h3>".$mess."</h3></center>";
		echo "<center><table class='message_table'><tr id='tr_header'>
				<td width='1%'>№</td><td width='25%'>".$colName."</td>
				<td width='50%'>Тема</td>
				<td>Дата</td></tr>";
		/**
		 * @param $id_box ID сообщения
		 * @param $name логин юзера отправителя(получателя)
		 * @param $theme тема сообщения
		 * @param $date дата сообщенрия
		 * @param $isRead читалось ли сообщение
		 */
		foreach($getMessages as $number=>$row) {
			if ($_GET['messages'] == "inbox") {
				$id_box = $row['id_private_message_inbox'];
				$user = $this->usersModel->getUserLoginById($row['id_user_send']);
				$theme = $row['theme'];
				$date = $row['date'];
				$href = "index.php?action=readMsg&id_inbox_msg=".$id_box."";
				if ($this->privateMessagesInboxModel->checkPrivateMessageIsRead($id_box) == false) {
					$isRead = "nonread";
				}
				else $isRead = "";
			}
			else {
				$id_box = $row['id_private_message_outbox'];
				$user = $this->usersModel->getUserLoginById($row['id_user_get']);
				$theme = $row['theme'];
				$date = $row['date'];
				$href = "index.php?action=readMsg&id_outbox_msg=".$id_box."";
			}
			echo "<tr id ='".$isRead."'><td>".($number+1)."</td>
				<td><div id='div".($number+1)."' style='display:{$display}'>".$user."</div></td>
					<td><a href='".$href."'>".$theme."</a></td>
					<td>".$date."</td></tr>";
		}
		echo "</table></center>";
		echo "<br><center>".$button."</center>";
	}
	/**
	 *
	 * Блок чтения личных сообщений
	 */
	public function getMessagesReadContent() {
		if (isset($_GET['id_outbox_msg'])) {
			$id_outbox = $_GET['id_outbox_msg'];
			/**
			 * Ставим что пользователь прочитал сообщение
			 */
			//$this->privateMessagesInboxModel->setIsRead($id_inbox);
				
			$id_user_send = $this->privateMessagesOutboxModel->getUserSendByMessageId($id_outbox);
			$from = $this->usersModel->getUserLoginById($id_user_send);
				
			$id_user_get = $this->privateMessagesOutboxModel->getUserGetByMessageId($id_outbox);
			$to = $this->usersModel->getUserLoginById($id_user_get);
				
			$theme = $this->privateMessagesOutboxModel->getThemeByMessageId($id_outbox);
				
			$message = $this->privateMessagesOutboxModel->getMessageByMessageId($id_outbox);
		}
		else {
			$id_inbox = $_GET['id_inbox_msg'];
			/**
			 * Ставим что пользователь прочитал сообщение
			 */
			$this->privateMessagesInboxModel->setIsRead($id_inbox);
	
			$id_user_send = $this->privateMessagesInboxModel->getUserSendByMessageId($id_inbox);
			$from = $this->usersModel->getUserLoginById($id_user_send);
	
			$id_user_get = $this->privateMessagesInboxModel->getUserGetByMessageId($id_inbox);
			$to = $this->usersModel->getUserLoginById($id_user_get);
	
			$theme = $this->privateMessagesInboxModel->getThemeByMessageId($id_inbox);
	
			$message = $this->privateMessagesInboxModel->getMessageByMessageId($id_inbox);
		}
		echo "<h5>От кого - <span id='from'>".$from."</span></h5>";
		echo "<h5>Кому - <span id='from'>".$to."</span></h5>";
		echo "<h5>Тема - <span id='from'>".$theme."</span></h5><br>";
		echo "<center><h3>Сообщение</h3></center>";
		echo "<center><table id='message'><tr><td>".$message."</td></td></table></center>";
	
		echo "<center><h3>Быстрый ответ</h3></center>";
		echo "<center><form method='POST'><textarea id='msg_textarea' name='text'></textarea><br><br>
					<input type='submit' class='button' value='Отправить'></form></center>";
		$this->sendMessage();
	}
	/**
	 *
	 * Отправка сообщений
	 */
	public function getMessageSendingContent() {
		echo "<center><h2>Новое сообщение</h2></center><br><br>";
		echo "<center><form method='POST'>
				<h3>Кому</h3> <input type='text' name='to' id='msg_to'><br><br>
				<h3>Тема</h3> <input type='text' name='theme' id='msg_theme'><br><br>
				<h3>Сообщение</h3><textarea id='msg_textarea' name='text'></textarea><br><br>
					<input type='submit' class='button' value='Отправить'></form></center>";
		$this->sendMessage();
	}
	/**
	 *
	 * Отправка сообщений
	 */
	public function sendMessage() {
		/**
		 * Отправка сообщений из чтения входящего сообщения
		 */
		if (isset($_GET['action']) && $_GET['action'] == "readMsg" &&
		isset($_GET['id_inbox_msg']) &&
		isset($_POST['text']) && $_POST['text'] != '') {
			$text = $_POST['text'];
			$id = $_GET['id_inbox_msg'];
			$to = $this->privateMessagesInboxModel->getUserSendByMessageId($id);
			$theme = $this->privateMessagesInboxModel->getThemeByMessageId($id);
			$this->privateMessagesInboxModel->addPrivateMessage(
				$_SESSION['id_user'], $to, $theme, $text);
			$this->privateMessagesOutboxModel->addPrivateMessage(
				$_SESSION['id_user'], $to, $theme, $text);
			echo "<script>alert('Сообщение успешно послано');
											window.location = 'index.php?messages=outbox';</script>";
		}
		/**
		 * Отправка сообщения из чтения исходящего сообщения
		 */
		else {
			if (isset($_GET['action']) && $_GET['action'] == "readMsg" &&
			isset($_GET['id_outbox_msg']) &&
			isset($_POST['text']) && $_POST['text'] != '') {
				$text = $_POST['text'];
				$id = $_GET['id_outbox_msg'];
				$from = $_SESSION['id_user'];
				$to = $this->privateMessagesOutboxModel->getUserGetByMessageId($id);
				$theme = $this->privateMessagesOutboxModel->getThemeByMessageId($id);
				$this->privateMessagesOutboxModel->addPrivateMessage(
				$from, $to, $theme, $text);
				$this->privateMessagesInboxModel->addPrivateMessage(
				$from, $to, $theme, $text);
			}
		}
		/**
		 * Отправка сообщения из главной страницы личных сообщений
		 */
		if (isset($_POST['to']) && $_POST['to'] != '' && isset($_POST['theme']) && $_POST['theme'] != '' &&
		isset($_POST['text']) && $_POST['text'] != '') {
	
			$from = $_SESSION['id_user'];
			$to = $this->usersModel->getUsersIdByLogin($_POST['to']);
			$theme = $_POST['theme'];
			$text = $_POST['text'];
			if ($this->usersModel->checkUserExistsByUserLogin($_POST['to']) == false) {
				echo "<script>alert('Пользователя с таким именем не существует')</script>";
			}
			else {
				$this->privateMessagesInboxModel->addPrivateMessage($from, $to, $theme, $text);
				$this->privateMessagesOutboxModel->addPrivateMessage($from, $to, $theme, $text);
				echo "<script>alert('Сообщение успешно послано');
								window.location = 'index.php?messages=outbox';</script>";
			}
		}
		else {
			if (isset($_POST['to']) && $_POST['to'] == '') {
				echo "<script>alert('Вы не ввели кому отправить')</script>";
			}
			else if (isset($_POST['theme']) && $_POST['theme'] == '') {
				echo "<script>alert('Вы не ввели тему')</script>";
			}
			else if (isset($_POST['text']) && $_POST['text'] == '') {
				echo "<script>alert('Вы не ввели текст сообщения')</script>";
			}
	
		}
	}
	/**
	 * 
	 * Получаем количество непрочитанных сообщений
	 */
	public static function getUnreadAmount() {
//		return $this->privateMessagesInboxModel->getUnreadAmount($_SESSION['id_user']);
	}
}
?>