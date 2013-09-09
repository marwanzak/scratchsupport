<div id="guest_chat_dialog">
<div id="guest_chat_container">
<div id="guest_chat_box">

</div>
<form action="{$base_url}include/json.php" method="post" id="send_message_form">
<input type="hidden" name="chat_id"/>
<input type="hidden" name="username" value="-1"/>
<input type="hidden" name="target" value="sendmessage"/>
<textarea class="form-control" rows="3" name="message"></textarea>
<input type="submit" class="btn btn-primary" />
</form>
</div>
</div>