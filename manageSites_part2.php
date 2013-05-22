<?
  include('application.inc.php');

//  if(!isLoggedin()) {
//    Header('location: login.php');
//  }
$articles = array();
if($_POST) {
  if($_POST['finish']) {
    // print_r($_POST);
    $url = $_POST['finish'];
    foreach($_POST as $key=>$value) {
      if($key != 'finish' && $key != 'submit') {
        // print "set ($key,$value,$url)<br/>\n"; 
        $results = setSite($key,$value,$url);
        if(DB::iserror($result)) {
          print ("Insert Error:".$result->getMessage());
          trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
        } else {
          echo "Database successfully updated";
        }
      }
    }
  } else {
    // print_r($_POST);
    $site = $_POST['site'];
    foreach($_POST as $key=>$value) {
      // print "[$key] ($value)<br/>\n";
      if($value == 'on') {
        array_push($articles,$key);
      }
    }
  }
}

/* Site_Content Table
+--------------+-------------+------+-----+---------+-------+
| Field        | Type        | Null | Key | Default | Extra |
+--------------+-------------+------+-----+---------+-------+
| site_id      | int(11)     |      | PRI | 0       |       |
| content_id   | int(11)     |      | PRI | 0       |       |
| section_name | varchar(64) | YES  |     | NULL    |       |
| publish_date | date        | YES  |     | NULL    |       |
| end_date     | date        | YES  |     | NULL    |       |
| isActive     | int(1)      | YES  |     | NULL    |       |
+--------------+-------------+------+-----+---------+-------+
*/
?>
<html>
 <head>
  <title>Site Management</title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
 </head>
 <body>
 <? include('nav.html'); ?> 
  <table style="border:1px solid black;width:800px;overflow:hidden;margin:10px;background:white;">
   <tr style="border-bottom:1px solid black;background:lightgray;"><th>Title</th><th>Section</th></tr>
<form action="<?= $PHP_SELF ?>" method="post">
<?
$alt = 0;

/* Build Section Select */
$sections = getSections($site);

// $SELECT = "<SELECT name=\"section\">\n";
$SELECT = "";
while($section = $sections->fetch(PDO::FETCH_OBJ)) {
  $sect_name = $section->section_name;
  $SELECT .= "<OPTION value=\"$sect_name\">$sect_name</OPTION>\n";
}
$SELECT .= "</SELECT>";
/* End Build Section */

while($value = array_shift($articles)) {
  $headline = getHeadline($value);

  if($alt) {
    $bgcolor = "#e0ffff";
    $alt = 0;
  } else {
    $bgcolor = "#ffffff";
    $alt = 1;
  }

?>
   <tr style="background-color:<?= $bgcolor ?>;"><td><?= $headline ?></td><td>
<?
  print "<SELECT NAME=\"$value\">"; 
  print $SELECT;
?></td></tr>
<? } // End article while ?>
   <tr>
    <td colspan="2" align="right">
     <INPUT type="submit" name="submit" value="Submit"><INPUT type="hidden" name="finish" value="<?= $site ?>">
    </td>
   </tr>
   </form>
  </table>
 </body>
</html>
