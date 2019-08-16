<?php
/**
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

/**
 * @package de.ccb.workshop
 */
class de_ccb_workshop_dba_workshop extends midcom_core_dbaobject
{
    public $__midcom_class_name__ = __CLASS__;
    public $__mgdschema_class_name__ = 'de_ccb_workshop_workshop';


    public  function get_class_magic_default_privileges()
    {
        return array
        (
            'EVERYONE' => array(),
            'ANONYMOUS' => array(),
            'USERS' => array
            (
                'midgard:create'=> MIDCOM_PRIVILEGE_DENY,
                'midgard:update'=> MIDCOM_PRIVILEGE_DENY,
                'midgard:delete'=> MIDCOM_PRIVILEGE_DENY,
            )
        );
    }
}