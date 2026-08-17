<?php
/**
 * @version $Id: djembedlight.php 5 2015-01-07 16:19:20Z szymon $
 * @package DJ-EmbedLight
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 * DJ-EmbedLight is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-EmbedLight is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-EmbedLight. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die;

class plgContentDJEmbedlight extends JPlugin
{
	/**
	 * Plugin that loads DJ-EmbedLight
	 *
	 */
	public function onContentPrepareForm($form, $data)
	{
		$app = JFactory::getApplication();
		
		if($app->input->get('djembedlight')=='parse') {
			
			$link = urldecode(JRequest::getVar('link'));
			
			echo $this->parseEmbed($link);
			
			$app->close();
		}
		
		$doc = JFactory::getDocument();
		
		$version = new JVersion;
		$jquery = version_compare($version->getShortVersion(), '3.0.0', '>=');
		
		if ($jquery) {
			JHTML::_('jquery.framework');
		} else {
			$doc->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
		}
		
		$doc->addScript(JUri::root(true).'/plugins/content/djembedlight/assets/editor.js');
		
		return true;
	}
	
	private function parseEmbed($link){
		
		$parts = explode('/',$link);
		
		switch($parts[2]) {
			
			case 'www.youtube.com':
			case 'youtube.com':
				$video = array_pop($parts);
				preg_match('/v=([\w\d_-]+)/', $video, $video);
				if(isset($video[1])) return '<img src="//img.youtube.com/vi/'.$video[1].'/hqdefault.jpg" alt="djembed" data-emtype="youtube" data-emlink="//www.youtube.com/embed/'.$video[1].'" />';
				else return $link;
				break;
			
			case 'www.youtu.be':
			case 'youtu.be':
				$id = array_pop($parts);
				return '<img src="//img.youtube.com/vi/'.$id.'/hqdefault.jpg" alt="djembed" data-emtype="youtube" data-emlink="//www.youtube.com/embed/'.$id.'" />';
				break;
			
			case 'vimeo.com':
				$id = array_pop($parts);
				$file = file_get_contents('http://vimeo.com/api/v2/video/'.$id.'.php');
				if(!$file) return $link;
				else {
					$hash = unserialize($file);
					$img = $hash[0]['thumbnail_large']; // thumbnail_large = 640x360
					return '<img src="'.$img.'" alt="djembed" data-emtype="vimeo" data-emlink="//player.vimeo.com/video/'.$id.'" />';
				}
				break;
			default:
				return $link;
		}
		
		return $link;
	}
	
	/**
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The article object.  Note $article->text is also available
	 * @param	object	The article params
	 * @param	int		The 'page' number
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// Don't run this plugin for backend
		$app = JFactory::getApplication();
		if($app->isAdmin()) return true;
		
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer') {
			return true;
		}
		
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'djembed') === false) {
			return true;
		}
		
		$regex		= '/<img [^>]*alt="djembed"[^>]*>/i';
		
		// Find all instances of plugin and put in $matches for djembed code
		// $matches[0] is full pattern match, $matches[1] is the album ID
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		// No matches, skip this
		if ($matches) {
			
			$doc = JFactory::getDocument();
			$doc->addStyleSheet(JUri::root(true).'/plugins/content/djembedlight/assets/styles.css');
			
			foreach ($matches as $match) {
				$output = $this->_loadEmbed($match);
				$article->text = preg_replace("|$match[0]|", addcslashes($output, '\\$'), $article->text);
			}
		}
	}
	
	protected function _loadEmbed($match) {
		
		preg_match('/data-emtype="([^"]+)"/i', $match[0], $tmp);
		$type = isset($tmp[1]) ? $tmp[1] : '';
		preg_match('/data-emlink="([^"]+)"/i', $match[0], $tmp);
		$link = isset($tmp[1]) ? $tmp[1] : '';
		preg_match('/width="([^"]+)"/i', $match[0], $tmp);
		$width = isset($tmp[1]) ? $tmp[1] : '100%';
		preg_match('/style="([^"]+)"/i', $match[0], $tmp);
		$style = isset($tmp[1]) ? $tmp[1] : '';
		
		$html = '
			<div class="djembed-video" style="'.$style.'">
				<iframe width="100%" height="100%" src="'.$link.'" frameborder="0" allowfullscreen></iframe>
			</div>';
		
		return $html;
	}
	
	function djdebug($array, $type = 'message'){
	
		$app = JFactory::getApplication();
		$app->enqueueMessage("<pre>".print_r($array,true)."</pre>", $type);
	
	}
}

