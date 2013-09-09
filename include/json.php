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
			$guest = $get->getGuest($_GET["guest"]);
			if($guest["request"]==0){
				$insert->insertChat(array(
						"department"=>1,
						"email"=>1,
						"mobile"=>1,
						"website"=>1,
						"name"=>"Marwan",
				));
				$chat_id = $sql->LastInsertID();
				$update->updateGuestChatRequest($_GET["guest"], $chat_id);
			}
			echo $guest["request"];
			break;

			//get all active chats.
		case "getchats":
			echo json_encode($get->getActiveChats(), JSON_HEX_TAG | JSON_HEX_APOS |
			JSON_HEX_QUOT | JSON_HEX_AMP );
			break;

			//accept chat by admin user
		case "acceptchat":
			echo $update->acceptChat($_GET["chat_id"]);
			break;

			//close chat by admin user
		case "closechat":
			echo $update->closeChat($_GET["chat_id"]);
			break;

			//send message from both guest or admin user
		case "sendmessage":
			echo $insert->sendMessage(array(
			"chat_id"=>$_POST["chat_id"],
			"username"=>(isset($_POST["username"])?$_POST["username"]:1),
			"seen"=>0,
			"message"=>$_POST["message"]
			),"chathistory");
			$update->chatNewMessage($_POST["chat_id"]);
			break;

			//get active and accpted chats
		case "acceptedactivechats":
			echo json_encode($get->getAcceptedActiveChats(), JSON_HEX_TAG | JSON_HEX_APOS |
			JSON_HEX_QUOT | JSON_HEX_AMP );
			break;
			//get chat history
		case "notrequestedmsgs":
			echo json_encode($get->getNotRequestedMessages(), JSON_HEX_TAG | JSON_HEX_APOS |
			JSON_HEX_QUOT | JSON_HEX_AMP );
			break;
			//update message requested status to be requested
		case "messagerequested":
			echo json_encode($update->messageRequested($_GET["message_id"]), JSON_HEX_TAG | JSON_HEX_APOS |
			JSON_HEX_QUOT | JSON_HEX_AMP );
			break;
			//get all history of accepted and active chats
		case "acceptedactivehistory":
			echo json_encode($get->getAcceptedActiveHistory(), JSON_HEX_TAG | JSON_HEX_APOS |
			JSON_HEX_QUOT | JSON_HEX_AMP );
			break;
		case "chathistory":
			echo json_encode($get->getChatHistory(), JSON_HEX_TAG | JSON_HEX_APOS |
			JSON_HEX_QUOT | JSON_HEX_AMP );
			break;
		case "chatsreview":
			$return = array();
			$last_message = $sql->Select("chathistory", '','datetime desc','1');
			$last_chat = $sql->Select("chats", array("status"=>1), 'datetime desc','1');
			$chat_ajax = ($_GET["chat_ajax"]!=null?$_GET["chat_ajax"]:0);
			$message_ajax = ($_GET["message_ajax"]!=null?$_GET["message_ajax"]:0);
			while($message_ajax>=$last_message["datetime"]){
				usleep(10000);
				clearstatcache();
				$last_message = $sql->Select("chathistory", '','datetime desc','1');
				$last_chat = $sql->Select("chats", array("status"=>1), 'datetime desc','1');
			}
			$messages = $get->getNewMessages($message_ajax);
			$return["messages"] = array();
			$return["messages"]["messages"] = $messages;
			$return["messages"]["last"] = $last_message["datetime"];

			$chats = $get->getNewChats($chat_ajax);
			$return["chats"] = array();
			$return["chats"]["chats"] = $chats;
			$return["chats"]["last"] = $last_chat["datetime"];
			echo json_encode($return, JSON_HEX_TAG | JSON_HEX_APOS |
					JSON_HEX_QUOT | JSON_HEX_AMP );
			break;
				
		case "guestmessages":
			$messages_array = $get->getChatNewMessages($_GET["time"], $_GET["chat"]);
		print_r($messages_array);

			break;
		case "typing":
			return $update->chatTyping($_GET["chat_id"],$_GET["typing"]);
	}



}

