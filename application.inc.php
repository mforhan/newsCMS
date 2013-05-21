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
$CFG->dbname = "";
$CFG->dbuser = "";
$CFG->dbpass = "";

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
require_once("DB.php");
require_once($CFG->libdir."/user.inc.php");
require_once($CFG->libdir."/content.inc.php");
require_once($CFG->libdir."/admin.inc.php");
// dl( 'xdiff.so' );

//theme configuration
// require_once($CFG->libdir."/theme.inc.php");

//configure variables
$CFG->title = "Prairie Media CMS";
$CFG->ADMIN_EMAIL = "pmedia@gazette-tribune.com";
$CFG->ADMIN_NAME = "Prairie Media Webmaster";
$CFG->SMTP_SERVER ="localhost";

//site administrator password
$CFG->ADMIN_LOGIN = "";
$CFG->ADMIN_PASSWORD = "";

//whether log or not
$CFG->ERROR_LOG = 1;

//Database Connection
$db=DB::connect("mysql://$CFG->dbuser:$CFG->dbpass@$CFG->dbhost/$CFG->dbname");

// To set the fetchmode for fetchrow()
$db->setFetchMode(DB_FETCHMODE_OBJECT);

//to verify between a error or a valid connection.
if (DB::isError($db)) {
    die ($db->getMessage());
}
?>
