<?php /* Smarty version Smarty-3.1.12, created on 2013-09-06 13:31:24
         compiled from "C:\xampp\htdocs\livesupport\style\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2667952242843b34ac7-99982175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fd910c805a627614db9bd98c2ca1093b834b5a0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\livesupport\\style\\templates\\index.tpl',
      1 => 1378467082,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2667952242843b34ac7-99982175',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_52242843b99f03_64608384',
  'variables' => 
  array (
    'base_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52242843b99f03_64608384')) {function content_52242843b99f03_64608384($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("page_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("page_body.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("page_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<img src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
status.php?target=support_logo"/>
</body>
</html>
<?php }} ?>