// get all active chats and put buttons in chats nav for admin
function getChats(chatsnav) {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "getchats"
		},
		type : "get",
		dataType : "json",
		success : function(data) {
			$(chatsnav).html("");
			if (data == 1) {
				return false;
			} else if (data.length > 0) {
				for ( var i = 0; i < data.length; i++) {
					$("<div/>").prop("id", "chat_div_" + data[i].id).prop(
							"class", "chat_div").appendTo(chatsnav);
					$("<a/>").addClass("btn").addClass(
							(data[i].accepted == 1) ? "btn-success"
									: "btn-danger").addClass("chat_btn").text(
							data[i].name).prop("id", "chat_" + data[i].id)
							.appendTo("#chat_div_" + data[i].id);

					$("<span/>").addClass("close").addClass("chat_close").prop(
							"aria-hidden", "true").prop("id",
							"chat_close_" + data[i].id).html("&times;")
							.appendTo("#chat_div_" + data[i].id);
				}
			}
		}
	});
	return false;
}

// accept chat by admin
function acceptChat(chat_id) {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "acceptchat",
			"chat_id" : chat_id
		},
		type : "get",
		dataType : "json",
		async : false,
		success : function(data) {

			return false;
		}
	})
	return false;
}

// close chat by admin
function closeChat(chat_id) {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "closechat",
			"chat_id" : chat_id
		},
		type : "get",
		dataType : "json",
		async : false,
		success : function(data) {
			return false;
		}
	});
	return false;
}

// send message from form inputs
function sendMessage(send_form) {
	$.ajax({
		url : base_url + "include/json.php",
		data : $(send_form).serialize(),
		type : "post",
		dataType : "json",
		success : function(data) {
			return false;
		}
	});
	return false;
}

// input message in chat box
function inputMessage(chat_id, message) {

	$("<label/>").text(message).appendTo("<div/>").appendTo(
			"#chat_box_" + chat_id);

	$("<br/>").appendTo("#chat_box_" + chat_id);
}

function inputGuestMessage(message) {
	$("<label/>").text(message).appendTo("<div/>").appendTo("#guest_chat_box");

	$("<br/>").appendTo("#guest_chat_box");
}

function createChatDialog(chat_id) {
	$("<div/>").addClass("admin_chat_dialog").prop("id",
			"admin_chat_dialog_" + chat_id).appendTo("body");
	$("<div/>").prop("id", "chat_box_" + chat_id).addClass("chat_box")
			.appendTo("div#admin_chat_dialog_" + chat_id);

	$("<div/>").prop("id", "chat_panel_" + chat_id).addClass("chat_panel")
			.appendTo("div#admin_chat_dialog_" + chat_id);

	$("<form/>").prop("id", "chat_form_" + chat_id).addClass("chat_form").prop(
			"action", base_url + "include/json.php").prop("method", "post")
			.appendTo($("div#admin_chat_dialog_" + chat_id + " div").last());

	$("<input/>").prop("type", "hidden").prop("name", "chat_id").val(chat_id)
			.appendTo("form#chat_form_" + chat_id);

	$("<input/>").prop("type", "hidden").prop("name", "target").val(
			"sendmessage").appendTo("form#chat_form_" + chat_id);

	$("<div/>").addClass("form-group").appendTo("form#chat_form_" + chat_id);

	$("<textarea/>").prop("id", "chat_text_" + chat_id).prop("name", "message")
			.addClass("chat_text form-control").appendTo(
					$("div#admin_chat_dialog_" + chat_id + " div").last());

	$("<div/>").addClass("form-group").appendTo("form#chat_form_" + chat_id);

	$("<input/>").prop("type", "submit").val("Send")
			.addClass("btn btn-primary").appendTo(
					$("div#admin_chat_dialog_" + chat_id + " div").last());

	$("div#admin_chat_dialog_" + chat_id).dialog({
		autoOpen : false,
		draggable : true,
		resizable : true,
		width : 400,
		height : 500
	});
}

// get active and accepted chats and create them for admin user
function getAcceptedActiveChats() {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "acceptedactivechats"
		},
		async : false,
		type : "get",
		dataType : "json",
		success : function(data) {
			for ( var i = 0; i < data.length; i++) {
				createChatDialog(data[i].id);
			}
		}
	});
	return false;
}

// get chat history of all active and accepted chats chats
function getNotRequestedMessages() {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "notrequestedmsgs"
		},
		type : "get",
		dataType : "json",
		success : function(data) {
			for ( var i = 0; i < data.length; i++) {

				inputMessage(data[i].chat_id, data[i].message);

				$.ajax({
					url : base_url + "include/json.php",
					data : {
						"target" : "messagerequested",
						"message_id" : data[i].id
					},
					type : "get",
					async : false,
					success : function(data) {
						return false;
					}
				});
			}
		}
	});
	return false;
}

function getAcceptedActiveHistory() {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "acceptedactivehistory"
		},
		async : false,
		type : "get",
		dataType : "json",
		success : function(data) {
			for ( var i = 0; i < data.length; i++) {
				inputMessage(data[i].chat_id, data[i].message);
			}
		}
	});

}

function getChatHistory(chat_id) {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "chathistory",
			"chat_id" : chat_id
		},
		type : "get",
		dataType : "json",
		success : function(data) {
			for ( var i = 0; i < data.length; i++) {
				inputMessage(chat_id, data[i].message);
			}
			return false;
		}
	});
	return false;
}

var chat_ajax = null;
var message_ajax = null;
function getChatReview() {
	$.ajax({
		url : base_url + "include/json.php",
		data : {
			"target" : "chatsreview",
			"chat_ajax" : chat_ajax,
			"message_ajax" : message_ajax
		},
		type : "GET",
		dataType : "json",
		async : true,
		cache : false,
		success : function(data) {
			if (data.messages.messages.length > 0)
				for ( var i = 0; i < data.messages.messages.length; i++) {
					inputMessage(data.messages.messages[i].chat_id,
							data.messages.messages[i].message);
				}

			chat_ajax = data.chats.last;
			message_ajax = data.messages.last;

			setTimeout(function() {
				getChatReview();
			}, 1000);
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			setTimeout(function() {
				getChatReview();
			}, 15000);
		}
	});
}
