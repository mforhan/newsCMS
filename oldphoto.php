<?
include("application.inc.php");

  if(!isLoggedin()) {
    Header('location: login.php');
  }

if($HTTP_POST_VARS) {
 $article = $HTTP_POST_VARS['article'];
 $url     = $HTTP_POST_VARS['url'];
 $path    = $HTTP_POST_VARS['path'];
 $cutline = $HTTP_POST_VARS['cutline'];
 $photoby = $HTTP_POST_VARS['photoby'];
 $finish  = $HTTP_POST_VARS['finish'];
 $preview  = $HTTP_POST_VARS['preview'];

 // print_r($HTTP_POST_VARS);

 if( $finish == 1 ) {
   $cutline = urldecode($cutline);
   $photoby = urldecode($photoby);
   insert_photo($article,$url,$path,$cutline,$photoby,1);
   
   // We need to throw an error and then repopulate the fields with data
   unset($HTTP_POST_VARS); 
 } // else {
   //print "<h3 style='color:red;'>Database Insert Failed</h3>";
 // }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title>Article View</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex, nofollow">
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
#verify {
width:250px;
height:100px;
text-align:center;
font:14pt georgia black;
background-color:#dddddd;
border:1px solid black;
float:right;
padding:5px;
margin:10px;
}
#photo {
width:250px;
padding:10px;
margin-right:10px;
border:1px solid black;
background-color:#ddd;
}
#photo p {
font:8pt georgia;
text-align:justify;
margin:0px;
margin-top:2px;
}
#photo p.byline {
font-weight:bold;
text-align:right;
}
  </style>
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
 <!--<body style="font:xx-small 6pt/8pt georgia;background:#d0d0d0;">-->
 <body>
 <? include('nav.html'); ?>
 <? if($preview == 1) { ?> 
<form action="<?= $PHP_SELF ?>" method="post">
<input type="hidden" name="article" value="<?= $article ?>">
<input type="hidden" name="url" value="<?= $url ?>">
<input type="hidden" name="path" value="<?= $path ?>">
<input type="hidden" name="cutline" value="<?= urlencode($cutline) ?>">
<input type="hidden" name="photoby" value="<?= urlencode($photoby) ?>">
<input type="hidden" name="finish" value="1">
<div id="verify">
<p>Is this what you want?</p><input type="submit" name="submit" value="Submit">
</div> 
</form>
<div id="photo">
<img src="<?= $url.'/'.$path ?>">
<p class="byline"><?= $photoby ?></p>
<p><?= $cutline ?></p>
</div>
 <? } else { ?>
  <table style="border:1px solid black;width:800px;overflow:hidden;margin:10px;background:white;">
   <form action="<?= $PHP_SELF ?>" method="post" target="_blank">
   <tr><td style="width:100px;">Article: </td><td colspan="3">
    <SELECT style="width:100%;" name="article">
      <? retrieve_articles(); ?>
     </SELECT>
    </td></tr>
   <tr><td>URL: </td><td>
    <SELECT name="url">
     <OPTION>http://www.leavenworthecho.com</OPTION>
     <OPTION>http://www.lakechelanmirror.com</OPTION>
     <OPTION>http://www.cashmerevalleyrecord.com</OPTION>
     <OPTION>http://www.gazette-tribune.com</OPTION>
    </SELECT>
    </td>
    <td>Path: </td><td><input type="text" size="32" name="path" style="width:100%" /></td>
    </tr>
    <tr>
     <td>Photographer:</td><td colspan="3"><input type="text" name="photoby" style="width:100%" ></td>
    </tr>
   <!-- End Author Block -->
    <tr><td colspan="4" align="left">Cutline</td></tr>
    <tr><td colspan="4"><textarea name="cutline" style="width:100%;height:250px;"></textarea></td></tr>
   <tr><td colspan="4" align="right">
     <input type="hidden" name="preview" value="1"><input type="reset"><input type="submit" value="Submit">
   </td></tr>
   </form>
  </table>
<? } // end finish if ?>
 </body>
</html>
