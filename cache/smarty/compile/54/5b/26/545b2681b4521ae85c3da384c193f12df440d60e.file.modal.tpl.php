<?php /* Smarty version Smarty-3.1.19, created on 2022-05-10 10:42:14
         compiled from "C:\wamp64\www\Projekty\Eevi\admin\themes\default\template\helpers\modules_list\modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:39428851627a4186a3dcf0-89921568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '545b2681b4521ae85c3da384c193f12df440d60e' => 
    array (
      0 => 'C:\\wamp64\\www\\Projekty\\Eevi\\admin\\themes\\default\\template\\helpers\\modules_list\\modal.tpl',
      1 => 1556635332,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39428851627a4186a3dcf0-89921568',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_627a4186a45834_76185341',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_627a4186a45834_76185341')) {function content_627a4186a45834_76185341($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
