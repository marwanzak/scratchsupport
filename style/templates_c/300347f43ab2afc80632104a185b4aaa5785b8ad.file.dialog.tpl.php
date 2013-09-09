<?php /* Smarty version Smarty-3.1.12, created on 2013-09-06 12:53:13
         compiled from "C:\xampp\htdocs\livesupport\style\templates\dialog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:298815224ea0908b838-06931870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '300347f43ab2afc80632104a185b4aaa5785b8ad' => 
    array (
      0 => 'C:\\xampp\\htdocs\\livesupport\\style\\templates\\dialog.tpl',
      1 => 1378464785,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '298815224ea0908b838-06931870',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5224ea0908e349_81805600',
  'variables' => 
  array (
    'base_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5224ea0908e349_81805600')) {function content_5224ea0908e349_81805600($_smarty_tpl) {?><div id="guest_chat_dialog">
<div id="guest_chat_container">
<div id="guest_chat_box">

</div>
<form action="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
include/json.php" method="post" id="send_message_form">
<input type="hidden" name="chat_id"/>
<input type="hidden" name="username" value="-1"/>
<input type="hidden" name="target" value="sendmessage"/>
<textarea class="form-control" rows="3" name="message"></textarea>
<input type="submit" class="btn btn-primary" />
</form>
</div>
</div><?php }} ?>