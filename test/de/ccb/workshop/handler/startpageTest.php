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
class de_ccb_workshop_handler_startpageTest extends openpsa_testcase
{
    public function test_handler_startpage()
    {
        $this->create_user(true);
        midcom::get()->auth->request_sudo('de.ccb.workshop');

        $data = $this->run_handler('de.ccb.workshop', []);
        $this->assertEquals('startpage', $data['handler_id']);

        $this->show_handler($data);

        midcom::get()->auth->drop_sudo();
    }
}
