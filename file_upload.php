<?php
// print_r($HTTP_POST_FILES);
$images = $HTTP_POST_FILES['imageUpload'];

if(is_uploaded_file($images['tmp_name'])) {
  move_uploaded_file($images['tmp_name'],"inbox/".$images['name']);
  // print "<img src=\"inbox/".$images['name']."\">";
}
$dir = opendir('inbox');
print "<h3 style=\"margin-bottom:0px;\">Files waiting to be processed</h3>\n";
print "<hr/>\n";
while($file = readdir($dir)) {
 if(is_file("inbox/".$file)) {
   print "$file<br/>\n";
 }
}
print "<hr/>\n";
closedir($dir);
?>
<html>
 <head>
  <title>File Uploader</title>
 </head>
 <body>
  <form action="<?= $PHP_SELF ?>" enctype="multipart/form-data" method="POST">
   <input type="file" name="imageUpload">
   <input type="submit" value="Upload">
  </form>
 </body>
</html>
