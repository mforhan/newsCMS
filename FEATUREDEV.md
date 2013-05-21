--------------------------------------------------------------------------------
-- CMS_File.txt : Description of all files and directories for the Site CMS --
--------------------------------------------------------------------------------

application.inc.php -- Master config file for database and other includes

lib/content.inc.php -- Read Only access to database information
lib/admin.inc.php   -- Write access to database
lib/user.inc.php    -- User registration, verification and admin routines
lib/theme.inc.php   -- Look and feel configuration file

images/             -- Directory for site images, not user images
photos/             -- Directory for user images on the site
                    // Files are organized by userid_date folders
FCKeditor/          -- The text editors program files
photoManager/       -- Files for the storage and manipulation of photo files

login.php           -- Main Login File
logout.php          -- Main Logout File

index.php           -- Main admin page

--------------------------------------------------------------------------------
Site Functions
--------------------------------------------------------------------------------
Story Editing
 X Word Style Entry
 X Story Manager
 X Column Inch Calculator ?
 - Setup of Deadlines for Time Sensitive Stories
 - Story Progress Indicators (Workflow)
 - AutoSave as Draft

Story Management
 - At a glance ordering of stories per section
 - Workflow 
 - Deadline notifications
 - Assignments of topics?

Photo Manager
 - Each individual photo gets a record:
   - image_id       int(4)       PRI auto_increment // assigned ID
   - thumb_path     varchar(255) // path to thumb - perhaps a link like group,
     to deal with multiple thumb sizes
   - path           varchar(255) // path to file 
   - width          int(6)       // width of image
   - height         int(6)       // height of image
   - size           int(10)      // filesize of image (in bytes)
   - comment        text         // any necessary comments
   - image_group_id int(4)       // group the image belongs to

 - images are grouped:
   - image_group_id int(4) PRI auto_increment // automatic id
   - image_group_name varchar(64) // Name of the group
   - isActive tinyint(1)

 - The only downside with this method seems to be the relation of data. The
   database doesn't seem to have adequate room for more than one thumbnail and
there is no thumbnail data stored. The comment field is not terribly
necessary, perhaps its to be used for things like cutlines. It might be best
to leave cutlines in their own field and an ID for the record.

--------------------------------------------------------------------------------
Database Tables
--------------------------------------------------------------------------------
content
 - article_id  int(11)      PRI auto_increment
 - section_id  int(11)
 - title       varchar(255)
 - subtitle    varchar(255)
 - body        mediumtext
 - author_id   int(11)
 - date_stamp  date
 - time_stamp  time
 - isActive    int(1)
 - webActive   int(1)
 - hasPhoto    int(1)

section
 - section_id  int(11)      PRI auto_increment
 - title       varchar(255)
 - ext_url     text
 - shortdesc   varchar(64)
 - isActive    int(1)

status
 - status_id   int(11)      PRI auto_increment
 - name        varchar(64)
 - description text

user
 - user_id     int(11)      PRI auto_increment
 - user_name   varchar(16)  UNI
 - real_name   varchar(64)
 - title       varchar(64)
 - password    text
 - isActive    int(1)

webphoto
 - article_id  int(11)
 - photo_id    int(11)      PRI auto_increment
 - path        text
 - cutline     text
 - photoby     int(11)
 - width       int(5)
 - height      int(5)
 - isActive    int(1)

--------------------------------------------------------------------------------
Prototypes
--------------------------------------------------------------------------------

content.inc.php
 - function retrieve_content($section,$number,$preview,$style) {
 - function generate_nav();
 - function getClassbyID($id);

admin.inc.php
 (Write Functions)
 - function insert_article($title,$subtitle,$body,$authorid,$sectionid,$isactive) {
 - function insert_photo($article,$path,$cutline,$photoby,$width,$height,$isactive) {
 - function imagecreatefromfile($filename) {
 - function insert_author($username,$realname,$designate,$isactive) {
 - function insert_section($secname,$shortdesc,$ext_url,$isactive) {
 - function insert_region($regionname,$regiondesc,$isactive) {
 - function insert_cbbitem($regionid,$title,$body,$expires,$isactive) {
 - function insert_calitem($caltitle,$calbody,$caldate,$stime,$etime,$isactive) {

 - function update_article($article_id,$title,$subtitle,$body,$authorid,$sectionid,$isactive) {
 - function update_author($user_id,$username,$realname,$designate,$isactive) {
 - function update_section($section_id,$secname,$shortdesc,$ext_url,$isactive) {
 - function update_photo($photo_id,$article_id,$path,$cutline,$photoby_id,$width,$height,$isactive) { 
 - function update_region($regionid,$regionname,$regiondesc,$isactive) {
 - function update_cbbitem($cbbid,$regionid,$title,$body,$expires,$isactive) {
 - function update_calitem($calid,$caltitle,$calbody,$caldate,$stime,$etime,$isactive) {
 
 (Read Functions)
 - function return_sections() {
 - function return_photos() {
 - function return_authors() {
 - function return_titles() {
 - function return_static_page_titles() {
 - function return_regions() {
 - function return_bbitems() {
 - function return_calitems() {

 - function retrieve_contents($section,$number) {
 - function retrieve_titles() {
 - function retrieve_list_titles() {
 - function retrieve_authors($default_author) {
 - function retrieve_articles($default_article) {
 - function retrieve_sections($default_section) {
 - function retrieve_regions($default_region) {

 - function edit_section($section_id) {
 - function edit_photo($photo_id) {
 - function edit_author($user_id) {
 - function edit_content($article) {
 - function edit_region($regionid) {
 - function edit_cbbitem($cbbid) {
 - function edit_calitem($calid) {

 - function phpDate($format,$datestr) {

database.inc.php
 - function db_connect() {
 - function db_query($db_conn,$query) {
 - function db_insert($db_conn,$query) {

user.inc.php
 - function user_isloggedin() {
 - function user_login($user_name,$password,$group_name) {
 - function user_logout() {
 - function user_set_tokens($user_name_in) {
 - function user_confirm($hash,$email) {
 - function user_change_password($newpassword1,$newpassword2,$changeusername,$oldpassword) {
 - function user_lost_password($email,$user_name) {
 - function user_change_email($password1,$newemail,$username) {
 - function user_send_confirm_email($email,$hash) {
 - function user_register($user_name,$password1,$password2,$email,$real_name) {

 - function user_getid() {
 - function user_getrealname() {
 - function user_getemail() {
 - function user_getname() {
 - function account_pwvalid($pw) {
 - function account_namevalid($name) {
 - function validate_email($address) {
