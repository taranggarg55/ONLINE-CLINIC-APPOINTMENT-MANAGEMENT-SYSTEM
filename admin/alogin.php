<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
	<link rel="stylesheet" href="../assets/bootstrap.css">
	<link rel="stylesheet" href="../assets/login.css">
  <style>
    a:hover {
      color: #f1f1f1;
    }
  </style>
<head>

<body style="background-color: #56baed; font-family: verdana;">
	<form action="alogin.php" method="post">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="../index.php" class="logo">
				<img src="../images/cal.png" width="30px" height="30px">
				<b> Skylabs</b>
				&nbspAppointment Booking System
			</a>
			<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item animation1">
						<a href="../index.php">Home</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="wrapper fadeInDown">
			<div id="formContent">
				<h2> ADMIN</h2>
				<!-- Icon -->
				<div class="fadeIn first">
					<img height="220" width="50" src="../images/user.png" id="icon" alt="User Icon">
				</div>
				<input type="text" id="login" class="fadeIn second" name="uname" placeholder="Enter Username" required>
				<input type="password" id="password" class="fadeIn third" name="pass" placeholder="Enter Password" required>
				<input type="submit" class="fadeIn fourth" name="submit" value="Log In">
			</div>
		</div>
</body>

</html>

<?php 
  function SignIn() 
  { 
    session_start();
    {  
      if($_POST['uname']=='admin' && $_POST['pass']=='admin') 
      { 
        $_SESSION['userName'] = 'admin'; 
        echo "<script src=\"../assets/modal.js\"></script>";
        echo "<script>MsgBox('Logging you in...');</script>";
        header( "Refresh:2; url=mainpage.php");
      } 
      else { 
        echo "<script src=\"../assets/modal.js\"></script>";
        echo "<script>MsgBox('Wrong Credentials');</script>";
      } 
    }
  } 
  if(isset($_POST['submit'])) 
  { 
    SignIn(); 
  } 
?>