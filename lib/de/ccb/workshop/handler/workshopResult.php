<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

class de_ccb_workshop_handler_workshopResult extends midcom_baseclasses_components_handler {

    public function _handler_workshopResult(array $args, array &$data) 
    {
        midcom::get('auth')->require_valid_user();
        
        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);
        $sessions_qb = de_ccb_workshop_dba_session::new_query_builder();
        $sessions_qb->add_constraint('workshop', '=', $workshop->id);
        $data['sessions'] = $sessions_qb->execute();
        $data['workshop'] = $workshop;
                
        midcom::get()->head->set_pagetitle('Workshop summary');
        
        $data['skip_header'] = true;
        return $this->show('workshop-result');
    }
    
}
