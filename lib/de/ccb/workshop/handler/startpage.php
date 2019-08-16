<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_startpage extends midcom_baseclasses_components_handler
{
    public function _handler_startpage()
    {
        midcom::get('auth')->require_valid_user();

        $person = midcom::get()->auth->user->get_storage();

        $workshops_qb = de_ccb_workshop_dba_workshop::new_query_builder();
        $workshops_qb->add_constraint('facilitator', '=', $person->id);
        $workshops_qb->add_constraint('archived', '=', false);
        
        $archived_workshops_qb = de_ccb_workshop_dba_workshop::new_query_builder();
        $archived_workshops_qb->add_constraint('facilitator', '=', $person->id);
        $archived_workshops_qb->add_constraint('archived', '=', true);
        $archived_workshops_qb->add_order('closed', 'DESC');
        
        $this->_request_data['workshops'] = $workshops_qb->execute();
        $this->_request_data['archived_workshops'] = $archived_workshops_qb->execute();
        
        return $this->show('startpage');
    }
}
