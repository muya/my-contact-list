<?php
/*
 * base configs for my contacts app
 */


//DB CONFIGS
define('DBHOST', '127.0.0.1');
define('DBUSER', 'contact_list');
define('DBPASS', '*private123#');
define('DBNAME', 'my_contacts');

/* LOG CONFIGS */
define('LOG_DIRECTORY', '/var/log/applications/MyContacts/');

//log levels
define('ERROR', 'ERROR');
define('INFO', 'INFO');
define('DEBUG', 'DEBUG');
define('EXCEPTION', 'EXCEPTION');
define('UNDEFINED', 'UNDEFINED');
define('FATAL', 'FATAL');
define('SYSTEM_LOG_LEVEL', 10);

//root url
define('ROOT_URL', 'http://localhost/ContactList/');
