<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

use midcom\datamanager\controller;
use midcom\datamanager\datamanager;
use midcom\datamanager\schemadb;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_crud extends midcom_baseclasses_components_handler
{
    /**
     *
     * @var de_ccb_workshop_dba_workshop $_workshop
     */
    private $_workshop;

    /**
     *
     * @var midcom\datamanager\controller
     */
    private $controller;

    /**
     * the create page handler.
     *
     * @param Request $request The request object
     * @return midcom_response_styled
     */
    public function _handler_create(Request $request)
    {
        $this->mode = 'create';
        midcom::get()->auth->require_user_do('midgard:create', null, de_ccb_workshop_dba_workshop::class);
        $person = midcom::get()->auth->user->get_storage();
        $this->_workshop = new de_ccb_workshop_dba_workshop();
        $this->_workshop->facilitator = $person->id;
        $defaults = [
            'manager' => midcom_connection::get_user(),
        ];
        midcom::get()->head->set_pagetitle(sprintf($this->_l10n_midcom->get('create %s'), $this->_l10n->get('workshop')));
        $this->_workshop = $this->get_workflow('datamanager', [
            'controller' => $this->load_controller($defaults),
            'save_callback' => [$this, 'save_callback']
        ]);
        return $this->_workshop->run($request);
    }

    /**
     * Generates an object update view.
     *
     * @param Request $request The request object
     * @param string $guid The object's GUID
     * @param array $data The local request data.
     */
    public function _handler_update(Request $request, $guid)
    {
        $this->_workshop  = new de_ccb_workshop_dba_workshop($guid);
        $this->_workshop ->require_do('midgard:update');
        midcom::get()->head->set_pagetitle(sprintf($this->_l10n_midcom->get('edit %s'), $this->_l10n->get('workshop')));

        $this->_workshop = $this->get_workflow('datamanager', [
            'controller' => $this->load_controller(),
            'save_callback' => [$this, 'save_callback']
        ]);
        return $this->_workshop->run($request);
    }

    /**
     *
     * @param controller $controller
     * @return string
     */
    public function save_callback(controller $controller)
    {
        if ($this->mode === 'create') {
            return $this->router->generate('startpage');
        }
    }

    /**
     *
     * @param array $defaults
     * @return \midcom\datamanager\controller
     */
    private function load_controller(array $defaults = [])
    {
        $schemadb = schemadb::from_path($this->_config->get('schemadb_workshop'));

        $dm = new datamanager($schemadb);
        return $dm
           ->set_defaults($defaults)
           ->set_storage($this->_workshop)
           ->get_controller();
    }

    /**
     *
     * @param string $guid The object's GUID
     * @return midcom_response
     */
    public function _handler_delete(Request $request, $guid)
    {
        $workshop = new de_ccb_workshop_dba_workshop($guid);
        $workflow = $this->get_workflow('delete', [
            'object' => $workshop,
            'success_url' => '/'
        ]);
        return $workflow->run($request);
    }
}
