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
 
$articles = getArticles($startNum);
?>
<html>
 <head>
  <title>System View</title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
 </head>
 <body> 
 <? include('nav.html'); ?> 
  <table style="border:1px solid black;width:790px;overflow:hidden;margin:10px;background:white;">
   <tr style="border-bottom:1px solid black;background:lightgray;"><th>Author</th><th>Title</th><th>Date</th><th>Status</th><th>[P]</th><th>[W]</th></tr>
<?
$alt = 0;
while($story = $articles->fetchRow()) {
  $article_id = $story->article_id;
  $headline   = $story->headline;
  $author     = $story->author_name;
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

  list($aFirst,$aLast) = split(' ',$author);
  if($photo) {
    # $icon = "<a href=\"viewPhoto.php?article_id=$article_id\" target=\"_blank\"><img src=\"images/photo.gif\" width=\"16\" height=\"16\" style=\"margin-right:5px;\"/></a>";
    $icon = "<a target=\"_blank\" onClick='javascript:window.open(\"viewPhoto.php?article_id=$article_id\",\"\",\"toolbars=no,width=290px,height=450px\");'><img src=\"images/photo.gif\" width=\"16\" height=\"16\" style=\"margin-right:5px;\"></a>";
//  info = window.open("","info2","toolbar=0,scrollbars=0,statusbar=0,location=0,menubar=0,width=800,height=600");
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
   <tr style="background-color:<?= $bgcolor ?>;"><td><a href="author.php?author=<?= $aLast ?>"><?= $aLast ?></a></td><td><?= $icon ?><a href="edit.php?article_id=<?= $article_id ?>"><?= $headline ?></a></td><td><?= $date ?></td><td style="color:goldenrod;"><?= $status ?></td><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
<? 
    unset($site);
    unset($section);
    unset($date);
  } // End article while ?>
<!--   <tr style="background:#e0ffff;"><td>Allmain</td><td>Citizens vote for impeachment</td><td>11/28/2005</td><td style="color:black;">Published</td><td><input type="radio" checked disabled></td><td><input type="radio" checked disabled></td></tr>
   <tr><td>Schleif</td><td><img src="notice_icon.gif" width="10px" height="10px" onMouseOver="javascript:alert('Must be run by issue 52 - 12/25/2005');"/>&nbsp;Custard carrying customers crow 'Cruelty!'</td><td>12/07/2005</td><td style="color:blue;">In Progress</td><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
   <tr style="background:#e0ffff;"><td>Steele</td><td>Leavenworth watershed risks collapse from forest industry</td><td>11/30/2005</td><td style="color:green;">Layout</td><td><input type="radio" checked disabled></td><td><input type="radio" disabled></td></tr> -->
   <tr style="background-color:lightgray;">
     <td colspan="4" align="right"><span style="visibility:<?= $pDisp ?>;"><?= $prev ?> Prev</span></td>
     <td colspan="2" align="right"><span style="visibility:<?= $nDisp ?>;">Next <?= $next ?></span></td>
   </tr>
  </table>
<!--  <div id="menu" style="width:99%;height:25px;">
  </div>

  <div id="rightcontent" style="margin-top:10px;visibility:hidden;">
     <h3 style="margin:4px;">Manage</h3>
      <p style="font-size:8pt;display:inline;">
       [<a href="?action=mArticle">Article</a>]
       [<a href="?action=mAuthors">Author</a>]
       [<a href="?action=mSection">Section</a>]
       [<a href="?action=mPhotos">Photo</a>]
       [<a href="?action=mRegion">Region</a>]
       [<a href="?action=mCBB">CBB</a>]
       [<a href="?action=mCal">Calendar</a>]
      </p>
     <h3 style="margin:4px;">New</h3>
      <p style="font-size:8pt;display:inline;">
       [<a href="?action=nArticle">Article</a>]
       [<a href="?action=nAuthors">Author</a>]
       [<a href="?action=nSection">Section</a>]
       [<a href="?action=nPhotos">Photo</a>]
       [<a href="?action=nRegion">Region</a>]
       [<a href="?action=nCBB">CBB</a>]
       [<a href="?action=nCal">Calendar</a>]
      </p>
     <h3 style="margin:4px;">Admin Tools</h3>
      <p style="font-size:8pt;display:inline;">
       [<a href="colorscheme/index.html">Color Schemer</a>]
       [<a href="photomanager/index.php">Photo Manager</a>]
       [<a href="logout.php">Logout</a>]
      </p> 
  </div> -->

 </body>
</html>
