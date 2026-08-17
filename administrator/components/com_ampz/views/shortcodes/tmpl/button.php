<?php
/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('jquery.framework', false);

// load the JS needed to handle the form data and send it back to the editor
$script = '
	$(document).ready(function() {

		function insertAmpzShortcodeTag(joomla_version)
        {
			// Get field values
			shortcodename = $("#jform_shortcodename").val();
			tag = "{ampz:"+ shortcodename + "}";

            if (joomla_version == "joomla3")
            {
                window.parent.jInsertEditorText(tag, ' . json_encode($this->eName) . ');
    			window.parent.jModalClose();
            }
            else if (joomla_version == "joomla4")
            {
				var jform_articletext = window.parent.Joomla.editors.instances[\'jform_articletext\'];
    			var jform_description = window.parent.Joomla.editors.instances[\'jform_description\'];

    			if( jQuery.type( jform_articletext ) != \'undefined\'){

    				window.parent.Joomla.editors.instances[\'jform_articletext\'].replaceSelection(tag);
    			} else if( jQuery.type( jform_description ) != \'undefined\'){

    				window.parent.Joomla.editors.instances[\'jform_description\'].replaceSelection(tag);
    			} else {
    				 console.log( "EDITOR NOT FOUND");
    			}
    			window.parent.Joomla.Modal.getCurrent().close()
            }

            return false;
		}

        $(".ampzInsertShortcodeTag button").click(function() {
			insertAmpzShortcodeTag($(".ampzInsertShortcodeTag button").data(\'version\'));
		})
	})
';

JFactory::getDocument()->addScriptDeclaration($script);
$joomla_version = substr(JVERSION, 0, 1);

?>
<div class="ampzInsertShortcodeTag">

		<?php echo $this->form->renderFieldset("main") ?>
		<button class="btn btn-primary span12" data-version="joomla<?php echo $joomla_version ?>">
			<?php echo JText::_('PLG_EDITORS-XTD_AMPZ_INSERTTAG'); ?>
		</button>

</div>
