<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_presentation extends midcom_baseclasses_components_handler
{
    /**
     * the presentation handler.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param array $args The argument list.
     * @param array &$data The local request data.
     */
    public function _handler_presentation(array &$data, array $args)
    {
        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);
        $data['workshop'] = $workshop;

        $category_qb = de_ccb_workshop_dba_category::new_query_builder();
        $category_qb->add_constraint('session.workshop', '=', $workshop->id);
        $data['category'] = $category_qb->execute();

        $head = midcom::get()->head;
        $head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/autobahn.min.js');
        $head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/jquery.qrcode.js');
        $head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/qrcode.js');
        $head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/presentation.js');
        $head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/notifications/notifications.js');
        
        $head->enable_jquery_ui(['sortable']);
        $head->set_pagetitle('Presentation');

        $data['skip_header'] = true;
        return $this->show('presentation');
    }
}
