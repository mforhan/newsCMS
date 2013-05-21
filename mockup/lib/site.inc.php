<?php
/* This File should only contain routines necessary for displaying a webpage */

/* queryDB is a generic DB Query Wrapper with trigger error support */
function queryDB($sql) {
  global $db;

  if(!$sql) {
    trigger_error("Error: Query Involked without statement", E_USER_ERROR);
  }

  $results = $db->query($sql);

  if(DB::iserror($results)) {
    trigger_error ("Select Error:".$results->getMessage() , E_USER_ERROR);
  } else {
    return $results;
  }
}

// FUNCTIONS ///////////////////////////////////////////////////////////////////
// At this point, all functions should be:
// 	- Check Input
//	- Define Query
//	- Send to queryDB

// All the Queries in this file should consist of:
// 	- Get Article
//	- Get Photo Related to Article (Story)
//	- Get Photos Related to Article (Slideshow)

function retrieve_content($section,$number,$style,$article_date=FALSE) {
  if ((!$section) || (!$number))  {
    trigger_error ("Error: No Article Specified for Photo Retrieval", E_USER_ERROR); //_NOTICE);
  }
  if (!$style) { 
    $style = 'FULL';
  }

  // Article Date Allows More Direct access to stories by Date
  if($article_date) {
    $switchSQL = "SELECT article_id, hasPhoto
		    FROM content
		   WHERE section_id='$section'
		     AND date_stamp='$article_date'
		     AND isActive=1
		ORDER BY date_stamp DESC
		   LIMIT $number";
  } else {
    $switchSQL = "SELECT article_id, hasPhoto
		    FROM content
		   WHERE section_id='$section'
		     AND isActive=1
		ORDER BY date_stamp DESC
		   LIMIT $number";
  }

  $switchResults = queryDB($switchSQL);
  $switchData = $switchResults->fetchRow();
  $article = $switchData->article_id;
  $switch  = $switchData->hasPhoto;

  if((int) $switch == 1) {
    $SQL = "SELECT a.section_id as section_id, a.title as headline, 
                   a.subtitle as subhead, a.body as story,
                   date_format(a.date_stamp,'%M %D, %Y') as date,
                   b.real_name as byline, b.title as authortitle,
                   c.path as path, c.cutline as cutline, c.width as width, c.hei
                   d.real_name as photoby
              FROM content as a, user as b, webphoto as c,
                   user as d
             WHERE a.author_id=b.user_id
               AND a.article_id=c.article_id
               AND a.article_id=$article
               AND c.photoby=d.user_id
               AND a.section_id='$section'
               AND a.isActive=1
               AND c.isActive=1
          ORDER BY a.date_stamp
             LIMIT $number";
  } else {
    $SQL = "SELECT a.section_id as section_id, a.title as headline, 
                   a.subtitle as subhead, a.body as story,
                   date_format(a.date_stamp,'%M %D, %Y') as date,
                   b.real_name as byline, b.title as authortitle
              FROM content as a, user as b
             WHERE a.author_id=b.user_id
               AND a.article_id=$article
               AND a.section_id='$section'
               AND a.isActive=1
          ORDER BY a.date_stamp
             LIMIT $number";
  }

  return queryDB($SQL);
}

// OLD
function get_photos($article_id) {
  global $db;
  
  if(!$article_id) {
    trigger_error ("Error: No Article Specified for Photo Retrieval", E_USER_ERROR);
  }
  
  $SQL = "SELECT path,cutline,photoby,width,height
            FROM webphoto
           WHERE article_id=$article_id
             AND isActive = 1";

  return queryDB($SQL);
}
function getArticle($id) {
  global $db;

  if(!$id) {
    trigger_error ("Error: No Article Specified", E_USER_ERROR);
  }

  $SQL = "SELECT article_id,headline,subhead,body,author_name,author_title,
                 body
            FROM content
           WHERE article_id=$id
           LIMIT 1";
 
  return queryDB($SQL);
}
/* END Get Functions */

function lookup_site($article_id) {
  global $db;
  
  if(!$article_id) {
    trigger_error ("Error: No Article Specified", E_USER_ERROR);
  }
  
  $SQL = "SELECT site_id
            FROM site_content
           WHERE content_id=$article_id";

  $results = queryDB($SQL);

  $sites = $results->fetchRow();
  return $sites->site_id;
}
function getSiteInfo($article) {
  global $db;

  if(!$article) {
    trigger_error ("Error: No Article Specified", E_USER_ERROR);
  }

  $SQL = "SELECT b.site_name, a.section_name,
                 date_format(a.publish_date,'%m/%d/%Y') as date
            FROM site_content a,
                 sites b
           WHERE content_id=$article
             AND a.site_id=b.site_id";

  return queryDB($SQL);
}
function getSections($site) {
  global $db;

  if(!$site) {
    trigger_error ("Error: No Site Specified", E_USER_ERROR);
  }

  $SQL = "SELECT DISTINCT(section_name)
            FROM site_content
           WHERE site_id=$site";

  return queryDB($SQL);
}

?>
