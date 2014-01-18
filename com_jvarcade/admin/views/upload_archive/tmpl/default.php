<?php
/**
 * @package		jVArcade
 * @version		2.1
 * @date		2014-01-12
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

?>
<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif;?>
<script language="JavaScript">
	
	function setinstalltype(t) {
		var installtype = document.getElementById('installtype_fld');
		installtype.value = t;
	}
	
	function checkInstallForm(form) {
		if (form.installtype.value == 'upload') {
			if (form.install_package.value == '') {
				alert('<?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_PLEASE_SELECT_FILE'); ?>');
				return false;
			}
		} else if (form.installtype.value == 'folder') {
			if (form.install_directory.value == '') {
				alert('<?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_PLEASE_SELECT_DIR'); ?>');
				return false;
			}
		}
		return true;
	}
	
	jQuery(document).ready(function($) {
		jQuery('#install_package_but').click(function() { setinstalltype('upload'); });
		jQuery('#install_directory_but').click(function() { setinstalltype('folder'); });
	});
</script>

<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="adminForm" id="adminForm" method="post" onsubmit="return checkInstallForm(this);" >
	<input type="hidden" name="field_save" value="1" />
	<input type="hidden" name="option" value="com_jvarcade" />
	<input type="hidden" name="task" value="doInstall" />
	<input type="hidden" name="installtype" id="installtype_fld" value="upload" />
	<input type="hidden" name="boxchecked" value="0" />
	<table>
	<tr>
	<td width = 60% valign = top padding = 5px>
	<div style="float:left;">
		<fieldset class="adminform">
			<table class="adminform">
				<tr>
					<td class="key"><label for="folderid"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_FOLDER'); ?></label></td>
					<td><?php echo $this->list_folders();?></td>
				</tr>
				<tr>
					<td class="key"><label for="published"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_PUBLISHED'); ?></label></td>
					<td><?php echo JHTML::_('jvarcade.html.booleanlist',  'published', 'class="inputbox" size="1"', $this->published);?></td>
				</tr>
			</table>
			<table>
				<th><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_CHOOSE'); ?></th>
			</table>
			<table class="adminform">
				<tr><th><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_UPLOAD_FILE'); ?></th></tr>
				<tr><td><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_FILE_DESC'); ?></td></tr>
				<tr>
					<td>
						<input class="input_box" id="install_package" name="install_package" type="file" size="57" />
						<button class="btn btn-primary" type="submit" id="install_package_but" onclick="setinstalltype('upload');"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_UPLOAD_BUTTON'); ?></button>
					</td>
				</tr>
			</table>
			<table class="adminform">
				<tr><th><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_INSTALL_FROM_DIR'); ?></th></tr>
				<tr><td><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_INSTALL_FROM_DIR_DESC'); ?></td></tr>
				<tr>
					<td>
						<input type="text" id="install_directory" name="install_directory" class="input_box" size="70" value="<?php echo $this->tmp_path; ?>" />
						<button class="btn btn-primary" type="submit" id="install_directory_but" onclick="setinstalltype('folder');"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_INSTALL_BUTTON'); ?></button>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	</td>
	<td>
	<div style="float:right;">
		<fieldset class="adminform">
		<h5><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_LEGEND_TITLE'); ?></h5>
		<?php echo $this->legend; ?>
		</fieldset>
	</div>
	</td>
	</tr>
	</table>
	<div class="clr"></div>
</form>