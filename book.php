<html>

<head>
  <title>Book</title>
  <link rel="stylesheet" href="assets/bootstrap.css">
  <link rel="stylesheet" href="assets/main.css">
  <style>
    a:hover {
      color: #f1f1f1;
    }

    .sucontainer {
      border-radius: 2%;
      color: white;
    }

    body {
      background: url('images/bookback.jpg') no-repeat center center fixed;
      background-size: cover;
    }
  </style>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>
<?php include "dbconfig.php";

    ?>
<script>function getTown(val) {
    $.ajax({

      type: "POST",
      url: "get_town.php",
      data: 'countryid=' + val,
      success: function (data) {
        $("#town-list").html(data);
      }
    }

    );
  }

  function getClinic(val) {
    $.ajax({

      type: "POST",
      url: "getclinic.php",
      data: 'townid=' + val,
      success: function (data) {
        $("#clinic-list").html(data);
      }
    }

    );
  }

  function getDoctorday(val) {
    $.ajax({

      type: "POST",
      url: "getdoctordaybooking.php",
      data: 'cid=' + val,
      success: function (data) {
        $("#doctor-list").html(data);
      }
    }

    );
  }

  function getDay(val) {
    var cidval = document.getElementById("clinic-list").value;
    var didval = document.getElementById("doctor-list").value;

    $.ajax({

      type: "POST",
      url: "getDay.php",
      data: 'date=' + val + '&cidval=' + cidval + '&didval=' + didval,
      success: function (data) {
        $("#datestatus").html(data);
      }
    }

    );
  }

</script>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"><a class="navbar-brand" href="ulogin.php" class="logo"><img
        src="images/cal.png" width="30px" height="30px"><b> Skylabs </b>&nbspAppointment Booking System </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1"><a href="ulogin.php">Home</a></li>
      </ul>
    </div>
  </nav>
  <form action="book.php" method="post">
    <div class="sucontainer" style="background:url(images/bookback.jpg)"><label><b>Name:</b></label><br><input
        type="text" placeholder="Enter Full name of patient" name="fname"
        required><br><label><b>Gender</b></label><br><input type="radio" name="gender" value="female">Female <input
        type="radio" name="gender" value="male">Male <input type="radio" name="gender" value="other">Other<br><br><label
        style="font-size:20px">City:</label><br><select name="city" id="city-list" class="demoInputBox"
        onChange="getTown(this.value);" style="width:100%;height:35px;border-radius:9px">
        <option value="">Select City</option>
        <?php $sql1="SELECT distinct(city) FROM clinic";
    $results=$conn->query($sql1);

    while($rs=$results->fetch_assoc()) {
      ?>
        <option value="<?php echo $rs["city"]; ?>">
          <?php echo $rs["city"];
      ?>
        </option>
        <?php
    }

    ?>
      </select><br><label style="font-size:20px">Town:</label><br><select id="town-list" name="Town"
        onChange="getClinic(this.value);" style="width:100%;height:35px;border-radius:9px">
        <option value="">Select Town</option>
      </select><br><label style="font-size:20px">Clinic:</label><br><select id="clinic-list" name="Clinic"
        onChange="getDoctorday(this.value);" style="width:100%;height:35px;border-radius:9px">
        <option value="">Select Clinic</option>
      </select><br><label style="font-size:20px">Doctor:</label><br><select id="doctor-list" name="Doctor"
        onChange="getDate(this.value);" style="width:100%;height:35px;border-radius:9px">
        <option value="">Select Doctor</option>
      </select><br><label><b>Date of Visit:</b></label><br><input type="date" name="dov" onChange="getDay(this.value);"
        min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d',strtotime('+7 day'));?>" required><br><br>
      <div id="datestatus"></div>
      <div class="container"><button type="submit" style="position:center" name="submit" value="Submit">Submit</button>
      </div>
      <?php session_start();

    if(isset($_POST['submit'])) {

      include 'dbconfig.php';
      $fname=$_POST['fname'];
      $gender=$_POST['gender'];
      $username=$_SESSION['username'];
      $cid=$_POST['Clinic'];
      $did=$_POST['Doctor'];
      $dov=$_POST['dov'];
      $status="Booking Registered.Wait for the update";
      $timestamp=date('Y-m-d H:i:s');
      $sql="INSERT INTO book (Username,Fname,Gender,CID,DID,DOV,Timestamp,Status) VALUES ('$username','$fname','$gender','$cid','$did','$dov','$timestamp','$status') ";

      if( !empty($_POST['fname'])&& !empty($_POST['gender'])&& !empty($_SESSION['username'])&& !empty($_POST['Clinic'])&& !empty($_POST['Doctor']) && !empty($_POST['dov'])) {
        $checkday=strtotime($dov);
        $compareday=date("l", $checkday);
        $flag=0;
        require_once("dbconfig.php");
        $query="SELECT * FROM doctor_availability WHERE DID = '".$did. "' AND CID='".$cid."'";
        $results=$conn->query($query);

        while($rs=$results->fetch_assoc()) {
          if($rs["day"]==$compareday) {
            $flag++;
            break;
          }
        }

        if($flag==0) {
          echo "<script src=\"assets/modal.js\"></script>";
          $msg = "<h2>Select another date as doctor is unavailable on ".$compareday."</h2>";
          echo "<script>MsgBox('".$msg."');</script>";
        }

        else {
          if (mysqli_query($conn, $sql)) {
            echo "<script src=\"assets/modal.js\"></script>";
            $msg = "<h2>Booking successful!! Redirecting to home page....</h2>";
            echo "<script>MsgBox('".$msg."');</script>";
            echo "<script>window.setTimeout(function(){window.location.href = 'ulogin.php'}, 3000);</script>";
            // header("Refresh:2; url=ulogin.php");
          }

          else {
            echo "<script src=\"assets/modal.js\"></script>";
            $msg = "Error: ". $sql . "<br>". mysqli_error($conn);
            echo "<script>MsgBox('".$msg."');</script>";
          }
        }
      }

      else {
        echo "<script src=\"assets/modal.js\"></script>";
        $msg = "Enter data properly!!!!";
        echo "<script>MsgBox('".$msg."');</script>";
      }
    }
    ?>
  </form>
</body>

</html>