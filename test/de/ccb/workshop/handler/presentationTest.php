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
class de_ccb_workshop_handler_presentationTest extends openpsa_testcase
{
    protected static $_workshop;
    protected static $_person;
    
    
    public static function setUpBeforeClass()
    {
        self::$_person = self::create_user(true);
        $data = [
            'facilitator' => self::$_person->id,
        ];
        
        self::$_workshop = self::create_class_object('de_ccb_workshop_dba_workshop');
        
    }
    
    public function test_handler_presentation()
    {
        midcom::get()->auth->request_sudo('de.ccb.workshop');
        
        $data = $this->run_handler('de.ccb.workshop', ['presentation', self::$_workshop->guid]);
        $this->assertEquals('presentation', $data['handler_id']);
        
        $this->show_handler($data);
        
        midcom::get()->auth->drop_sudo();
    }
}
