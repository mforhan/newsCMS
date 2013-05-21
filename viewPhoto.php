<?php
 include('application.inc.php');

  if(!isLoggedin()) {
    Header('location: login.php');
  }

 if($HTTP_GET_VARS) {
   $article_id = $HTTP_GET_VARS['article_id'];
 }
?>
<html>
 <head>
  <title><?= $THEME->site_title ?></title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
  <style type="text/css">
body {
background-color:#004;
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
/* #photo, #content #photo {
float:right;
width:250px;
padding:5px;
background-color:#eee;
border:1px solid black;
margin:5px;
margin-left:10px;
}
#photo, #content #photo h1 {
font:14pt Times;
text-align:left;
margin:2px;
}
#photo, #content #photo p {
font:8pt Georgia;
line-height:10pt;
border:none;
text-transform:none;
text-align:justify;
margin:1px;
padding:0px;
}
#photo, #content #photo p.byline {
color:#aaa;
 text-transform:capitalize;
text-align:right;
font-style:italic;
} */
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
<!-- Start Content -->
<?php
  $photo = get_photos($article_id);
  $site = lookup_site($article_id);

  while($data = $photo->fetchRow()) {
     $path = $data->path;
     $cutline = $data->cutline;
     $photoby = $data->photoby;
     $width = $data->width;
     $height = $data->height;

    switch($site) { // This is for testing on a single site;
      case 1:
        $path = "http://www.lakechelanmirror.com/".$path;
        break;
      case 2:
        $path = "http://www.gazette-tribune.com/".$path;
        break;
      case 3:
        $path = "http://www.cashmerevalleyrecord.com/".$path;
        break;
      case 4:
        $path = "http://www.leavenworthecho.com/".$path;
        break;
    }
?>
<!-- Start Photo -->
<div id="photo">
<img src="<?= $path ?>" width="<?= $width ?>" height="<?= $height ?>">
<p class="byline"><?= $photoby ?></p>
<p><?= $cutline ?></p>
</div>
<!-- End Photo -->
<? } ?>
<!-- End story -->
 </body>
</html>
