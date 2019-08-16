<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

use Symfony\Component\HttpFoundation\Request;

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_category_crud extends midcom_baseclasses_components_handler
{
    /**
     *
     * @var midcom\workflow\datamanager $_session
     */
    private $_category;
    
    /**
     *
     * @param array $args The person GUID
     * @param array $data The local request data.
     */
    public function _handler_create(array $args, array &$data)
    {
        $this->_session = de_ccb_workshop_dba_session::get_cached($args[0]);
        $data['sessions'] = $this->_session;
        midcom::get()->auth->require_user_do('midgard:create', null, de_ccb_workshop_dba_category::class);
        $this->_category = new de_ccb_workshop_dba_category();
        $this->_category->title = $data['l10n']->get('category title'); 
        $this->_category->session = $this->_session->id;
        $this->_category->create();

        return new midcom_response_json(['id' => $this->_category->id, 'title' => $this->_category->title]);
    }
    
    /**
     * Generates an object update view.
     *
     * 
     * @param string $guid The object's GUID
     */
    public function _handler_update(Request $request, $category_id)
    {
        $this->_category = new de_ccb_workshop_dba_category((int) $category_id);
        $this->_category->title= $request->request->get('title');
        $this->_category ->update();
        
        return new midcom_response_json(['id' => $this->_category->id, 'title' => $this->_category->title]);
    }
      
    /**
     *
     * @param string $guid The object's GUID
     * @return midcom_response
     */
    public function _handler_delete($category_id, array &$data)
    {
        midcom::get()->auth->require_valid_user();
        $this->_category = new de_ccb_workshop_dba_category((int) $category_id);
        try {
            $this->_category->delete(); 
            $response = $data['l10n']->get('this category was successfully deleted');
        } catch(Exception $e) {
             $response = $e->getMessage();
        }
        return new midcom_response_json(['id' => $this->_category->id, 'response' => $response]); 
    }
}
