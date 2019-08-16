<?php
date_default_timezone_set('UTC');
$basedir = dirname(__DIR__) . '/';
require $basedir . 'vendor/autoload.php';

midcom_connection::setup($basedir);
define('OPENPSA2_THEME_ROOT', $basedir . 'var/themes/');
define('MIDCOM_ROOT', $basedir . 'vendor/openpsa/midcom/lib');
define('OPENPSA2_PREFIX', '/');

header('Content-Type: text/html; charset=utf-8');

$GLOBALS['midcom_config_local'] = array();
$GLOBALS['midcom_config_local']['theme'] = 'workshop';


//$GLOBALS['midcom_config_local']['theme'] = 'workshoppy';

// clever defaults for midgard2
define('WORKSHOPPY_BASEDIR', realpath(dirname(__DIR__)));

$GLOBALS['midcom_config_local']['midcom_config_basedir'] = $basedir . 'config';
$GLOBALS['midcom_config_local']['log_filename'] = $basedir . 'var/log/midcom.log';
$GLOBALS['midcom_config_local']['cache_base_directory'] = $basedir . "var/cache/midcom/";
$GLOBALS['midcom_config_local']['midcom_services_rcs_root'] = $basedir . "var/rcs";

$GLOBALS['midcom_config_local']['midcom_components'] = array
(
    'de.ccb.workshop' => $basedir . 'lib/de/ccb/workshop',
);

if (file_exists($basedir . 'config.inc.php'))
{
    require $basedir . 'config.inc.php';
}

midcom::get('i18n')->set_language('de');

// Start request processing
$midcom = midcom::get();
$midcom->codeinit();
$midcom->finish();
