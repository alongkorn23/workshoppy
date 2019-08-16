<?php
/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_handler_controller extends midcom_baseclasses_components_handler
{
    /**
     * @param array $args The person GUID
     * @param array $data The local request data
     * @return midcom_response_styled
     */
    public function _handler_controller(array $args, array &$data)
    {
        midcom::get('auth')->require_valid_user();

        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);

        $sessions_qb = de_ccb_workshop_dba_session::new_query_builder();
        $sessions_qb->add_constraint('workshop', '=', $workshop->id);
        $data['sessions'] = $sessions_qb->execute();
        $data['sessiondata'] = [];
        $data['sessioncategories'] = [];

        foreach ($data['sessions'] as $session) {
            $categories = [];
            $categories_object = $session->get_categories();
            if (count($categories_object) > 0) {
                foreach ($categories_object as $category) {
                    $categories[$category->id] = ['id' => $category->id, 'title' => $category->title];
                }
            }
            $session_data = json_decode($session->data);
            $data['sessiondata'][$session->guid] = $session_data;
            $data['sessioncategories'][$session->guid] = $categories;
        }
        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);
        $data['workshop'] = $workshop;
        
        midcom::get()->head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/autobahn.min.js');
        midcom::get()->head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/controller.js');
        midcom::get()->head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/sendmail.js');
        midcom::get()->head->add_jsfile(MIDCOM_STATIC_URL . '/' . $this->_component . '/js/notifications/notifications.js');
        midcom::get()->head->set_pagetitle('Controller');

        return $this->show('workshop-controller');
    }

    /**
     * @param Request $request
     * @param array $args
     * @param array $data
     * @return midcom_response_json
     */
    public function _handler_sendmail(Request $request, array $args, array &$data)
    {
        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);

        $url_client = midcom::get()->get_host_name() . $this->router->generate('client', ['guid' => $workshop->guid]);
        $email = $request->request->get('email');
        $content = $url_client;
        $mail = new org_openpsa_mail();
        $mail->from = $this->_config->get('from_address');
        $mail->to = $email;
        $mail->subject = sprintf($data['l10n']->get('invite link to client screen %s'), htmlentities($workshop->title));
        $mail->body = $content;

        if ($mail->send()) {
            $response = $data['l10n']->get('invite link was sent successfully');
        } else {
            $response = $mail->get_error_message();
        }

        return new midcom_response_json(['response' => $response]);
    }

    public function _handler_sessiondata(Request $request, string $guid)
    {
        $session = new de_ccb_workshop_dba_session($guid);
        $session->data = json_encode($request->request->get('data'));
        $session->update();
        return new JsonResponse();
    }
    
    public function _handler_getCategories(Request $request, $session_guid)
    {               
        $session = new de_ccb_workshop_dba_session($session_guid);
        $categories = [];
        foreach ($session->get_categories() as $category) {
            $categories[$category->id] = ['id' => $category->id, 'title' => $category->title];
        }
        $response = [
            'question' => $session->question,
            'categories' => $categories
        ];
        return new midcom_response_json($response);
    }
    
    public function _handler_archive_workshop(Request $request, string $guid)
    {
        $workshop = new de_ccb_workshop_dba_workshop($guid);
        $workshop->archived = true;
        $workshop->closed = gmstrftime("%Y-%m-%d %H:%M:%S");
        $workshop->update();
        $url_startpage = $this->router->generate('startpage');
        
        return new midcom_response_relocate($url_startpage);
    }
    
}
