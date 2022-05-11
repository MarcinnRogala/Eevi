<?php /* Smarty version Smarty-3.1.19, created on 2022-05-10 12:52:45
         compiled from "C:\wamp64\www\Projekty\Eevi\admin097s289j7\themes\default\template\helpers\list\list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:402204262627a43fde9b8d8-92056641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a62da80086537bbda92888d5f795d3e7e4dae6ef' => 
    array (
      0 => 'C:\\wamp64\\www\\Projekty\\Eevi\\admin097s289j7\\themes\\default\\template\\helpers\\list\\list_action_view.tpl',
      1 => 1556635332,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '402204262627a43fde9b8d8-92056641',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_627a43fdea16e6_22559874',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_627a43fdea16e6_22559874')) {function content_627a43fdea16e6_22559874($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" >
	<i class="icon-search-plus"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a>
<?php }} ?>
