<?php
// Directory Display
$dir = opendir('inbox');
print "<h3 style=\"margin-bottom:0px;\">Files waiting to be processed</h3>\n";
print "<hr/>\n";
?>
<html>
 <head>
  <title>Directory Gallery</title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
  <style type="text/css">
body {
/* background-color:#004; */
margin:10px;
}
#photo {
width:250px;
padding:10px;
margin-right:10px;
border:1px solid black;
background-color:#ddd;
float:left;
padding-top:5px;
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
#photo img {
  border:none;
}
#photo #nav {
  float:right;
  padding:0px;
  margin:0px;
  /* background:white;
  width:100%; */
}
#photo #nav img {
  border:none;
}
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
<?
while($file = readdir($dir)) {
 if(is_file("inbox/".$file)) {
   // print "$file<br/>\n";
?>
  <div id="photo">
   <div id="nav">
    <img src="../images/mac_minimize_inactive.png" onMouseOver="javascript:this.src='../images/mac_minimize_active.png';" onMouseout="javascript:this.src='../images/mac_minimize_inactive.png';">
    <img src="../images/mac_maximize_inactive.png" onMouseOver="javascript:this.src='../images/mac_maximize_active.png';" onMouseout="javascript:this.src='../images/mac_maximize_inactive.png';">
    <img src="../images/mac_close_inactive.png" onMouseOver="javascript:this.src='../images/mac_close_active.png';" onMouseout="javascript:this.src='../images/mac_close_inactive.png';">
   </div>
   <img src="inbox/<?= $file ?>" width="250">
   <p><?= $file ?></p>
  </div>
<?
 }
}
print "<hr style=\"clear:both;margin-top:5px;\"/>\n";
closedir($dir);
?>
 </body>
</html>
