<?php
  session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Cover</title>
  <link rel="stylesheet" href="assets/bootstrap.css">
  <link rel="stylesheet" href="assets/main.css">
  <style>
    a:hover {
      color: #f1f1f1;
    }
  </style>

</head>

<body style="background-image:url(images/clinic.jpg)">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" class="logo">
      <img src="images/cal.png" width="30px" height="30px">
      <b> Skylabs</b>
      &nbspAppointment Booking System
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1">
          <a href="#home">Home</a>
        </li>
        <li class="nav-item animation1">
          <a href="locateus.php">Locate Us</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="center">
    <br>
    <h1>Skylabs</h1>
    <p style="text-align:center;color:black;font-size:30px;top:35%">Online Appointment Booking System</p>
    <br>
    <button class="btn btn-dark btn-lg" onclick="document.getElementById('id01').style.display='block'"
      style="position:absolute;top:50%;left:44.5%;width: 150px;">Login</button>
  </div>
  <div class="footer">
    <ul style="position:absolute;top:93%;background-color:black">
      <li class="animation1">
        <a href="admin/alogin.php">Admin Login</a>
      </li>
      <li class="animation1">
        <a href="admin/mlogin.php">Manager Login</a>
      </li>
    </ul>
  </div>
  <div id="id01" class="modal">
    <form class="modal-content animate" method="post" action="index.php">
      <div style="display: flex;" class="imgcontainer">
        <span style="flex: 1;padding-left: 15px;">
          <h2 class="text-center">Log In</h2>
        </span>
        <span style="font-size: 30px;padding-right: 8px;cursor: pointer;" class="d-flex align-items-start text-danger"
          onclick="document.getElementById('id01').style.display='none'" class="close"
          title="Close Modal">&times;</span>
      </div>
      <div class="container">
        <!-- <label><b>Username</b></label> -->
        <input style="border-radius: 10px;" type="text" placeholder="Enter Username" name="uname" required>
        <!-- <label><b>Password</b></label> -->
        <input style="border-radius: 10px;" type="password" placeholder="Enter Password" name="psw" required>
        <br>
        <br>
        <div class="d-flex flex-column">
          <button class="btn btn-dark " type="submit" name="login">Login</button>
          <!-- Remember me cookie -->
          <!-- <div class="d-flex flex-row align-items-center" style="margin: auto;width: 32%">
            <input type="checkbox" checked="checked">
            <span>Remember me</span>
          </div> -->
        </div>
      </div>
      <div class="container" style="background-color:#f1f1f1">
        <button class="btn btn-danger" type="button" onclick="document.getElementById('id01').style.display='none'"
          class="cancelbtn">Cancel</button>
        <button class="btn btn-dark"
          onclick="document.getElementById('id02').style.display='block';document.getElementById('id01').style.display='none'"
          style="float:right">Don't have one?</button>
      </div>
    </form>
  </div>
  <div id="id02" class="modal">
    <form class="modal-content animate" action="signup.php" method="get">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id02').style.display='none'" class="close"
          title="Close Modal">&times;</span>
        <br>
      </div>
      <div class="imgcontainer">
        <img src="images/steps.png" alt="Avatar" class="avatar">
      </div>
      <div class="container">
        <p style="text-align:center;font-size:18px;">
          <b>Sign Up -> Choose your Dates -> Book your visit</b>
        </p>
        <p style="text-align:center">
          <b>Booking an appointment has never been easier!</b>
        </p>
        <p style="text-align:center">
          <b>The 3 steps for an easier and healthy life</b>
        </p>
      </div>
      <div class="container" style="background-color:#f1f1f1">
        <button class="btn btn-danger" type="button" onclick="document.getElementById('id02').style.display='none'"
          class="cancelbtn">Cancel</button>
        <button class="btn btn-dark" type="submit" name="signup" style="float:right">Sign Up</button>
      </div>
    </form>
  </div>
</body>

</html>

<?php
  $error=''; 
  if (isset($_POST['login'])) {
      if (empty($_POST['uname']) || empty($_POST['psw'])) {
      $error = "Username or Password is invalid";
      }
      else
      {
      include 'dbconfig.php';
      $username=$_POST['uname'];
      $password=$_POST['psw'];

      $query = mysqli_query($conn,"select * from patient where password='$password' AND username='$username'");
      $rows = mysqli_fetch_assoc($query);
      $num=mysqli_num_rows($query);
      if ($num == 1) {
          $_SESSION['username']=$rows['username'];
          $_SESSION['user']=$rows['name'];
          echo "<script>window.setTimeout(function(){window.location.href = 'ulogin.php'}, 1000);</script>";
      } 
      else 
      {
          echo "<script src=\"assets/modal.js\"></script>";
          $msg = "Username or Password is invalid";
          echo "<script>MsgBox('".$msg."');</script>";
      }
      mysqli_close($conn); 
      }
  }
?>