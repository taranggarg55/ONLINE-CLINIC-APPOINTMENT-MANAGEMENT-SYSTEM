<!DOCTYPE html>
<html>

<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="assets/main.css">
  <link rel="stylesheet" href="assets/bootstrap.css">
  <style>
    a:hover {
      color: #f1f1f1;
    }
    .sucontainer {
      border-radius: 1.5%;
    }
    .sucontainer b {
      color: black;
    }
  </style>
</head>

<body style="background:url(images/signup.jpg) repeat">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" class="logo">
      <img src="images/cal.png" width="30px" height="30px">
      <b> Skylabs</b>
      &nbspAppointment Booking System
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1">
          <a href="index.php">Home</a>
        </li>
        <li class="nav-item animation1">
          <a href="locateus.php">Locate Us</a>
        </li>
      </ul>
    </div>
  </nav>

  <form action="signup.php" method="post">
    <div class="sucontainer">
      <label><b>Name:</b></label><br>
      <input type="text" placeholder="Enter Full Name" name="fname" required><br>

      <label><b>Date of Birth:</b></label><br>
      <input type="date" name="dob" required><br><br>

      <label><b>Gender</b></label><br>
      <input type="radio" name="gender" value="female">Female
      <input type="radio" name="gender" value="male">Male
      <input type="radio" name="gender" value="other">Other<br><br>

      <label><b>Contact No:</b></label><br>
      <input type="number" placeholder="Contact Number" name="contact" required><br>

      <label><b>Username:</b></label><br>
      <input type="text" placeholder="Create Username" name="username" required><br>

      <label><b>Email:</b></label><br>
      <input type="email" placeholder="Enter Email" name="email" required><br>

      <label><b>Password:</b></label><br>
      <input type="password" placeholder="Enter Password" name="pwd" id="p1" required><br>

      <label><b>Repeat Password:</b></label><br>
      <input type="password" placeholder="Repeat Password" name="pwdr" id="p2" required><br>
      <p style="color:white">By creating an account you agree to our <a href="#" style="color:blue">Terms &
          Conditions</a>.</p><br>

      <div class="container" style="background-color:grey">
        <button type="button" onclick="document.getElementById('id02').style.display='none'"
          class="cancelbtn">Cancel</button>
        <button type="submit" name="signup" style="float:right">Sign Up</button>
      </div>
    </div>
    
    
<?php
  function newUser()
  {
    include 'dbconfig.php';
    $name=$_POST['fname'];
    $gender=$_POST['gender'];
    $dob=$_POST['dob'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['pwd'];
    $prepeat=$_POST['pwdr'];
    $sql = "INSERT INTO Patient (Name, Gender, DOB,Contact,Email,Username,Password) VALUES ('$name','$gender','$dob','$contact','$email','$username','$password') ";

    if (mysqli_query($conn, $sql)) 
    {
      echo "<script src=\"assets/modal.js\"></script>";
      $msg = "Record created successfully!! Redirecting to login page....";
      echo "<script>MsgBox('".$msg."');</script>";
      header( "Refresh:3; url=index.php");
    } 
    else
    {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
  function checkusername()
  {
    include 'dbconfig.php';
    $usn=$_POST['username'];
    $sql= "SELECT * FROM Patient WHERE Username = '$usn'";

    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)!=0)
    {
      echo"<b><br>Username already exists!!";
    }
    else if($_POST['pwd']!=$_POST['pwdr'])
    {
      echo"Passwords dont match";
    }
    else if(isset($_POST['signup']))
    { 
      newUser();
    }

    
  }
  if(isset($_POST['signup']))
  {
    if(!empty($_POST['username']) && !empty($_POST['pwd']) &&!empty($_POST['fname']) &&!empty($_POST['dob'])&& !empty($_POST['gender']) &&!empty($_POST['email']) && !empty($_POST['contact']))
      checkusername();
  }
?>
  </form>
</body>

</html>