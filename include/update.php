<?php
session_write_close();
require_once("database_config.php");
require_once('class/class.MySQL.php');
require_once("get.php");
class update{
	var $get;
	var $sql;
	function __construct(){
		$this->sql = new MySQL(DBName,DBUser,DBPassword,"",HostName);
		$this->get = new get();
	}
	
	//accept chat by admin user
	function acceptChat($chat_id){
		return $this->sql->Update("chats", array("accepted"=>1), array("id"=>$chat_id));
	}
	
	//close chat by admin user
	function closeChat($chat_id){
		$this->sql->Update("chats",array("status"=>0), array("id"=>$chat_id));
		return $this->sql->Update("guests",array("request"=>0), array("request"=>$chat_id));
	}
	
	//update chat new message status
	function chatNewMessage($chat_id){
		return $this->sql->Update("chats",array("newmessage"=>1), array("id"=>$chat_id));
	}
	
	//update chat admin typing status
	function chatTyping($chat_id,$typing){
		static $result;
		$typing_status = $this->get->getTyping($chat_id);
		switch($typing_status){
			case 0:
				switch($typing){
					case 0:
						$result = 0;
						break;
					case 1:
						$result = 1;
						break;
					case 2:
						$result = 0;
						break;
					case 3:
						$result = 2;
						break;
				}
				break;
			case 1:
				switch($typing){
					case 0:
						$result = 1;
						break;
					case 1:
						$result = 1;
						break;
					case 2:
						$result = 1;
						break;
					case 3:
						$result = 2;
						break;
				}
				break;
			case 2:
				switch($typing){
					case 0:
						$result=2;
					break;
					case 1:
						$result=3;
						break;
					case 2:
						$result=0;
						break;
					case 3:
						$result=2;
						break;
				}
				break;
			case 3:
				switch($typing){
					case 0:
						$result = 2;
					break;
					case 1:
						$result = 3;
						break;
					case 2:
						$result = 1;
						break;
					case 3:
						$result = 3;
						break;
				}
				break;
		}
		$this->sql->Update("chats", array("typing"=>$result), array("id"=>$chat_id));
		return $result;
	}
	
	//update message seen status
	function messageSeen($message_id){
		return $this->sql->Update("chathistory", array("seen"=>1), array("id"=>$message_id));
	}
	
	//update message requested status
	function messageRequested($message_id){
		return $this->sql->Update("chathistory", array("requested"=>1), array("id"=>$message_id));
	}
	
	//update chat request status of guest
	function updateGuestChatRequest($guest_id, $chat_id){
		return $this->sql->Update("guests", array("request"=>$chat_id), array("id"=>$guest_id));
	}
}