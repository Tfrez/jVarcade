<?php
/**
 * @package		jVArcade
* @version		2.12
* @date		2014-05-17
* @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
* @link		http://jvitals.com
*/



// no direct access
defined('_JEXEC') or die('Restricted access');

class jvarcadeModelProfile extends jvarcadeModelCommon {
	
	
	public function saveAchievement($user_id, $gid, $gtitle, $achtitle, $achdesc, $achicon, $pts) {
		$query = 'INSERT IGNORE INTO #__jvarcade_achievements (userid, gameid, gametitle, title, description, icon_url, points) VALUES ('. $this->dbo->Quote((int)$user_id) .','. $this->dbo->Quote((int)$gid) .',
				'. $this->dbo->Quote($gtitle) .','. $this->dbo->Quote($achtitle) .','. $this->dbo->Quote($achdesc) .','. $this->dbo->Quote($achicon) .','. $this->dbo->Quote((int)$pts) .')';
		$this->dbo->setQuery($query);
		$this->dbo->execute();
		$dispatcher = JEventDispatcher::getInstance();
		// trigger the achievement saved event
		$dispatcher->trigger('onJVAAchievementSaved', array($user_id, $gid, $gtitle, $achtitle, $achdesc, $achicon, $pts));
	}
	
	public function getUserAchievements($user_id) {
		$query = 'SELECT * FROM #__jvarcade_achievements WHERE userid =' . $user_id;
		$this->dbo->setQuery($query);
		$user_achieve = $this->dbo->loadAssocList();
		return $user_achieve;
	}
	

}

?>