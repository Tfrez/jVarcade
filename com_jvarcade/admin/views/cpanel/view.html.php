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

//jimport('joomla.application.component.view');

class jvarcadeViewCpanel extends JViewLegacy {

	function display($tpl = null) {
		
		$mainframe = JFactory::getApplication('site');
		$model = $this->getModel();
		
		$task = $mainframe->input->get('task', 'cpanel');
		$this->assignRef('task', $task);
		
		// config
		$config = $model->getConfObj();
		$this->assignRef('config', $config);
		
		// stats
		$games_count = $model->getGamesCount();
		$this->assignRef('games_count', $games_count);
		$scores_count = $model->getScoresCount();
		$this->assignRef('scores_count', $scores_count);
		$latest_scores = $model->getLatestScores();
		$this->assignRef('latest_scores', $latest_scores);
		$latest_games = $model->getLatestGames();
		$this->assignRef('latest_games', $latest_games);
		
		// tabs
		jimport('cms.html.bootstrap');
		$this->slidesOptions = array(
				
				"toggle" => true, );
		
		
		// plugin checks
		$sysplg_installed = JPluginHelper::isEnabled('system', 'jvarcade');
		$this->assignRef('sysplg_installed', $sysplg_installed);
		if (!$sysplg_installed) {
			$mainframe->enqueueMessage(JText::_('COM_JVARCADE_PLUGINS_WARNING'), 'error');
		}
		$plugins = JPluginHelper::getPlugin('puarcade');
		$this->assignRef('plugins', $plugins);
		
		// changelog
		$changelog = $model->getChangeLog();
		$this->assignRef('changelog', $changelog);
		
		JToolBarHelper::title(JText::_('COM_JVARCADE_CPANEL'), 'cpanel');
		
		$dashboard_buttons = array (
			'SETTINGS' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=settings'),
				'icon' => 'config.png',
				'label' => JText::_('COM_JVARCADE_SETTINGS')
			),
			'MANAGE_SCORES' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=manage_scores'),
				'icon' => 'doc_48.png',
				'label' => JText::_('COM_JVARCADE_MANAGE_SCORES')
			),
			'MANAGE_FOLDERS' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=manage_folders'),
				'icon' => 'folder.png',
				'label' => JText::_('COM_JVARCADE_MANAGE_FOLDERS')
			),
			'MANAGE_GAMES' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=manage_games'),
				'icon' => 'games2.png',
				'label' => JText::_('COM_JVARCADE_MANAGE_GAMES')
			),
			'UPLOAD_ARCHIVE' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=upload_archive'),
				'icon' => 'upload_zip.png',
				'label' => JText::_('COM_JVARCADE_UPLOAD_ARCHIVE')
			),
			'MAINTENANCE' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=maintenance'),
				'icon' => 'maintenance.png',
				'label' => JText::_('COM_JVARCADE_MAINTENANCE')
			),
			'CONTENT_RATINGS' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=content_ratings'),
				'icon' => 'contests.png',
				'label' => JText::_('COM_JVARCADE_CONTENT_RATINGS')
			),
			'CONTESTS' => array(
				'link' => JRoute::_('index.php?option=com_jvarcade&task=contests'),
				'icon' => 'content_rating.png',
				'label' => JText::_('COM_JVARCADE_CONTESTS')
			),
			'SUPPORT' => array(
				'link' => 'http://www.jvitals.com/support/support-forum/default-forum/14-jvarcade.html',
				'icon' => 'user_48.png',
				'label' => JText::_('COM_JVARCADE_SUPPORT'),
				'target' => '_blank'
			),
		);
		$this->assignRef('dashboard_buttons', $dashboard_buttons);
		
		parent::display($tpl);
	}
	

}
