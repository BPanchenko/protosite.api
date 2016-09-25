<?
define('PHP_DIR', dirname(__FILE__));
define('PHP_LIB_DIR', dirname(__FILE__) . "/lib");

require_once PHP_DIR . "/headers.php";
require_once PHP_DIR . "/config.php";
require_once PHP_DIR . "/lib/functions.php";

// core

require_once PHP_LIB_DIR . "/system/Log.php";
require_once PHP_LIB_DIR . "/system/SystemException.php";

require_once PHP_LIB_DIR . "/base/CaseInsensitiveArray.php";
require_once PHP_LIB_DIR . "/base/Component.php";
require_once PHP_LIB_DIR . "/base/Collection.php";
require_once PHP_LIB_DIR . "/base/Model.php";

require_once PHP_LIB_DIR . "/DB/Schema.php";
require_once PHP_LIB_DIR . "/DB/MySql/Schema.php";
require_once PHP_LIB_DIR . "/DB/SQLite/Schema.php";
require_once PHP_LIB_DIR . "/DB/Table.php";
require_once PHP_LIB_DIR . "/DB/MySql/Table.php";
require_once PHP_LIB_DIR . "/DB/SQLite/Table.php";

require_once PHP_DIR . "/app/AppException.php";

require_once PHP_LIB_DIR . "/http/Request.php";
require_once PHP_LIB_DIR . "/http/Response.php";

// application

require_once PHP_DIR . "/models/Photo.php";
require_once PHP_DIR . "/collections/Photos.php";
require_once PHP_DIR . "/models/Post.php";
require_once PHP_DIR . "/collections/Posts.php";

?>