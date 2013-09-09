<?php
require_once("../livesupport/include/functions.php");
require_once("../livesupport/include/insert.php");
require_once("../livesupport/include/get.php");
require_once("../livesupport/include/update.php");

$insert = new insert();
$get = new get();
$update = new update();

if($_GET or $_POST){
	switch($_REQUEST["target"]){
		case "support_logo":
			header("Pragma: no-cache");
			header("cache-Control: no-cache, must-revalidate"); // HTTP/1.1
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
			header('Content-type: image/gif');
			$content = file_get_contents("http://localhost/livesupport/assets/images/online.png");
			exit($content);
			break;
		case "status":
			header('Content-Type: text/javascript; charset=utf-8');
			$guest_id = $insert->insertGuest();
			$guest = $get->getGuest($guest_id);
			$chat_id = $guest["request"];
			static $messages = array();
			$last_message_time = $get->getLastMessageTime($chat_id);
			$ajax_message_time = $_GET["datetime"];
			if($ajax_message_time<$last_message_time){
				$messages = $get->getChatNewMessages($ajax_message_time, $chat_id);
			}
			$typing = $update->chatTyping($chat_id,$_GET["typing"]);
			$json = array("guest_id"=>$guest_id, "request" => $chat_id, "messages"=>$messages,
					"datetime"=>$last_message_time,"last_time"=>$ajax_message_time,
					"typing"=>$typing
					);
			if(isset($_GET["callback"]))
				exit($_GET["callback"]."(".json_encode($json).")");
			else
				exit(json_encode($json));
			break;
		case "admin":
			header('Content-Type: text/javascript; charset=utf-8');
			$json_data = json_decode($_GET["chats_status"]);
			static $chats_status = array();
			foreach($json_data as $chat){
				$typing_status = $update->chatTyping($chat[0], $chat[1]);
				array_push($chats_status,array("chat"=>$chat[0], "typing"=>$typing_status));
			}
			$typing_status = $update->chatTyping($chat_id, $typing);
			$json = array("chats"=>$chats_status);
			if(isset($_GET["callback"]))
				exit($_GET["callback"]. "(".json_encode($json).")");
			else 
				exit(json_encode($json));		
	}
}