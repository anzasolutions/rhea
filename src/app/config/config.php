<?php

/**
 * Application configuration
 */

// Map files to constants
define('DB_FILE', 'src/app/config/db.xml');
define('LOG_CONFIG_FILE', 'log4php.properties');

// Set defaults
define('DEFAULT_APPLICATION_CONTROLLER', 'account');
define('DEFAULT_APPLICATION_ACTION', '');
define('DEFAULT_SESSION_CONTROLLER', 'friends');
define('DEFAULT_SESSION_ACTION', '');
define('DEFAULT_REQUEST_CONTROLLER', 'account');
define('DEFAULT_REQUEST_ACTION', '');

// System paths
define('STATIC_SERVER', 'http://' . $_SERVER['SERVER_NAME'] . '/rhea-static/');
define('PATH_STATIC', $_SERVER['DOCUMENT_ROOT'] . '/rhea-static/');
define('URL_PHOTOS', STATIC_SERVER . 'photos/');
define('PATH_PHOTOS', PATH_STATIC . 'photos/');

?>