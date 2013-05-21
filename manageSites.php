<?
  include('application.inc.php');

  if(!isLoggedin()) {
    Header('location: login.php');
  }

if($HTTP_GET_VARS) {
  $startNum = $HTTP_GET_VARS['record'];
} else {
  $startNum = 0;
}
if($HTTP_POST_VARS) {
  print_r($HTTP_POST_VARS);
  exit();
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
$articles = getArticles($startNum);
?>
<html>
 <head>
  <title>Site Management</title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
  <style type="text/css">
a:link {
  color: black;
  text-decoration:none;
}
a:visited { 
  color: black; 
  text-decoration:none;
}
a:hover { 
  color: gray;
}
a:active { 
  color: black; 
}
a img {
border:none;
}
  </style>
 </head>
 <body>
 <? include('nav.html'); ?> 
  <table style="border:1px solid black;width:800px;overflow:hidden;margin:10px;background:white;">
   <tr style="border-bottom:1px solid black;background:lightgray;"><th>Select</th><th>Title</th><th>Date</th><th>Status</th><th>[P]</th><th>[W]</th></tr>
<form action="manageSites_part2.php" method="post" target="_blank">
<?
$alt = 0;
while($story = $articles->fetchRow()) {
  $article_id = $story->article_id;
  $headline   = $story->headline;
  $status     = $story->status;
  $photo      = $story->hasPhoto;
 
  $sites = getSiteInfo($article_id);
  while($info = $sites->fetchRow()) {
    $site = $info->site_name;
    $section = $info->section_name;
    $date = $info->date;
  }

  if($alt) {
    $bgcolor = "#e0ffff";
    $alt = 0;
  } else {
    $bgcolor = "#ffffff";
    $alt = 1;
  }

  if($photo) {
    $icon = "<a href=\"viewPhoto.php?article_id=$article_id\" target=\"_blank\"><img src=\"images/photo.gif\" width=\"16\" height=\"16\" style=\"margin-right:5px;\"/></a>";
  } else {
    $icon = NULL;
  }
 
  $nDisp = "hidden";
  $pDisp = "hidden";
 
  $nextNum = $startNum+20;
  $prevNum = $startNum-20;
  if($nextNum < 700) {
    $nDisp = "visible";
    $next  = "<a href=\"article.php?record=$nextNum\">>></a>";
  } 
  if($prevNum > 0) {
    $pDisp = "visible";
    $prev  = "<a href=\"article.php?record=$prevNum\"><<</a>";
  }
  if($prevNum == 0) {
     $pDisp = "visible";
     $prev = "<a href=\"article.php\"><<</a>";
  }
  // echo "[$prevNum :: $pDisp] [$nextNum :: $nDisp]<br/>";
?>
   <tr style="background-color:<?= $bgcolor ?>;"><td><input type="checkbox" name="<?= $article_id ?>"></td><td><?= $icon ?><a href="edit.php?article_id=<?= $article_id ?>"><?= $headline ?></a></td><td><?= $date ?></td><td style="color:goldenrod;"><?= $status ?></td><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
<? 
    unset($site);
    unset($section);
    unset($date);
   } // End article while ?>
<!--   <tr style="background:#e0ffff;"><td>Allmain</td><td>Citizens vote for impeachment</td><td>11/28/2005</td><td style="color:black;">Published</td><td><input type="radio" checked disabled></td><td><input type="radio" checked disabled></td></tr>
   <tr><td>Schleif</td><td><img src="notice_icon.gif" width="10px" height="10px" onMouseOver="javascript:alert('Must be run by issue 52 - 12/25/2005');"/>&nbsp;Custard carrying customers crow 'Cruelty!'</td><td>12/07/2005</td><td style="color:blue;">In Progress</td><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
   <tr style="background:#e0ffff;"><td>Steele</td><td>Leavenworth watershed risks collapse from forest industry</td><td>11/30/2005</td><td style="color:green;">Layout</td><td><input type="radio" checked disabled></td><td><input type="radio" disabled></td></tr> -->
   <tr style="background-color:lightgray;">
     <td colspan="2" align="left">
<SELECT name="site">
 <OPTION VALUE="1">Lake Chelan Mirror</OPTION>
 <OPTION VALUE="2">OV Gazette-Tribune</OPTION>
 <OPTION VALUE="3">Cashmere Valley Record</OPTION>
 <OPTION VALUE="4">The Leavenworth Echo</OPTION>
</SELECT>
     </td>
     <td align="left">
<INPUT TYPE="submit" name="submit" value="Submit">
     </td>
     <td colspan="2" align="right"><span style="visibility:<?= $pDisp ?>;"><?= $prev ?> Prev</span></td>
     <td colspan="2" align="right"><span style="visibility:<?= $nDisp ?>;">Next <?= $next ?></span></td>
   </form>
   </tr>
  </table>
 </body>
</html>
