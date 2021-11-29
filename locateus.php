<!DOCTYPE html>
<html>

<head>
  <title>Locate Us</title>
  <link rel="stylesheet" href="assets/locateus.css">
  <link rel="stylesheet" href="assets/main.css">
  <link rel="stylesheet" href="assets/bootstrap.css">
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
  <style>
    a:hover {
      color: #f1f1f1;
    }
    .sucontainer ul {
      background-color: grey;
    }
    .sucontainer {
      border-radius: 2%;
    }
	  body {
		  background: url('../images/doctordesk.jpg') no-repeat center center fixed; 
      font-family: verdana;
	  }
  </style>
</head>

<?php include "dbconfig.php"; ?>
<script>
  function getTown(val) {
    $.ajax({
      type: "POST",
      url: "get_town.php",
      data: 'countryid=' + val,
      success: function (data) {
        $("#town-list").html(data);
      }
    });
  }
  function getClinic(val) {
    $.ajax({
      type: "POST",
      url: "getclinic.php",
      data: 'townid=' + val,
      success: function (data) {
        $("#clinic-list").html(data);
      }
    });
  }
  function getDoctorday(val) {
    $.ajax({
      type: "POST",
      url: "getdoctordaybooking.php",
      data: 'cid=' + val,
      success: function (data) {
        $("#doctor-list").html(data);
      }
    });
  }
</script>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php" class="logo">
      <img src="images/cal.png" width="30px" height="30px">
      <b> Skylabs</b>
      &nbspAppointment Booking System
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1">
          <a href="index.php">Home</a>
        </li>
      </ul>
    </div>
  </nav>

  <form action="locateus.php" method="post">
    <div class="sucontainer" style="background-image:url(images/yellowpage.jpg)">
      <ul style="background-image:url(images/yellowpage.jpg)">
        <label><b>Search Doctor</b></label>
        <input type="text" name="doctorname" placeholder="Enter Doctor Name"></input>
        <button type="submit" style="position:center" name="subd" value="Submit">Submit</button>
      </ul>
      <label style="font-size:20px">City:</label><br>
      <select name="city" id="city-list" class="demoInputBox" onChange="getTown(this.value);"
        style="width:100%;height:35px;border-radius:9px">
        <option value="">Select City</option>
        <?php
		      $sql1='SELECT distinct(city) FROM clinic';
          $results=$conn->query($sql1); 
		      while($rs=$results->fetch_assoc()) { 
		    ?>

        <?php
          echo '<option value="'.$rs['city'].'">';
          echo $rs['city'];
          echo '</option>';
        ?>

        <?php
		    }
		    ?>
      </select>
      <br>

      <label style="font-size:20px">Town:</label><br>
      <select id="town-list" name="Town" onChange="getClinic(this.value);"
        style="width:100%;height:35px;border-radius:9px">
        <option value="">Select Town</option>
      </select><br>

      <label style="font-size:20px">Clinic:</label><br>
      <select id="clinic-list" name="Clinic" onChange="getDoctorday(this.value);"
        style="width:100%;height:35px;border-radius:9px">
        <option value="">Select Clinic</option>
      </select><br>
      <div class="container">
        <button type="submit" style="position:center" name="submit" value="Submit">Submit</button>
      </div>
  </form>

</body>

</html>

<?php
  session_start();
  if(isset($_POST['subd']))
  {
    include 'dbconfig.php';
    if(!empty($_POST['doctorname']))
    {
      $doctor=$_POST['doctorname'];
      $sql1 = "Select * from Doctor where UPPER(name) like UPPER('%".$doctor."%')";
      $result1=mysqli_query($conn, $sql1);  
      while($row1 = mysqli_fetch_array($result1))
      {
        echo "<hr>";
        echo "<script src=\"assets/modal.js\"></script>";
        $msg = "Doctor Name: ".$row1['name']."<br>Gender: ".$row1['gender']."<br>Specialization: ".$row1['specialization'];
        echo "<script>MsgBox('".$msg."');</script>";
        $sql2="select * from doctor_availability where did=".$row1["did"];
        //$sql2 = "Select name,address,contact from clinic where cid in (select cid from doctor_availability where did in(Select did from doctor where did=".$row1['did']."));";
        $result2=mysqli_query($conn, $sql2);  
        echo "<h4 style=\"color: white\">Available slots: </h4>";
        while($row2 = mysqli_fetch_array($result2))
        {
          //echo "<br>Clinic Name:".$row2['name']."</br><br><b>Address:<b>".$row2['address']."<br><b>Contact:<b>".$row2['contact'];
          echo "<label><br><b>Day:".$row2["day"]."</b><br><b>Timings:<b>".$row2["starttime"]." to ".$row2["endtime"]."</label>";
          $sql3="Select * from clinic where cid = ".$row2["cid"];
          $result3 = mysqli_query($conn , $sql3);
          while($row3 = mysqli_fetch_array($result3))
          {
            echo"<label><br><b>Clinic Name:".$row3["name"]." Town:".$row3["town"]." City:".$row3["city"]."</label>";
          }
        }
      }
    }
    else
    {
      $msg = "Enter a valid name.";
      echo "<script src=\"assets/modal.js\"></script>";
      echo "<script>MsgBox('".$msg."');</script>";
    }
  }

  if(isset($_POST['submit']))
  {
    include 'dbconfig.php';
    $cid=$_POST['Clinic'];
    $sql1 = "Select * from Clinic where cid=$cid";
    $result1=mysqli_query($conn, $sql1);  
    $row1 = mysqli_fetch_array($result1);
    $sql2 = "Select name,gender,specialization,contact from doctor where did in (select did from doctor_availability where cid=$cid);";
    $result2=mysqli_query($conn, $sql2);  
    $row2 = mysqli_fetch_array($result2);
    echo "<script src=\"assets/modal.js\"></script>";
    $msg = "Clinic Name: ".$row1['name']."<br>Address: ".$row1['address']."<br>Contact: ".$row1['contact']."<br>Doctor Name: ".$row2['name']."<br>Specialization: ".$row2['specialization']."<br>Doctor Contact: ".$row2['contact'];
    echo "<script>MsgBox('".$msg."');</script>";
  }

  echo "<script>document.body.style.backgroundImage = \"url('images/yellowpage.jpg')\"</script>";
  echo "<script>document.body.style.backgroundRepeat = \"repeat-y\"</script>";
  echo "<script>document.body.style.backgroundColor = \"\"</script>";
?>