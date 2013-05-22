<? 
$site_pass = "ADMIN PASSWORD HERE";

$feedback = "";

function isLoggedin() {
  global $user_name,$id_hash,$feedback,$site_pass;

  if(!$user_name || !$id_hash) {
    $feedback .= "Not Logged In.";
    return FALSE;
  } 

  $verify = md5($user_name.$site_pass);
  
  if( $verify == $id_hash ) {
    $feedback .= "User is already logged in.";
    return TRUE;  
  } else {
    $feedback .= "You are no longer logged in.";
    return FALSE;
  }
}

function login($user,$pass,$group) {
  global $db,$feedback;
  $pass = md5($pass);
 
  $sql = "SELECT user_name, password
            FROM user
           WHERE user_name = :user
             AND password = :pass
             AND title != 'Web User'";

  $data = $db->prepare($sql);
  $data->execute(array('user' => $user, 'pass' => $pass));
  $results = $data->fetch(PDO::FETCH_OBJ);
  
  if($results->user_name) {
    registerUser($results->user_name);
    $feedback .= "SUCCESS! You've logged in";
    return TRUE;
  } else {
    $feedback .= "FAILURE! Invalid Username or Password";
    return FALSE;
  }
}

function registerUser($user) {
  global $site_pass;
 
  $hash = md5($user.$site_pass);

  session_register('user_name');
  session_register('id_hash');
  
  $_SESSION['user_name'] = $user;
  $_SESSION['id_hash'] = $hash;
  

}

function logout() {
  global $user_name,$id_hash;
  session_unregister('user_name');
  session_unregister('id_hash');
  return "Successfully Logged Out";
}
?>
