$(document).ready(function() {
	
	
	// get alll chats
	getChats("#chats_nav");
	//getNotRequestedMessages();
	// show active and accepted chat for admin users
	getAcceptedActiveChats();
	//getAcceptedActiveHistory();
	getChatReview();
	// get alll chats refreshed in seconds
/*	setInterval(function() {
		getChats("#chats_nav");
		getNotRequestedMessages();
	}, 3000);
*/
	
	//on press enter when typing send the message
	$(".chat_panel textarea[name=message]").keypress(function(e){
		 var code = (e.keyCode ? e.keyCode : e.which);
		 if(code == 13) { 
			 $("#chat_form_"+this.id.substring(10)).submit();
		 }
	});
	
	
	$("#chats_nav").on("click", ".chat_btn", function() {
		var this_chat_id = this.id.substring(5);
		acceptChat(this_chat_id);
		$("#admin_chat_dialog_" + this_chat_id).dialog("open");
	});
	
	$("#chats_nav").on("click", ".chat_div", function(){
		var this_chat_id = this.id.substring(10);
		$("#admin_chat_dialog_" + this_chat_id).dialog("open");

	});
	
	$("#chats_nav").on("click", ".chat_close",function(){
		$(this).parent().hide();
	});

	// close chat by admin
	$("#chats_nav").on("click", ".chat_close", function() {
		closeChat(this.id.substring(11));
	});

	// send message by guest
	$("body").on("submit", "form.chat_form", function(evt) {
		evt.preventDefault();
		sendMessage("#" + this.id);
		$(this).find("textarea").val("");
		return false;
	});

});

//get guest new messages
function getStatus() {
	var chats = $(".chat_text");
	var chats_array = new Array();
	for(var i=0; i<chats.length; i++){
		var chat = {chats[i].id.substring(10):(chats[i].value==""?0:1)};
		chats_array.push(chat);
	}
	var chats_json = JSON.parse(chats_array);
	var script = document.createElement('script');
	script.src = base_url
			+ "status.php?target=admin&callback=&chats="+chats_json;
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
