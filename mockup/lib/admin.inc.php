<?php
/* BEGIN INSERTION ROUTINES FOR ADMIN */ 

function insert_article($headline,$subhead,$body,$author_name,$author_title,$isactive) {
  global $db;
   
  $date = 'curdate()'; 
  $time = 'curtime()';
 
  if(!$isactive) {
    $isactive = 0;
  }

  if(!$body || !$headline) {
    die("No Body or Title submitted!");
  }

  $body = addslashes($body); 
  $headline = addslashes($headline); 
  $subhead = addslashes($subhead);
 
  $body = eregi_replace("<p><p>","<p>",$body);
  $body = eregi_replace("</p></p>","</p>",$body);
  $body = eregi_replace("<p>&nbsp;</p>","",$body);
  $body = eregi_replace("<p> </p>","",$body);

  // $body = eregi_replace("<br />","\n",$body);
  // $body = eregi_replace("\n\n","\n",$body);
  // $body = eregi_replace("\n","</p><p>",$body);
  // $body = eregi_replace("<p>&nbsp;</p>","",$body);
  // $body = eregi_replace("<p> </p>","",$body);

  $SQL = "INSERT INTO content
                 (headline,subhead,body,author_name,author_title,status,date_stamp,time_stamp,isActive)
          values ('$headline','$subhead','$body','$author_name','$author_title',6,$date,$time,$isactive)";

  $result = $db->query($SQL);

  if(DB::iserror($result)) {
   // die($results->getMessage());
    trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
  // trigger_error ("" , E_USER_WARNING);
  } else {
    return "Database successfully updated";
  }
 
}
function test_insert_article($headline,$subhead,$body,$author_name,$author_title,$isactive) {
  global $db;
   
  $date = 'curdate()'; 
  $time = 'curtime()';
 
  if(!$isactive) {
    $isactive = 0;
  }

  if(!$body || !$headline) {
    die("No Body or Title submitted!");
  }

  $body = addslashes($body); 
  $headline = addslashes($headline); 
  $subhead = addslashes($subhead);
 
  $body = eregi_replace("<p><p>","<p>",$body);
  $body = eregi_replace("</p></p>","</p>",$body);
  $body = eregi_replace("<p>&nbsp;</p>","",$body);
  $body = eregi_replace("<p> </p>","",$body);

  // $body = eregi_replace("<br />","\n",$body);
  // $body = eregi_replace("\n\n","\n",$body);
  // $body = eregi_replace("\n","</p><p>",$body);
  // $body = eregi_replace("<p>&nbsp;</p>","",$body);
  // $body = eregi_replace("<p> </p>","",$body);

  $SQL = "INSERT INTO content
                 (headline,subhead,body,author_name,author_title,status,date_stamp,time_stamp,isActive)
          values ('$headline','$subhead','$body','$author_name','$author_title',6,$date,$time,$isactive)";

  print "INSERTING<br/>\n<pre>$SQL</pre><br/>\n";
  // $result = $db->query($SQL);

  // if(DB::iserror($result)) {
   // // die($results->getMessage());
   // trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
  // // trigger_error ("" , E_USER_WARNING);
  // } else {
    return "Database successfully updated";
  // }
 
}
function test_update_article($article_id,$headline,$subhead,$body,$author_name,$author_title,$isactive) {
  global $db;
   
  if(!$isactive) {
    $isactive = 0;
  }

  if(!$article_id) {
   die("Unable to update data, no ID Specified");
  }
  $orig_data = getArticle($article_id);
  $orig_body = $orig_data->body;

  $body = addslashes($body); 
  $headline = addslashes($headline); 
  $subhead = addslashes($subhead);
 
  $body = eregi_replace("<p><p>","<p>",$body);
  $body = eregi_replace("</p></p>","</p>",$body);
  $body = eregi_replace("<p>&nbsp;</p>","",$body);
  $body = eregi_replace("<p> </p>","",$body);

  // $body = eregi_replace("<br />","\n",$body);
  // $body = eregi_replace("\n\n","\n",$body);
  // $body = eregi_replace("\n","</p><p>",$body);
  // $body = eregi_replace('<p>&nbsp;</p>','',$body);
  // $body = eregi_replace('<p> </p>','',$body);

  /* $sql =  "UPDATE content
              SET headline='$headline',
                  subhead='$subhead',
                  body='$body',
                  author_name='$author_name',
                  author_title='$author_title',
                  isactive=$isactive
            WHERE article_id=$article_id"; */

  $diff = xdiff_string_diff($old_body, $body, 1);
  // $diff = `diff $old_body $body`;
  // $result = $db->query($sql);
  // print "Updating:<br/>\n$sql<br/>\n";
  print "Updating:<br/>\n[$diff]<br/>\n";

  /* print_r($result); */
  // if(DB::iserror($result)) {
   // // die($results->getMessage());
    // trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
  // // trigger_error ("" , E_USER_WARNING);
  // } else {
    return "Database successfully updated";
  // }
 
}

function insert_photo($article,$url,$path,$cutline,$photoby,$isactive) {
  global $db;

  if(!$path || !$cutline) {
    die("No Photo or Cutline submitted!");
  }

  $img = getimagesize($url."/".$path);
  if($img) {
    $imgW = $img[0];
    $imgH = $img[1];
  }

  if(!$isactive) {
    $isactive = 1;
  }
  $cutline = addslashes($cutline);
 
  $sql = "INSERT into webphoto 
                 (article_id, path, photoby, cutline, width, height,isactive)
          VALUES ($article,'$path','$photoby','$cutline',$imgW,$imgH,$isactive)";
  $result = $db->query($sql);

  if(DB::iserror($result)) {
   // die($results->getMessage());
    trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
  // trigger_error ("" , E_USER_WARNING);
  }

  $sql = "UPDATE content
             SET hasphoto=1
           WHERE article_id=$article";

  $result = $db->query($sql);

  if(DB::iserror($result)) {
   // die($results->getMessage());
    trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
  // trigger_error ("" , E_USER_WARNING);
  } else {
    return "Database successfully updated";
  }
}
function setSite($article,$section,$site) {
  global $db;
  
  $date = 'curdate()'; 

  $SQL = "INSERT INTO site_content (content_id,section_name,site_id,publish_date,isActive)
               VALUES ($article,'$section',$site,$date,1)";
  $res = $db->query($SQL);
  return $res;
}
/* END INSERTION ROUTINES FOR ADMIN */ 

/* BEGIN UPDATE ROUTINES FOR ADMIN */
function update_article($article_id,$headline,$subhead,$body,$author_name,$author_title,$isactive) {
  global $db;
   
  if(!$isactive) {
    $isactive = 0;
  }

  if(!$article_id) {
   die("Unable to update data, no ID Specified");
  }

  $body = addslashes($body); 
  $headline = addslashes($headline); 
  $subhead = addslashes($subhead);
 
  $body = eregi_replace("<p><p>","<p>",$body);
  $body = eregi_replace("</p></p>","</p>",$body);
  $body = eregi_replace("<p>&nbsp;</p>","",$body);
  $body = eregi_replace("<p> </p>","",$body);

  // $body = eregi_replace("<br />","\n",$body);
  // $body = eregi_replace("\n\n","\n",$body);
  // $body = eregi_replace("\n","</p><p>",$body);
  // $body = eregi_replace('<p>&nbsp;</p>','',$body);
  // $body = eregi_replace('<p> </p>','',$body);

  $sql =  "UPDATE content
              SET headline='$headline',
                  subhead='$subhead',
                  body='$body',
                  author_name='$author_name',
                  author_title='$author_title',
                  isactive=$isactive
            WHERE article_id=$article_id";

  $result = $db->query($sql);

  /* print_r($result); */
  if(DB::iserror($result)) {
   // die($results->getMessage());
    trigger_error ("Insert Error:".$result->getMessage() , E_USER_ERROR);
  // trigger_error ("" , E_USER_WARNING);
  } else {
    return "Database successfully updated";
  }
 
}
function update_photo($photo_id, $article_id, $path, $cutline, $photoby_id, $width, $height, $isactive) {
  global $db;
 
  if(!$photo_id) {
   die("Unable to update data, no ID Specified");
  }
 
  $sql =  "UPDATE webphoto
              SET article_id=$article_id,
                  path='$path',
                  cutline='$cutline',
                  photoby=$photoby_id,
                  width=$width,
                  height=$height,
                  isactive=$isactive
            WHERE photo_id=$photo_id";

  $result = $db->query($sql);

  if(DB::iserror($result)) {
   // die($results->getMessage());
    trigger_error ("Update Error:".$result->getMessage() , E_USER_ERROR);
  // trigger_error ("" , E_USER_WARNING);
  } else {
    return "Database successfully updated";
  }
}
/* END UPDATE ROUTINES FOR ADMIN */
function _getArticles($pos) {
  global $db;
  $SQL = "SELECT a.article_id,a.headline,b.name as status,a.author_name,
                 a.hasPhoto
            FROM content a,
                 status b
           WHERE a.isActive=1
             AND a.status=b.status_id
        ORDER BY a.date_stamp DESC
           LIMIT $pos,20";
 
  $results = $db->query($SQL);
  return($results);
}
function _getSiteInfo($article) {
  global $db;
  $SQL = "SELECT b.site_name, a.section_name,
                 date_format(a.publish_date,'%m/%d/%Y') as date
            FROM site_content a,
                 sites b
           WHERE content_id=$article
             AND a.site_id=b.site_id";
  $results = $db->query($SQL);
  return($results);
}
?>
