<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_client extends midcom_baseclasses_components_handler
{
    /**
     * the start page handler.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param array $args The argument list.
     * @param array &$data The local request data.
     */
    public function _handler_client(array $args, array &$data)
    {
        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);
        $data['workshop'] = $workshop;

        midcom::get()->head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/autobahn.min.js');
        midcom::get()->head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/client.js');
        midcom::get()->head->set_pagetitle('Client');
        $data['skip_header'] = true;
        return $this->show('client');
    }
}
