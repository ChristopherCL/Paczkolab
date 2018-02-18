<?php

//Load dependency classes
require_once(__DIR__ . '/class/interface/Database.php');
require_once(__DIR__ . '/class/interface/Action.php');

require_once(__DIR__ . '/class/database/DBmysql.php');

//require(__DIR__ . '/class/Parcel.php');
//require(__DIR__ . '/class/Size.php');
//require(__DIR__ . '/class/Address.php');
require_once(__DIR__ . '/class/User.php');

//Set DB connection
define('DB_SERVER_NAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'coderslab');
define('DB_BASE_NAME', 'Paczkolab');
