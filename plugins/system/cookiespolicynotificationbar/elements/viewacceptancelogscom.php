<?php
/* ======================================================
 # Cookies Policy Notification Bar for Joomla! - v4.2.3 (pro version)
 # -------------------------------------------------------
 # For Joomla! CMS (v3.x)
 # Author: Web357 (Yiannis Christodoulou)
 # Copyright (©) 2014-2022 Web357. All rights reserved.
 # License: GNU/GPLv3, http://www.gnu.org/licenses/gpl-3.0.html
 # Website: https:/www.web357.com
 # Demo: https://demo.web357.com/joomla/browse/cookies-policy-notification-bar
 # Support: support@web357.com
 # Last modified: Wednesday 30 March 2022, 03:45:18 PM
 ========================================================= */

defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldviewacceptancelogscom extends JFormField {
	
	protected $type = 'viewacceptancelogscom';

	protected function getInput()
	{
		$html = '';

		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			// j25
			$html .= '<div style="display: block;border: 2px solid red;clear: both;padding: 4px;">This "View Acceptance Logs" feature is not supported anymore in Joomla! 2.5</div>';

		}
		else
		{
			// j3 + j4
			// Buttons: View Logs
			$html .= '<div class="cpnb-acceptance-logs">';
			$html .= '<p>';
			$html .= '<a href="index.php?option=com_cookiespolicynotificationbar&view=logs" class="btn btn-success cpnb-view-acceptance-logs-btn"><strong>'.JText::_('PLG_SYSTEM_CPNB_VIEW_LOGS').'</strong></a>';
			$html .= '</p>';
			$html .= '</div>';
		}
		
		return $html;		
	}
}