<?php
include("application.inc.php");
exit()
// include('admin/application.php.inc');

$daysago = 0*60*60*24;
$today = date('m-d-Y',time()-$daysago);

print "<h2>Start</h2>";
$outputdir = "/home/vhosts/cashmerevalleyrecord.com/httpdocs/photos/processed/$today";
$outputbase = $outputdir;
$count = 1;
$processed = "";
while(is_dir($outputdir)) {
  $outputdir =  $outputbase."_".$count;
  $count++;
}
if(!is_dir("$outputdir")) {
  mkdir($outputdir);
}
$dir = "inbox";
if (is_dir($dir)) {
  if( $dh = opendir($dir)) {
    print "processing [$dir]<br/>";
    while(($file = readdir($dh)) !== false) {
      if(is_file("$dir/$file")) {
        list($newfile,$ext) = explode(".",$file);
        $thumb_path = "$outputdir/$newfile"."_thmb.$ext";
        if(is_file($thumb_path)) {
          // we have this photo, lets skip to the next one.
        } else {
          # [0] - width, [1] - height
          $img = resizeImg("$dir/$file",125,'',0);
          if(ImageJPEG($img,$thumb_path)) {
            // print $thumb_path."<br/>";
            if(!is_file("$outputdir/$file")) {
              rename("$dir/$file","$outputdir/$file");
            }
            $data = getimagesize("$thumb_path");
            $size = filesize($thumb_path);
            if(!$size) {
              $size = NULL;
            }   
            //regImage($thumb_path,"$outputdir/$file",$data[0],$data[1],$size,'');
            echo "Register Image<br/>\n";
            $processed .= "<br/>$outputdir/$file";
          }
          ImageDestroy($img);
        }
      } 
    }
    closedir($dh);
  }
}
print "<h4>end</h4>";
print "Processed:<br/>$processed";
  
function resizeImg($file,$width,$height,$fixed) {
  //print "Resizing...[($file),($width),($height),($fixed)]...<br/>";
  # Verify that we recieved a file
  // $fullfile = '/home/httpd/vhosts/studioufo.com/httpdocs/mae_dev/'.$file;
  // if(!is_file($fullfile)) {
  if(!is_file($file)) {
    return -1;
  }
  # We need at least the width to work from
  if(!$width) {
    return -2;
  }
  # [0] - width, [1] - height, [2] - type, [3] - attr (width/height html)
  # Types: 1 - GIF, 2 - JPG, 3 - PNG, 4 - SWF, 5 - PSD, 6 - BMP... 
  $data = getimagesize($file);
  if($data[2] == 1 || $data[2] == 2 || $data[2] == 3) {
    #the image ratio is height/width
    $ratio = $data[1]/$data[0];
    $newHeight = round($width*$ratio);
    if($height) {
      if($fixed) {
        $newHeight = $height;
      } else {
        # if the height is within 10% of the new height, lets use the
        # specified height (as long as fixed wasn't specified)
        if($newHeight >= $height*0.9 && $newHeight <= $height*1.1) {
          $newHeight = $height;
        }
      }
    }
  } else { 
    return -3;
  }
  // print "Got new dimensions ($width) ($newHeight)...<br/>";
  # now that we've actually gotten the width,newHeight and verified
  # that we have a file and that its a supported image, we can proceed
  # to resize the image
  $img = ImageCreateFromJPEG($file);
  $newImg = ImageCreateTrueColor($width,$newHeight);
  ImageCopyResampled($newImg,$img,0,0,0,0,$width,$newHeight,ImageSX($img),ImageSY($img));
  // ImageJPEG($newImg,"newImg.jpg"); 
  return $newImg;
}
function regImage($thumb_path,$path,$width,$height,$size,$comment) {
  global $db;

  $sql = "INSERT into image
          (thumb_path,path,width,height,size,comment)
          values
          ('$thumb_path','$path',$width,$height,$size,'$comment')";
 
  // db_insert($db_conn,$sql);
  //$result = db_insert($db_conn,$sql);
  $result = $db->query($sql);
  //$results = $data->fetchRow();

  // if( $result ) {
  //   echo "Database successfully updated";
  // } 
  // $db->query($sql);
  // $results = $data->fetchRow();
}
?>
