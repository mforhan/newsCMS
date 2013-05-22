<?
 include('application.inc.php');

 if($_GET) {
  $author = $_GET['author'];
  $res = getArticlesByAuthor($author);
 }
?>
<html>
 <head>
  <title>Story Summary</title>
  <link href="css/menu_bar_admin.css" rel="stylesheet" type="text/css">
 </head>
 <body>
 <? include('nav.html'); ?>
<?
 while($story = $res->fetch(PDO::FETCH_OBJ)) {
   $article  = $story->article_id;
   $headline = $story->headline;
   $body     = $story->body;
   $author   = $story->author_name;
   $create   = $story->date;
   $status   = $story->status;
   $hasPhoto = $story->hasPhoto;
   
   ereg('(.[^\.]+\.\ *[0-9]*.[^\.]*\.){2}',$body,$sentence); 
   $body = $sentence[0]; //." ".$sentence[1];

?>
  <div style="border:1px solid black;width:796px;margin:10px;margin-top:10px;margin-bottom:0px;padding:2px;background:white;" cellspacing="0">
  <table>
   <tr>
    <td colspan="2" style="background:lightgray;">
     <h3><?= $icon ?><a href="edit.php?article_id=<?= $article ?>"><?= $headline ?></a></h3>
    </td>
   <tr>
    <td width="33%">
     <table cellspacing=0 cellpadding=0>
       <tr><td style="font-weight:bold;">Author:</td><td><?= $author ?></td></tr>
       <tr><td style="font-weight:bold;">Written On:</td><td><?= $create ?></td></tr>
       <tr><td style="font-weight:bold;">Sent to Proof:</td><td> 12/06/2005</td></tr>
       <tr><td style="font-weight:bold;">Proofed:</td><td> 12/06/2005</td></tr>
       <tr><td style="font-weight:bold;">Sent to Editor:</td><td> </td></tr>
       <tr><td style="font-weight:bold;">Sent to Layout:</td><td> </td></tr>
       <tr><td style="font-weight:bold;">Published:</td><td> </td></tr>
     </table>
    </td>
    <td valign="top">
     <span style="font-weight:bold;">Column Inches:</span> 73.5
      <span style="color:goldenrod;"><?= $status ?></span><br/><br/>
     <span style="font-weight:bold;">Summary:</span> <?= $body ?><br/>
    </td>
   </tr>
<? 
 if($hasPhoto) {
    $photo = get_photos($article);
    $site  = lookup_site($article);
?>
   <tr>
    <td colspan=2 style="background:lightgray;">Photos
    </td>
   </tr>
   <tr>
   <td colspan=2>
<?
    while($data = $photo->fetch(PDO::FETCH_OBJ)) {
       $path = $data->path;
       // $cutline = $data->cutline;
       // $photoby = $data->photoby;
       $width = $data->width;
       $height = $data->height;
   
    switch($site) {
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
   
    $height = $height/2;
    $width = $width/2;
?>
   <img src="<?= $path ?>" width="<?= $width ?>" height="<?= $height ?>">
   <!--<img src="" width="125" height="90">
   <img src="" width="125" height="90">
   <img src="" width="125" height="90">
   <img src="" width="125" height="90">
   <img src="" width="125" height="90">-->
<? 
    } // End Photo While
?>
   </td> 
    </tr>
<?
 } // End Photo If
?>
    <tr>
     <td>
      Escalate:
      <input type="radio" name="one">
      <input type="radio" name="one">
      <input type="radio" name="one">
      <input type="radio" name="one">
      <input type="radio" name="one">
      <input type="radio" name="one">
      <input type="radio" name="one">
     </td>
     <td align="right">
      <input type="reset"><input type="submit" value="Edit">
     </td>
    </tr>
   </table>
  </div>
<? } // End While ?>
 </body>
</html>
