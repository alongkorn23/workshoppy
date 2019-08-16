<?php
/**
 * @package openpsa.test
 * @author CONTENT CONTROL http://www.contentcontrol-berlin.de/
 * @copyright CONTENT CONTROL http://www.contentcontrol-berlin.de/
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
/**
 * OpenPSA testcase
 *
 * @package openpsa.test
 */
class de_ccb_workshop_handler_person_participantsTest extends openpsa_testcase
{
    protected static $_person;
    
    public static function setUpBeforeClass()
    {
        self::$_person = self::create_user(true);
        $data = [
            'facilitator' => self::$_person->id,
        ];
    }
    
    public function test_handler_participants()
    {
        midcom::get()->auth->request_sudo('de.ccb.workshop');
        
        $data = $this->run_handler('de.ccb.workshop', ['user', 'participants']);
        $this->assertEquals('user_participants', $data['handler_id']);
        
        $this->show_handler($data);
        
        midcom::get()->auth->drop_sudo();
    }
    
}