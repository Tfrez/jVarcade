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

jimport('joomla.application.component.view');

class jvarcadeVieweditcontest extends JViewLegacy {

	function display($tpl = null) {
		
		$model = $this->getModel();
		$mainframe = JFactory::getApplication();
		$task = $mainframe->input->get('task', 'editcontest');
		$this->assignRef('task', $task);

		$contestid = JRequest::getVar('id', 0);
		if (is_array($contestid)) $contestid = $contestid[0];
		
		if ($task == 'addcontest') {
			$contest = new stdClass();
			$contest->id = 0;
			$contest->name = '';
			$contest->description = '';
			$contest->imagename = '';
			$contest->startdatetime = '';
			$contest->enddatetime = '';
			$contest->islimitedtoslots = 0;
			$contest->minaccesslevelrequired = 0;
			$contest->published = 0;
			$contest->hasadvertisedstarted = 0;
			$contest->hasadvertisedended = 0;
			$contest->maxplaycount = 0;
		} else {
			$contest = $model->getContests((int)$contestid);
			if (is_array($contest)) $contest = $contest[0];
		}
		$this->assignRef('contest', $contest);
		
		$editor = JFactory::getEditor();
		$this->assignRef('editor', $editor);
		$editor_params = array('mode' => 'advanced');
		$this->assignRef('editor_params', $editor_params);
		
		$upimage = ($task == 'addcontest' ? JText::_('COM_JVARCADE_CONTESTS_NEWIMAGE') : JText::_('COM_JVARCADE_CONTESTS_CHIMAGE'));
		$upimage_desc = ($task == 'addcontest' ? JText::_('COM_JVARCADE_CONTESTS_NEWIMAGE_DESC') : JText::_('COM_JVARCADE_CONTESTS_CHIMAGE_DESC'));
		$this->assignRef('upimage', $upimage);
		$this->assignRef('upimage_desc', $upimage_desc);
		
		JToolBarHelper::title(($task == 'addcontest' ? JText::_('COM_JVARCADE_CONTESTS_NEWCONTEST') : $contest->name), 'jvacontests');
		JToolBarHelper::custom('contests', 'cancel.png', 'cancel.png', JText::_('COM_JVARCADE_CONTESTS_CANCEL'), false, false);
		JToolBarHelper::save('savecontest', JText::_('COM_JVARCADE_CONTESTS_SAVE'));			
		JToolBarHelper::apply('applycontest', JText::_('COM_JVARCADE_CONTESTS_APPLY'));			
		
		
		parent::display($tpl);
	}
	
}
