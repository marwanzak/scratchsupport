$(document).ready(
		function() {
			getChatHistory();
			// Session.set("chat_id",1);
			// setInterval(function(){alert(Session.get("chat_id"));},2000);
			getNewMessages();
			// request new chat by guest.
			$("#guest_start_chat_btn").on("click", function() {
						if (chat_id == null || chat_id == 0) {
							$.ajax({
								url : base_url + "include/guestjson.php",
								data : {
									"target" : "newchat",
									"guest_id" : guest_id
								},
								type : "get",
								success : function(data) {
									$("#send_message_form input[name=chat_id]")
											.val(data);
									chat_id = data;
								}
							});
						}
					});
			// send message by guest
			$("#send_message_form").on("submit" ,
					function(evt) {
						evt.preventDefault();
						sendMessage("#send_message_form");
						$(this).find("textarea").val("");
						return false;
					});

		});

var datetime = null;
var chat_id = null;
var guest_id = null;
function guestStatus(){
	
}
// get guest new messages
function getNewMessages() {
	var typing = ($("#send_message_form textarea").val()==""?2:3);
	var script = document.createElement('script');
	script.src = base_url
			+ "status.php?target=status&callback=handleStatus&datetime="+datetime+"&chat_id="+chat_id+"&typing="+typing;
	script.className = "jsonp_script";
	document.getElementsByTagName('head')[0].appendChild(script);
	setTimeout(function() {
		getNewMessages();
	}, 3000);
}

// show the new message in guest chat box.
function handleStatus(data) {
	guest_id = data.guest_id;
	chat_id = data.request;
	datetime = data.datetime;
	$("#send_message_form input[name=chat_id]").val(data.request);
	if(data.messages.length>0){
		for(var i=0;i<data.messages.length;i++)
		inputGuestMessage(data.messages[i].message);
	}
	$("head .jsonp_script").remove();
}

//get chat history
function getChatHistory(){
	if(chat_id!=null && chat_id!=0){
		$.ajax({
			url:base_url+"include/guestjson.php",
			data:{"target":"chathistory","chat_id":chat_id},
			type:"get",
			dataType:"json",
			success:function(data){
				if(data.messages.length>0){
					for(var i=0; i<data.messages.length; i++){
						inputGuestMessage(data.messages[i].message);
					}
				}
				clearTimeout(chat_history);
			}
		});
	}
	else
		var chat_history = setTimeout(function(){
		getChatHistory();
	},2000);
}