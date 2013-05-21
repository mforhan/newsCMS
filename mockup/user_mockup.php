<?
 include('../application.inc.php');

 if($HTTP_GET_VARS) {
  $author = $HTTP_GET_VARS['author'];
  $res = getArticlesByAuthor($author,20);
 }
?><!OCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
 <head>
  <title>EchoCMS :: User Profile</title>
  <link rel="stylesheet" href="css/site.css" type="text/css"/>
  <!--<link rel="stylesheet" href="css/two_tone.css" type="text/css" id="color"/>-->
  <script type="text/javascript">
<!-- // Start Javascript
// window.onload = function() {
// }
     // End Javascript -->
  </script>
 </head>
 <body>
  <div id="header">
    <p><a href="">Main</a> : <a href="">Profile</a></p>
  </div>
  <div id="container">
   <div class="left">
     <!-- Start Column Data -->
     <img src="photos/john_q_public.jpg" />
     <p>John Q Public</p>
     <p>Staff Writer</p>
     <p>The Leavenworth Echo</p>
     <ul>
       <li><a href="edit.php">New Story</a>&nbsp;</li>
       <li><a href="">Management</a>&nbsp;</li>
       <li><a href="">Profile</a>&nbsp;</li>
       <li><a href="">Blog</a>&nbsp;</li>
       <li><a href="">Podcast</a>&nbsp;</li>
       <li><a href="">Logout</a>&nbsp;</li>
     </ul>
     <!-- End Column Data -->
   </div>
   <!-- Start Content Area -->
    <div id="content">
     <?php include('manage.php'); ?>
    </div>
   <!-- End Content Area -->
  </div>
  <!--<div id="footer">
    <p>All content copyright &copy; 2006, Prairie Media Inc.</p>
  </div>-->
 </body>
</html>
