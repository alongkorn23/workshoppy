<?php
/**
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @version $Id: viewer.php 5063 2016-03-07 18:04:15Z sonic $
 */

/**
 * site interface class
 *
 * @package de.ccb.mpecore
 */
class de_ccb_workshop_viewer extends midcom_baseclasses_components_viewer
{
    public function _on_handle($handler, array $args)
    {
        $head = midcom::get()->head;
        $head->enable_jquery();
        $head->add_stylesheet(MIDCOM_STATIC_URL . '/' . $this->_component . '/css/style.css');
        $head->add_stylesheet(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/notifications/notifications.css');
    }
}
