<?php
/**
 * @package DJ-Extensions-Example-module
 * @copyright Copyright (C) DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email artur.kaczmarek@design-joomla.eu
 */

namespace DJExtensions\YOOessentials\YOOtheme;

defined('_JEXEC') or die;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;
use YOOtheme\Url;
use function YOOtheme\app;

class ConfigListener
{
	public static function initCustomizer(Config $config, Metadata $metadata)
	{
		//Add settings as custom panel for YooTheme Builder
		$config->addFile('customizer',Path::get('../assets/json/config.json'));
	}
}
