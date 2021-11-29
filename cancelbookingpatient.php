<html>
<head>
<title>Cancel Booking</title>
<link rel="stylesheet" href="assets/main.css">
<link rel="stylesheet" href="assets/bootstrap.css">
  <style>
    a:hover {
      color: #f1f1f1;
    }
    body {
      background: url('images/cancelback.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: verdana;
    }
    option {
      font-size: 1.1rem;
    }
  </style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
</head><?php include "dbconfig.php"; ?>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"><a class="navbar-brand" href="ulogin.php" class="logo"><img
        src="images/cal.png" width="30px" height="30px"><b> Skylabs </b>&nbspAppointment Booking System </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1"><a href="ulogin.php">Home</a></li>
      </ul>
    </div>
  </nav>
	<form action="cancelbookingpatient.php" method="post">
	<div class="sucontainer">
		<label style="font-size:2rem" >Select Appointment to Cancel:</label><br>
		<select name="appointment" id="appointment-list" class="demoInputBox"  style="width:100%;height:35px;border-radius:9px">
		<option value="">Select Appointment</option>
		<?php
		session_start();
		$username=$_SESSION['username'];
		$date= date('Y-m-d');
		$sql1="SELECT * from book where username='".$username."'and status not like 'Cancelled by Patient' and DOV >='$date'";
         $results=$conn->query($sql1); 
		while($rs=$results->fetch_assoc()) {
			$sql2="select * from doctor where did=".$rs["DID"];
			$results2=$conn->query($sql2);
				while($rs2=$results2->fetch_assoc()) {
					$sql3="select * from clinic where cid=".$rs["CID"];
					$results3=$conn->query($sql3);
		while($rs3=$results3->fetch_assoc()) {
			
		?>
		<option value="<?php echo $rs["Timestamp"]; ?>"><?php echo "Patient: ".$rs["Fname"]." Date: ".$rs["DOV"]." -Dr.".$rs2["name"]." -Clinic: ".$rs3["name"]." -Town: ".$rs3["town"]." - Booked on:".$rs["Timestamp"]; ?></option>
		<?php
		}
		}
		}
		?>
		</select>
		
    <br><br>
		<button type="submit" style="position:center" name="submit" value="Submit">Submit</button>
	</form>
	<?php
if(isset($_POST['submit']))
{
		$username=$_SESSION['username'];
		$timestamp=$_POST['appointment'];
		$updatequery="update book set Status='Cancelled by Patient' where username='$username' and timestamp= '$timestamp'";
				if (mysqli_query($conn, $updatequery)) 
				{
            echo "<script src=\"assets/modal.js\"></script>";
						$msg = "Appointment Cancelled successfully..!!<br>";
            echo "<script>MsgBox('".$msg."');</script>";
						header( "Refresh:2; url=ulogin.php");
				} 
				else
				{
            echo "<script src=\"assets/modal.js\"></script>";
					  $msg = "Error: " . $updatequery . "<br>" . mysqli_error($conn);
            echo "<script>MsgBox('".$msg."');</script>";
				}

}
?>
</body>
</html>