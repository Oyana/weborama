<?php

/*
|-------------------------------------------------------
| DATABASE CONFIG
|-------------------------------------------------------
|
| Database information for connection, like hostname
| database name, user log and other.
|
*/

/*- Type of the database (mysql, sqlite, ...) -*/
define('DB_TYPE','mysql');

/*- Host of the database (localhost, www.example.com, ...) -*/
define('DB_HOST','localhost');

/*- Name of the database -*/
define('DB_NAME','weborama');

/*- Prefix of the database tables -*/
define('DB_PREFIX','');

/*- User of the database (root, admin, ...) -*/
define('DB_USER','root');

/*- Password of the database -*/
define('DB_PASS','');


/*
|-------------------------------------------------------
| WEBSITE CONFIG
|-------------------------------------------------------
|
| website information for resources handling,
| like base url, user log, debug level, etc
|
*/

define('APP_NAME','Weborama');

/*- Website Path (url & root) -*/
define('SITE_URL','http://localhost/weborama');
define('ROOT_PATH', dirname(__FILE__) );

/*- choose beetween 3 debug lvl (0=none, 1=error viewing, 2=dev information) -*/
define('DEBUG_LVL','2');

/*- Localization of the website, according to the iso639-2 codes ( http://www.loc.gov/standards/iso639-2/php/code_list.php ) and formated like <lang>_<territory> -*/
define('LANG','fr_FR');
setlocale(LC_ALL, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');

/*- Is the website in maintenance ? (1/0) -*/
define('MAINTENANCE','0');
