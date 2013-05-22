<?
/*
 **** Application include file ****
 *@param  $CFG for all database and server variables
 *@param  PHP Session Start
 *@param  MySQL Database connection
 *@global $db database handle as global
 *@class  $CFG contains the initial database & server variables
 *@access public
 *@author: Xaeridus
 *@date: 12/10/02
 */

class object {};
$CFG = new object;

  // Database Config
$CFG->dbhost = "localhost";
$CFG->dbport = "";
$CFG->dbname = "prairie_media";
$CFG->dbuser = "pmedia";
$CFG->dbpass = "nc139b6";

  // Path Variables for links
$CFG->webserver = "";
$CFG->webport = "80";
// $CFG->dirroot = $_SERVER["DOCUMENT_ROOT"]."/";
// Dirs are for local paths
// $CFG->dirroot = ".."."/";
$CFG->dirroot = "";
$CFG->libdir = $CFG->dirroot."includes";
$CFG->imagedir = $CFG->dirroot."images";
$CFG->cssdir = $CFG->dirroot."css";

// Links are for web paths
$CFG->dirrootlink = "$CFG->webserver"."/";
$CFG->liblink = $CFG->dirrootlink."includes";
$CFG->imagelink = $CFG->dirrootlink."images";
$CFG->csslink = $CFG->dirrootlink."css";

//starting session
session_start();

//required library files 
require_once($CFG->libdir."/user.inc.php");
require_once($CFG->libdir."/content.inc.php");
require_once($CFG->libdir."/admin.inc.php");

//theme configuration
// require_once($CFG->libdir."/theme.inc.php");

//configure variables
$CFG->title = "NewsCMS Backend";
$CFG->ADMIN_EMAIL = "";
$CFG->ADMIN_NAME = "";
$CFG->SMTP_SERVER ="";

//site administrator password
$CFG->ADMIN_LOGIN = "";
$CFG->ADMIN_PASSWORD = "";

//whether log or not
$CFG->ERROR_LOG = 1;

//Database Connection
try {
  $db=new PDO("mysql:host=$CFG->dbhost;dbname=$CFG->dbname",$CFG->dbuser,$CFG->dbpass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // $db->setFetchMode(FETCH_OBJ);
} catch(PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
}


?>
