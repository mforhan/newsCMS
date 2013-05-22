<? 
include('application.inc.php');

if($_POST['submit']) {
  unset($user);
  unset($pass);
  $user = $_POST['user'];
  $pass = $_POST['pass'];
//  if( login($user,$pass,'') ) {
//    Header('Location: article.php');
//  }
}
?>
<html>
<head>
<title>
Login Page
</title>
<style type="text/css">
body {
  /* font:10pt Verdana #404040; */
  background-color:#8495c0;
  /* background-color:white; */
  /* color:#404040; */
  font:9pt Times;
  color:black;
}
table {
  border:1px solid black;
  padding:10px;
  margin-top:25%;
  /* background-color:#737373; */
  background-color:#9b8aa5;
}
table th {
  /* background-color:#8da829; */
  background-color:#4f5973; 
  /* background-color:#e8eba5; /* Wheat */
  /* color:#bfbfbf; */
  color:#dddddd;
  text-align:center;
}
</style>
</head>
<body bgcolor="#8495c0">
<? if( $feedback ) {
echo "<h3>$feedback</h3>";
}
?>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<center>
<table rows="3" cols="2">
<tr>
 <th colspan="2">Prairie Media CMS Login</th>
</tr>
<tr>
<td>Username:</td>
     <td><input type="text" size=16 name="user"></td>
    </tr>
    <tr>
     <td>Password:</td>
     <td><input type="password" size=16 name="pass"></td>
    </tr>
    <tr>
      <td colspan="2" align=center><input type="submit" name=submit value="Login"></td>
    </tr>
    <tr>
      <td colspan=2 style="font-size:0.5em;color:#aaa;">Unauthorized access prohibited.<br/>All Connection attempts are logged.</td>
    </tr>
   </table>
  </center>
  </form>
 </body>
</html>
