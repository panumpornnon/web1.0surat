/**
 * @version $Id: editor.js 7 2017-08-03 09:19:38Z szymon $
 * @package DJ-EmbedLight
 * @copyright Copyright (C) 2015 DJ-Extensions.com, All rights reserved.
 * @license DJ-Extensions.com Proprietary Use License
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 */
!function($){var f=2000;var g='<img src="plugins/content/djembedlight/assets/loading.gif" alt="loading" />';function listenEditors(){if(typeof tinymce=='undefined')return;var a=tinymce.activeEditor;if(a){var b=a.getContent();var c=b.match(/<a href="https?:\/\/(www\.youtube\.com|youtube\.com|youtu\.be|www\.youtu\.be)\/([^"]+)">https?:\/\/(www\.youtube\.com|youtube\.com|youtu\.be|www\.youtu\.be)\/[^<]+<\/a>/);if(c){var d='https://'+c[1]+'/'+c[2]+' '+g;replaceText(c[0],d,a);parseEmbed(d,a)}var c=b.match(/<a href="https?:\/\/vimeo.com\/([^"]+)">https?:\/\/vimeo.com\/[^<]+<\/a>/);if(c){var d='https://vimeo.com/'+c[1]+' '+g;replaceText(c[0],d,a);parseEmbed(d,a)}}setTimeout(listenEditors,f)}function parseEmbed(c,d){var e=c.substr(0,c.indexOf(' '));$.ajax({data:{djembedlight:'parse',link:e}}).done(function(a){replaceText(c,a,d)}).fail(function(a,b){alert("Request failed: "+b);replaceText(c,e,d)})}function replaceText(a,b,c){if(!c)c=tinymce.activeEditor;var d=c.getContent();c.setContent(d.replace(a,b))}$(window).load(function(){listenEditors()})}(jQuery);