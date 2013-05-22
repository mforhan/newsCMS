<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php
 include('application.inc.php');

// if(!isLoggedin()) {
//    Header('location: login.php');
// }

if($_POST) {
 $article = $_POST['article'];
 $url     = $_POST['url'];
 $path    = $_POST['path'];
 $cutline = $_POST['cutline'];
 $photoby = $_POST['photoby'];

 // print_r($_POST);
 if(insert_photo($article,$url,$path,$cutline,$photoby,1)) {
   unset($_POST); 
 }
}

 if($_GET) {
   $article_id = $_GET['article_id'];
 }
?>
<html>
 <head>
  <title><?= $THEME->site_title ?></title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
  <style type="text/css">
body {
/* background-color:#004;
margin:10px; */
}
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
#flyover #photo {
width:250px;
padding:10px;
margin:15px;
border:1px solid black;
background-color:#ddd;
}
#flyover #photo p {
margin:0px;
margin-top:2px;
width:100%;
padding:0px;
}
#flyover #photo p textarea {
font:8pt georgia;
text-align:justify;
border:none;
background-color:#ddd;
width:100%;
}
#flyover #photo p.byline {
text-align:right;
margin:0px;
padding:0px;
}
#flyover #photo p.byline input{
font:8pt georgia;
font-style:italic;
color:gray;
text-align:right;
border:none;
background-color:#ddd;
padding-right:2px;
}
#pageContent {
  width:350px;
  border:1px solid black;
  background-color:#ddd;
  padding:10px;
  margin:30%;
}
#pageContent p {
  font:12pt georgia black;
}
#flyover {
  width:300px;
  /* height:100px; */
  position:absolute;
  z-index:20;
  border:1px solid black;
  background-color:#488;
  display:block;
  left:35%;
  top:10%;
  visibility:hidden;
}
#flyover p {
  font: 10pt georgia black;
  text-align:center;
}
#flyover #head img {
  padding:2px;
  padding-right:0px;
  width:16px;
  height:16px;
  border:none;
}
#flyover #head p {
  height:20px;
  font: 12pt Geneva black;
  background-color:#0aa;
  padding:0px;
  padding-top:5px;
  margin-top:0px;
  text-align:center;
}
#disabler {
background: url('../images/50percent.png') repeat;
position:absolute;
width:100%;
height:100%;
top:0px;
left:0px;
z-index:10;
visibility:hidden;
}
#disabler img {
 width:100%;
 height:100%;
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
<script type="text/javascript">
var ie = document.all;
var dom = document.getElementById;

function moveFlyover() {
  leftVal = parseInt(document.all.flyover.style.left); // .style.left;
  if(leftVal == -40) {
    setTimeout('disablePage()',0);
  }
  if(leftVal < 35) {
    flyover.style.left = (leftVal+1)+"%";
  } else {
    clearInterval(showtime);
  }
}
function disablePage() {
 // alert('test');
 var selected = document.all.url.selectedIndex;
 var site = document.all.url.options[selected].value; 
 // alert('Value ['+document.all.path.value+']');
 document.all.path.disabled=true;
 document.all.photoby.disabled=true;
 document.all.cutline.disabled=true;
 document.all.previewImg.src=site+"/"+document.all.path.value;
 document.all.previewByline.value=document.all.photoby.value;
 document.all.previewCutline.value=document.all.cutline.value;
 document.all.disabler.style.visibility='visible'; 
 document.all.flyover.style.visibility='visible';
 return false;
}
function abortPage() {
 document.all.disabler.style.visibility='hidden';
 document.all.flyover.style.visibility='hidden';
 document.all.path.disabled=false;
 document.all.photoby.disabled=false;
 document.all.cutline.disabled=false;
 document.all.previewCutline.value = null;
 document.all.previewByline.value = null;
 document.all.previewImg.src = null;
}
function acceptPage() {
 document.all.disabler.style.visibility='hidden';
 document.all.flyover.style.visibility='hidden';
 document.all.path.disabled=false;
 document.all.photoby.disabled=false;
 document.all.cutline.disabled=false;
 document.all.photoForm.submit(); 
}
window.onload = function() {
  // var seconds = 15;
  // document.all.flyover.style.left = -50+"%"; // .style.left;
  // showtime = setInterval('moveFlyover()',seconds*1000);
  // showtime = setInterval('moveFlyover()',5);
  // showtime = setTimeout('disablePage()',seconds*1000);
}
</script>
 </head>
 <body>
  <div id="disabler"></div>
 <? include('nav.html'); ?>
  <table style="border:1px solid black;width:800px;overflow:hidden;margin:10px;background:white;">
   <form action="<?= $PHP_SELF ?>" method="post" name="photoForm"><!--target="_blank">-->
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
     <input type="reset"><input type="button" value="Submit" onClick="return disablePage();">
   </td></tr>
   </form>
  </table>
  <!--<div id="pageContent">
   <p>This Page features a javascript flyover, the idea is that I can 'disable' the content on this page and have a status float over, and when finished, reenable this page.</p>
   <p>This flyover feature will be used on the login/logout page, and on pages that require previews, like the photo page</p>
   <input type="button" onClick="javascript:disablePage();" value="Preview">
  </div>-->
    <!--<img src="images/mac_close_inactive.png" align="left" onMouseOver="javascript:this.src='images/mac_close_active.png';" onMouseout="javascript:this.src='images/mac_close_inactive.png';" style="padding-left:5px;" onClick="abortPreview();">-->
    <!--<img src="images/mac_minimize_inactive.png" align="left" onMouseOver="javascript:this.src='images/mac_minimize_active.png';" onMouseout="javascript:this.src='images/mac_minimize_inactive.png';" style="padding-left:1px;">-->
<!-- Start Content -->
<!-- Start Photo -->
  <div id="flyover">
   <div id="head">
    <p>Image Preview</p>
   </div>
    <div id="photo">
     <img name="previewImg" src=""/>
     <p class="byline"><input type="text" name="previewByline" align="right"></p>
     <p><textarea name="previewCutline"></textarea></p>
    
    </div>
    <p>
     <input type="button" onClick="abortPage()" value="Cancel">
     <input type="button" onClick="acceptPage()" value="Accept">
    </p>
  </div>
<!-- End Photo -->
<!-- End story -->
 </body>
</html>
