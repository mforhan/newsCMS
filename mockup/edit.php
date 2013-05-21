<?

if($HTTP_POST_VARS || $HTTP_GET_VARS) {
 if($HTTP_GET_VARS['article_id']) {
   $article_id = $HTTP_GET_VARS['article_id'];
   $data = getArticle($article_id);
   $headline     = $data->headline;
   $subhead      = $data->subhead;
   $author_name  = $data->author_name;
   $author_title = $data->author_title;
   $body         = $data->body;
 } else {
   $headline = $HTTP_POST_VARS['headline'];
   $subhead  = $HTTP_POST_VARS['subhead'];
   $body = $HTTP_POST_VARS['bodyContent'];
   $author_name   = $HTTP_POST_VARS['author'];
   $author_title  = $HTTP_POST_VARS['title'];
   $article_id = $HTTP_POST_VARS['article'];
   if($article_id) {
     // update_article($article_id,$headline,$subhead,$body,$author_name,$author_title,1);
   } else {
     // if(insert_article($headline,$subhead,$body,$author_name,$author_title,1)) {
       // We need to throw an error and then repopulate the fields with data
       // print "<h3 style='color:red;'>Inserting... </h3>";
       // unset($HTTP_POST_VARS); 
     // } else {
       print "<h3 style='color:red;'>Database Insert Failed</h3>";
     // }
   }
 }
 //  print_r($HTTP_POST_VARS);
}
?>
  <table style="border:1px solid black;width:40%;min-width:530px;;overflow:hidden;margin:0;background:white;">
   <form action="<?= $PHP_SELF ?>" method="post" target="_blank" name="content">
   <!-- Headline Block -->
   <tr><td style="width:100px;">Headline: </td><td colspan="3"><input type="text" name="headline" style="width:100%" value="<?= $headline; ?>"></td></tr>
   <tr><td>Subhead: </td><td colspan="3"><input type="text" name="subhead" style="width:100%" value="<?= $subhead; ?>"></td></tr>
   <!-- End Headline Block -->
   <!-- Start Author Block :: Only show if admin? -->
   <tr style="display:auto;"><td>Author Name: </td><td><input type="text" size="8" name="author" style="width:100%" value="<?= $author_name; ?>"/></td><td>Author Title:</td><td><input type="text" name="title" style="width:100%" value="<?= $author_title; ?>"></td></tr>
   <!-- End Author Block -->
   <!-- Main Content Block -->
   <tr><td colspan="4">
    <textarea name="bodyContent" style="WIDTH: 100%; HEIGHT: 350px"><?= $body; ?></textarea>
   </td></tr>
   <!-- End Main Content -->
   <tr><td>Col Inches:</td><td colspan="2"><input type="text" disabled align="right" name="bodyCount"></td><td><input type="button" name="fire" value="Count" onClick="javascript:countWords();">
   </tr>
   <tr><td colspan="4" align="right"><input type="hidden" name="article" value="<?= $article_id ?>"><input type="reset"><input type="submit"</td></tr>
   </form>
  </table>
