<?php
/* This file should consist only of Read-only operations */

function return_static_page_titles() {
  global $title_template,$db;

  $sql = "SELECT article_id,title,date_format(date_stamp,'%m/%d/%Y') as date,isActive
            FROM static_content
        ORDER BY date_stamp DESC";

  try {
    $results = $db->prepare($SQL);
    $results->execute();
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  $content = '';
 
  while($data = $results->fetch(PDO::FETCH_OBJ)) {
    $checked = '';
    $article = $data->article_id;
    $title = $data->title;
    $date = $data->date;
    $isactive = $data->isActive;
    if($isactive) {
      $checked = ' checked';
    }

    if(!$even) {
    $content .= "\n<!--Line Item Start-->
     <div class=\"odd\">
      <div class=\"date\">$date</div>
      <input type=\"checkbox\"$checked>
      <a href=\"?action=edit&section=articles&edit=$article\">$title</a>
     </div>\n<!--Line Item End-->";
    } else {
    $content .= "\n<!--Line Item Start-->
     <div class=\"even\">
      <div class=\"date\">$date</div>
      <input type=\"checkbox\"$checked>
      <a href=\"?action=edit&section=articles&edit=$article\">$title</a>
     </div>\n<!--Line Item End-->";
    }

  } 
  return $content;
}

/* END RETURN ROUTINES FOR ADMIN */
function retrieve_titles() {
  global $title_template,$db;

  $sql = "SELECT article_id,headline,date_format(date_stamp,'%m/%d/%Y') as date,isActive
            FROM content
        ORDER BY date_stamp DESC";

  try {
    $results = $db->prepare($SQL);
    $results->execute();
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  while($data = $results->fetch(PDO::FETCH_OBJ)) {
    $checked = '';
    $article = $data->article_id;
    $title = $data->title;
    $date = $data->date;
    $isactive = $data->isActive;
    if($isactive) {
      $checked = ' checked';
    }
    include($title_template);
  } 
}

/* this function generates a select list by date */
function retrieve_list_titles() {
  global $title_template,$db_conn;

  $string = '';

  $sql = "SELECT article_id,title,date_format(date_stamp,'%m/%d/%Y') as date
            FROM content
        ORDER BY date_stamp DESC";

  try {
    $results = $db->prepare($SQL);
    $results->execute();
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }
  
  while($data = $results->fetch(PDO::FETCH_OBJ)) {
    $article_id = $data->article_id;
    $title = $data->title;
    $date = $data->date;
    if( $date == $string ) {
      $datestr = ''; 
    } else {
      $datestr = $date;
      $string = $date;
    }
    include($title_template);
  } 
}

function retrieve_articles($default_article) {
  global $photo_template,$db;

  $string = '';

  $sql = "SELECT article_id, headline
            FROM content 
        ORDER BY article_id DESC
           LIMIT 50";
        // ORDER BY date_stamp DESC";

  try {
    $results = $db->prepare($SQL);
    $results->execute();
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  while($data = $results->fetch(PDO::FETCH_OBJ)) {
    $article_id = $data->article_id;
    $art_title = $data->headline;
    if($article_id == $default_article) {
      $string = ' selected';
    } else {
      $string = '';
    }
    print "<option value=\"$article_id\">$art_title</option>\n";
  }
}

function edit_photo($photo_id) {
  global $db;
  $sql = "SELECT article_id,photo_id,path,cutline,photoby,
                 width,height,isactive
            FROM webphoto
           WHERE photo_id = :photo";

  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':photo' => $photo_id));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }
 
  return $results;
}
/* GET Functions */
function get_photos($article_id) {
  global $db;
  
  if(!$article_id) {
    return -1;
  }
  
  $SQL = "SELECT path,cutline,photoby,width,height
            FROM webphoto
           WHERE article_id= :article
             AND isActive = 1";

  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':article' => $article_id));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  return $results;
}
function getArticles($pos) {
  global $db;
  $SQL = "SELECT a.article_id,a.headline,b.name as status,a.author_name,
                 a.hasPhoto
            FROM content a,
                 status b
           WHERE a.isActive=1
             AND a.status=b.status_id
        ORDER BY a.date_stamp DESC
           LIMIT $pos,20";
 
  try {
    $results = $db->prepare($SQL);
    $results->execute();
    //  $data = $results->fetch(PDO::FETCH_OBJ);
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  return $results;
}
function getArticle($id) {
  global $db;
  $SQL = "SELECT article_id,headline,subhead,body,author_name,author_title,
                 body
            FROM content
           WHERE article_id= :article
           LIMIT 1";

  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':article' => $id));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }
 
  return($results->fetch(PDO::FETCH_OBJ));
}
// function getArticlesByAuthor($name) {
function getArticlesByAuthor($name,$limit=10) {
  global $db;
  $SQL = "SELECT a.article_id,a.headline, a.body, a.author_name,
                 date_format(a.date_stamp,'%m/%d/%Y') as date,
                 b.name as status, a.hasPhoto
            FROM content a,
                 status b
           WHERE a.status = b.status_id
             AND a.author_name like :name
        ORDER BY a.date_stamp DESC
           LIMIT $limit";

  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':name' => $name));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }
  return $results;
}

/* END Get Functions */

function lookup_site($article_id) {
  global $db;
  
  if(!$article_id) {
    return -1;
  }
  
  $SQL = "SELECT site_id
            FROM site_content
           WHERE content_id= :article";

  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':article' => $article_id));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  $sites = $results->fetch(PDO::FETCH_OBJ);
  return $sites->site_id;
}
function getSiteInfo($article) {
  global $db;
  $SQL = "SELECT b.site_name, a.section_name,
                 date_format(a.publish_date,'%m/%d/%Y') as date
            FROM site_content a,
                 sites b
           WHERE content_id= :article
             AND a.site_id=b.site_id";
  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':article' => $article));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }
  return $results;
}
function getSections($site) {
  global $db;

  $SQL = "SELECT DISTINCT(section_name)
            FROM site_content
           WHERE site_id= :site";

  try {
    $results = $db->prepare($SQL);
    $results->execute(array(':site' => $site));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  return $results;
}
function getHeadline($article) {
  global $db;
  $SQL = "SELECT headline
            FROM content
           WHERE article_id= :article";
  
try {
    $results = $db->prepare($SQL);
    $results->execute(array(':article' => $article));
  } catch(PDOException $e) {
    trigger_error('ERROR: ' . $e->getMessage(), E_USER_ERROR);
  }

  $data = $results->fetch(PDO::FETCH_OBJ);
  return $data->headline;
}

/* Taken from comments @ php.net (http://us2.php.net/manual/en/ref.image.php) */
function imagecreatefromfile($filename) {
   static $image_creators;
   if(!isset($image_creators)) {
     $image_creators = array(
        1  => "imagecreatefromgif",
        2  => "imagecreatefromjpeg",
        3  => "imagecreatefrompng",
        16 => "imagecreatefromxbm"
     );
   }
  
   $image_size = getimagesize($filename);
   if(is_array($image_size)) {
     $file_type = $image_size[2];
     if (isset($image_creators[$file_type])) {
       $image_creator = $image_creators[$file_type];
       if(function_exists($image_creator)) {
         return $image_creator($filename);
       }
     }
   }

   // "imagecreatefrom...() returns an empty string on failure"
   return "";
}

?>
