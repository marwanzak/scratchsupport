<?php
session_write_close();
require_once("database_config.php");
require_once('class/class.MySQL.php');
require_once("functions.php");
require_once("insert.php");
require_once("get.php");
require_once("update.php");
$insert = new insert();
$get = new get();
$update = new update();
$sql = new MySQL(DBName,DBUser,DBPassword,"",HostName);
if($_GET or $_POST){
	switch($_REQUEST["target"]){
		//insert new chat by request from guest
		case "newchat":
			$guest = $get->getGuest($_GET["guest_id"]);
			if($guest["request"]==0){
				$insert->insertChat(array(
						"department"=>1,
						"email"=>1,
						"mobile"=>1,
						"website"=>1,
						"name"=>"Marwan",
				));
				$chat_id = $sql->LastInsertID();
				$update->updateGuestChatRequest($_GET["guest_id"], $chat_id);
			}
			echo $guest["request"];
			break;
		case "newmessages":
			header('Content-Type: text/javascript; charset=utf-8');
			$return = array();
			$return["messages"]=array();
			$messages = null;
			$datetime = ($_GET["datetime"]!=null?$_GET["datetime"]:0);
			$last_message = $sql->ExecuteSQL("SELECT datetime FROM chathistory WHERE chat_id={$_GET['chat_id']} ORDER BY datetime desc LIMIT 1");
			$messages = $get->getNewMessages(0);
			$return["messages"]=$messages;
			$return["datetime"] = $last_message["datetime"];
			exit ($_GET["callback"]."(".json_encode($return).")");
			//exit ("{\"sdfsdf\":\"sdfdf\"}");
			break;
		case "chathistory":
			header('Content-type: application/json');
			static $messages = array();
			$messages_array = $get->getChatHistory($_GET["chat_id"]);
			foreach($messages_array as $message){
				array_push($messages, array("message"=>$message["message"], "datetime"=>$message["datetime"]));
			}
			exit(json_encode(array("messages"=>$messages)));
	}
}