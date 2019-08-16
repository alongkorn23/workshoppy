<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

use Symfony\Component\HttpFoundation\Request;
use midcom\datamanager\datamanager;
use midcom\datamanager\schemadb;

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_session_crud extends midcom_baseclasses_components_handler
{
    /**
     *
     * @var midcom\workflow\datamanager $_session
     */
    private $_session;

    /**
     *
     * @param Request $request The request object
     * @param array $args The person GUID
     * @param array $data The local request data.
     */
    public function _handler_create(Request $request, array $args, array &$data)
    {
        $this->_workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);
        $data['workshop'] = $this->_workshop;
        midcom::get()->auth->require_user_do('midgard:create', null, de_ccb_workshop_dba_session::class);
        $this->_session = new de_ccb_workshop_dba_session();
        $this->_session->workshop = $this->_workshop->id;
        $defaults = [
            'manager' => midcom_connection::get_user(),
        ];
        midcom::get()->head->set_pagetitle(sprintf($this->_l10n_midcom->get('create %s'), $this->_l10n->get('session')));
        $workflow = $this->get_workflow('datamanager', [
            'controller' => $this->load_controller($defaults),
            'relocate' => false
        ]);
        return $workflow->run($request);
    }

    /**
     * Generates an object update view.
     *
     * @param Request $request The request object
     * @param string $guid The object's GUID
     * @param array $data The local request data.
     */
    public function _handler_update(Request $request, $session_guid)
    {
        $this->_session = new de_ccb_workshop_dba_session($session_guid);
        $this->_session ->require_do('midgard:update');
        midcom::get()->head->set_pagetitle(sprintf($this->_l10n_midcom->get('edit %s'), $this->_l10n->get('this session')));

        $workflow = $this->get_workflow('datamanager', [
            'controller' => $this->load_controller(),
            'relocate' => false
        ]);
        return $workflow->run($request);
    }

    /**
     *
     * @param array $defaults
     * @return \midcom\datamanager\controller
     */
    private function load_controller(array $defaults = [])
    {
        $schemadb = schemadb::from_path($this->_config->get('schemadb_workshop_session'));

        $dm = new datamanager($schemadb);
        return $dm
            ->set_defaults($defaults)
            ->set_storage($this->_session)
            ->get_controller();
    }

    /**
     *
     * @param string $guid The object's GUID
     * @return midcom_response
     */
    public function _handler_delete(Request $request, $session_guid ,$guid)
    {
        $session = new de_ccb_workshop_dba_session($session_guid);
        $workflow = $this->get_workflow('delete', [
            'object' => $session,
            'relocate' => false
        ]);
        return $workflow->run($request);
    }
}
