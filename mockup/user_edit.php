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
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex, nofollow">
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="FCKeditor/fckconfig.js"></script>
  <script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
  <script type="text/javascript">
<!-- // Start Javascript
//  info = window.open("","info2","toolbar=0,scrollbars=0,statusbar=0,location=0,menubar=0,width=800,height=600");
function countWords() {
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('bodyContent') ;

	// Get the editor contents in XHTML.
        iValue = oEditor.GetXHTML(false);

	// alert( oEditor.GetXHTML( false ) ) ;
        // alert('Values {'+iValue+'}');
        iLength = (iValue.split(" ").length / 30);
        // alert('Values {'+iLength+'}');
        iLength = Math.round(iLength*10);
        iLength = iLength/10;
        document.content.bodyCount.value = iLength;
}
window.onload = function() {
  var seconds = 15;
  var oFCKeditor = new FCKeditor( 'bodyContent' ) ;
  oFCKeditor.BasePath = 'FCKeditor/' ;	// '/fckeditor/' is the default value.
  oFCKeditor.Height = '350' ;
  oFCKeditor.ToolbarSet	= 'Reporter' ;
  // oFCKeditor.Config['CustomConfigurationsPath'] = 'wordcount.config.js' ;
  //oFCKeditor.Config['CounterName'] = 'CharsCounter' ;
  oFCKeditor.ReplaceTextarea() ;
  setInterval('countWords()',seconds*1000);
}
     // End Javascript -->
  </script>
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
     <?php include('edit.php'); ?>
    </div>
   <!-- End Content Area -->
  </div>
  <!--<div id="footer">
    <p>All content copyright &copy; 2006, Prairie Media Inc.</p>
  </div>-->
 </body>
</html>
