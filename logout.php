<?
  include('application.inc.php');
?>
<html>
 <head>
  <title>Logout</title>
  <script type="text/javascript">
window.onload = function() {
  // logout.style.top = document.body.clientHeight/2-50;
  // logout.style.left = document.body.clientWidth/2-100;
}
  </script>
<style type="text/css">
body {
  /* font:10pt Verdana #404040; */
  background-color:#8495c0;
  /* color:#404040; */
  font:9pt Times;
  color:black;
}
#logout {
  border:1px solid black;
  padding:10px;
  margin-top:25%;
  background-color:#737373;
  color:#bfbfbf;
  width:200px;
  height:50px;
  margin-left:35%;
  font:12pt georgia;
}
table th {
  background-color:#4f5973;
  color:#bfbfbf;
  text-align:center;
}
</style>
 </head>
 <body bgcolor="#333377">
  <div id="logout"> <!-- style="background-color:#d0d0d0;width:200px;height:50px;border:1px solid black;padding:10px;position:absolute;">-->
   Logging out...
  <? logout(); ?>
  </div>
  <script>
   setTimeout("this.location='login.php'",2000);
  </script>
 </body>
</html>
