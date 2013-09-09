<?php
require_once("database_config.php");
require_once('class/class.MySQL.php');
require_once("functions.php");

class get{
	var $sql;
	var $functions;
	function __construct(){
		$this->sql = new MySQL(DBName,DBUser,DBPassword,"",HostName);
		$this->functions = new functions();
	}

	//get active status chats
	function getActiveChats(){
		$query = $this->sql->Select("chats", array("status"=>1));
		if(is_array($query)){
			if($this->functions->countDim($query)==1)
				return array($query);
			elseif($this->functions->countDim($query)>1)
			return $query;
		} return false;
	}

	//get accepted and active chats
	function getAcceptedActiveChats(){
		$query = $this->sql->Select("chats", array("status"=>1, "accepted"=>1));
		if(is_array($query)){
			if($this->functions->countDim($query)==1)
				return array($query);
			elseif($this->functions->countDim($query)>1)
			return $query;
		} else return false;;
	}

	//get all active and accepted but not requested chats history
	function getNotRequestedMessages(){
		$chats = $this->getAcceptedActiveChats();
		$chats_history = array();
		foreach($chats as $chat){
			$history = $this->sql->Select("chathistory", array("chat_id"=>$chat["id"], "requested"=>"0"));
			if($this->functions->countDim($history)==1)
				array_push($chats_history,$history);
			elseif($this->functions->countDim($history)>1)
			foreach($history as $message)
				array_push($chats_history, $message);
		}
		return $chats_history;
	}

	//get not requested chats
	function getNotRequestedChats(){
		$history = $this->sql->Select("chats", array("requested"=>"0"));
		if($this->functions->countDim($history)==1)
			return array($history);
		elseif($this->functions->countDim($history)>1)
		return $history;
	}

	//get all active and accepted chats history
	function getAcceptedActiveHistory(){
		$chats = $this->getAcceptedActiveChats();
		$chats_history = array();
		foreach($chats as $chat){
			$history = $this->sql->Select("chathistory", array("chat_id"=>$chat["id"]));
			if($this->functions->countDim($history)==1)
				array_push($chats_history,$history);
			elseif($this->functions->countDim($history)>1)
			foreach($history as $message)
				array_push($chats_history, $message);
		}
		return $chats_history;

	}

	//get chat history
	function getChatHistory($chat_id){
		$chat_history = array();
		$query = $this->sql->Select("chathistory", array("chat_id"=>$chat_id));
		if(is_array($query)){
			if($this->functions->countDim($query)==1)
				return array($query);
			elseif($this->functions->countDim($query)>1)
			return $query;
		} else return false;;
	}

	//get chat information
	function getChatsReview(){
		$return = array();
		$new_messages_count = $this->sql->CountRows("chathistory", array("requested" => 0));
		$new_chats = $this->sql->CountRows("chats", array("requested"=>0));
		while($new_messages_count<= 0 && $new_chats <= 0){
			usleep(10000);
			clearstatcache();
			$new_messages_count = $this->sql->CountRows("chathistory", array("requested"=>0));
			$new_chats = $this->sql->CountRows("chats", array("requested"=>0));
		}
		if($new_messages_count>0){
			$messages = $this->getNotRequestedMessages();
			$return["messages"] = $messages;
		}
		if($new_chats>0){
			$chats = $this->getActiveChats();
			$return["chats"] = $chats;
		}
		return $return;
	}

	//get new messages
	function getNewMessages($datetime){
		$query = $this->sql->ExecuteSQL("SELECT message,chat_id FROM ".DBPerfix."chathistory WHERE datetime>{$datetime}");
		if(is_array($query)){
			if($this->functions->countDim($query)==1)
				return array($query);
			elseif($this->functions->countDim($query)>1)
			return $query;
		} else return false;
	}

	//get new guest chat messages
	function getChatNewMessages($datetime, $chat_id){
		$query = $this->sql->ExecuteSQL("SELECT message,datetime FROM ".DBPerfix."chathistory WHERE datetime>{$datetime} AND chat_id={$chat_id}");
		if(is_array($query)){
			if($this->functions->countDim($query)==1)
				return array($query);
			elseif($this->functions->countDim($query)>1)
			return $query;
		} else return false;
	}

	//get new chats
	function getNewChats($datetime){
		$query = $this->sql->Select("SELECT * FROM ".DBPerfix."chats WHERE STATUS=1 AND datetime>{$datetime}");
		if(is_array($query)){
			if($this->functions->countDim($query)==1)
				return array($query);
			elseif($this->functions->countDim($query)>1)
			return $query;
		} else return false;
	}

	//get guest information from database
	function getGuest($id){
		$query = $this->sql->ExecuteSQL("SELECT * FROM ".DBPerfix."guests WHERE id='{$id}'");
		return $query;
	}

	//get time of last message of a chat
	function getLastMessageTime($chat_id){
		$last_message = $this->sql->ExecuteSQL("SELECT datetime FROM chathistory WHERE chat_id={$chat_id} ORDER BY datetime desc LIMIT 1");
		return $last_message["datetime"];
	}
	
	//get admin typing status
	public function getTyping($chat_id){
		$query = "SELECT typing FROM chats WHERE id=".$chat_id;
		$chat = $this->sql->ExecuteSQL($query);
		return $chat["typing"];
	}

}