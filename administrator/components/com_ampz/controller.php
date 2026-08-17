<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 *
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') || die;

/**
 * Class AmpzController
 *
 * @since  1.6
 */
class AmpzController extends JControllerLegacy
{
    /**
     * Method to display a view.
     *
     * @since    1.5
     *
     * @param  boolean     $cachable  If true, the view output will be cached
     * @param  mixed       $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     * @return JController This object to support chaining.
     */
    public function display($cachable = false, $urlparams = false)
    {
        require_once JPATH_COMPONENT . '/helpers/ampz.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'dashboard');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }
}
