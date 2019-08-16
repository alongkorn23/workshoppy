<?php
/**
 * Setup file for running unit tests
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

define('OPENPSA_TEST_ROOT', __DIR__ . DIRECTORY_SEPARATOR);
$GLOBALS['midcom_config_local'] = [
    'midcom_services_rcs_enable' => false,
    'midcom_components' => [
        'de.ccb.workshop' => dirname(__DIR__) . '/lib/de/ccb/workshop'
    ]
];

// Check that the environment is a working one
if (!midcom_connection::setup(dirname(__DIR__) . DIRECTORY_SEPARATOR)) {
    // if we can't connect to a DB, we'll create a new one
    openpsa\installer\midgard2\setup::install(OPENPSA_TEST_ROOT . '__output', 'SQLite');

    $topic = new midgard_topic;
    $topic->component = 'de.ccb.workshop';
    $topic->create();
    $GLOBALS['midcom_config_local']['midcom_root_topic_guid'] = $topic->guid;

    /* @todo: This constant is a workaround to make sure the output
     * dir is not deleted again straight away. The proper fix would
     * of course be to delete the old output dir before running the
     * db setup, but this requires further changes in dependent repos
     */
    define('OPENPSA_DB_CREATED', true);
}

//Get required helpers
require_once dirname(__DIR__) . '/vendor/openpsa/midcom/test/utilities/bootstrap.php';