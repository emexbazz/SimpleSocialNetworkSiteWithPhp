<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php
 require_once './include/header.php';
 echo <<<_END
 <script>
 function checkUser(user)
 {
 if (user.value == '')
 {
 O('info').innerHTML = ''
 return
 }
 params = "user=" + user.value
 request = new ajaxRequest()
 request.open("POST", "checkuser.php", true)
 request.setRequestHeader("Content-type",
 "application/x-www-form-urlencoded")
 request.setRequestHeader("Content-length", params.length)
 request.setRequestHeader("Connection", "close")
 request.onreadystatechange = function()
 {
 if (this.readyState == 4)
 if (this.status == 200)
 if (this.responseText != null)
 O('info').innerHTML = this.responseText
 }
 request.send(params)
 }
 function ajaxRequest()
 {
 try { var request = new XMLHttpRequest() }
 catch(e1) {
 try { request = new ActiveXObject("Msxml2.XMLHTTP") }
 catch(e2) {
 try { request = new ActiveXObject("Microsoft.XMLHTTP") }
 catch(e3) {
 request = false
 } } }
 return request
 }
 </script>
 <div class='main'><h3>Please enter your details to sign up</h3>
_END;
 $error = $user = $pass = "";
 if (isset($_SESSION['user'])) destroySession();
 if (isset($_POST['user']))
 {
 $user = sanitizeString($_POST['user']);
 $pass = sanitizeString($_POST['pass']);
 if ($user == "" || $pass == "")
 $error = "Not all fields were entered<br><br>";
 else
 {
 $result = queryMysql("SELECT * FROM member WHERE user='$user'");
 if ($result->num_rows)
 $error = "That username already exists<br><br>";
 else
 {
 queryMysql("INSERT INTO member VALUES('$user', '$pass')");
 die("<h4>Account created</h4>Please Log in.<br><br>");
 }
 }
 }

 echo <<<_END
 <form method='post' action='signup.php'>$error
 <span class='fieldname'>Username</span>
 <input type='text' maxlength='16' name='user' value='$user'
 onBlur='checkUser(this)'><span id='info'></span><br>
 <span class='fieldname'>Password</span>
 <input type='password' maxlength='16' name='pass'
 value='$pass'><br>
_END;
?>
 <span class='fieldname'>&nbsp;</span>
 <input type='submit' value='Sign up'>
 </form></div><br>
 </body>
</html>