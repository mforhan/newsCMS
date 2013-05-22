<?
// print_r($_GET);

if($_GET) {
  $file = $_GET['file'];
  $width = $_GET['width'];
  $height = $_GET['height'];
}

$file = urldecode($file);
$path = explode("/",$file);
// trigger_error ("Path: ".sizeof($path)."[".$path[3]."]" , E_USER_ERROR);
// $checkFile = $path[(sizeof($path)-1)];
$checkFile = array_pop($path); // Last item is filename
$fullPath = implode("/",$path); // put path back together
$thumbPath = $fullPath."/thumb-$width/";

// if(file_exists($thumbPath.$checkFile)) {
if(file_exists($file)) {
 // File Exists, give that
  header("Content-type: image/jpeg") ;
  // $disp = imagecreatefromjpeg("$thumbPath$checkFile");
  $disp = imagecreatefromjpeg("$file");
  ImageJPEG($disp);
  ImageDestroy($disp);
  // trigger_error ("Loading Cached Thumb [$thumbPath$checkFile]" , E_USER_WARNING);
} else {
 if(!is_dir($thumbPath)) {
   mkdir($thumbPath);
 }
 resizeImg($file,$width,$height,$thumbPath.$checkFile);
 // File Doesn't exist - create thumbnail, save it for future  
 // trigger_error ("File does not exist ($thumbPath$checkFile)" , E_USER_ERROR);
}

function resizeImg($file,$width,$height,$thumb) {
  if(!is_file($file)) {
    return -1;
  }

  # [0] - width, [1] - height, [2] - type, [3] - attr (width/height html)
  # Types: 1 - GIF, 2 - JPG, 3 - PNG, 4 - SWF, 5 - PSD, 6 - BMP... 
  $data = getimagesize($file);
  $Hratio = $data[1]/$data[0];  // Height Ratio
  $Wratio = $data[0]/$data[1];  // Width Ratio

  if($data[0] > $data[1]) {
    // Landscape - Restrict Width
    $newWidth = $width;
    // $newHeight = round($data[1]*$Hratio);
    $newHeight = round($width*$Hratio);
  } else {
    // Portrait - Restrict Height
    $newHeight = $height;
    // $newWidth = round($data[0]*$Wratio);
    $newWidth = round($height*$Wratio);
  }

  $img = ImageCreateFromJPEG($file);
  $newImg = ImageCreateTrueColor($newWidth,$newHeight);
  ImageCopyResampled($newImg,$img,0,0,0,0,$newWidth,$newHeight,ImageSX($img),ImageSY($img));
  $fh = fopen($thumb,'w');
  fclose($fh);
  header("Content-type: image/jpeg") ;
  //  header("Content-Length: ".$ImageDataLength);
  ImageJPEG($newImg,$thumb,90); //,"newImg.jpg");  // Save Image
  ImageJPEG($newImg); // Display Image
  // return $newImg;
  ImageDestroy($img);
  ImageDestroy($newImg);
}
?>
