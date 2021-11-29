<html>

<head>
  <title>User Login</title>
  <link rel="stylesheet" href="assets/main.css">
  <link rel="stylesheet" href="assets/bootstrap.css">
  <style>
    a:hover {
      color: #f1f1f1;
    }
    table {
      width: 95%;
      border-collapse: collapse;
      border: 4px solid black;
      padding: 5px;
      font-size: 25px;
    }

    th {
      border: 4px solid black;
      background-color: #4CAF50;
      color: white;
      text-align: center;
    }

    tr,
    td {
      border: 4px solid black;
      background-color: white;
      color: black;
    }
  </style>
</head>

<body style="background:url(images/cancelback.jpg) repeat; font-family: verdana">
  <form id="log-out-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="logout" value="pass">
  </form>
  <form id="cancel-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="cancel" value="pass">
  </form>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" class="logo">
      <img src="images/cal.png" width="30px" height="30px">
      <b> Skylabs</b>
      &nbspAppointment Booking System
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1">
          <a href="book.php">Book Appointment</a>
        </li>
        <li class="nav-item animation1">
          <a href="#" onclick="document.forms['cancel-form'].submit(); return false;">Cancel Booking</a>
        </li>
        <li class="nav-item animation1">
          <a href="ulocateus.php">Locate Us</a>
        </li>
        <li class="nav-item animation1">
          <a href="#" onclick="document.forms['log-out-form'].submit(); return false;">Log Out</a>
        </li>
      </ul>
    </div>
  </nav>

  <center>
  <h2 style="color: white; margin: 2rem;">My Appointments</h2>
  </center>
  <?php include "dbconfig.php"; ?>

  <center>
    <?php
    session_start();
	$username=$_SESSION['username'];
	$sql1 = "Select * from book where username ='".$username."' order by DOV desc";
			$result1=mysqli_query($conn, $sql1);  
			echo "<table>
					<tr>
					<th>Appointment-Date</th>
					<th>Name</th>
					<th>Clinic</th>
					<th>Doctor</th>
					<th>Status</th>
					<th>Booked-On</th>
					</tr>";
			while($row1 = mysqli_fetch_array($result1))
			{
				$sql2="SELECT * from doctor where did=".$row1['DID'];
				$result2= mysqli_query($conn,$sql2);
				while($row2= mysqli_fetch_array($result2))
				{
					$sql3="SELECT * from clinic where CID=".$row1['CID'];
						$result3= mysqli_query($conn,$sql3);
						while($row3= mysqli_fetch_array($result3))
						{
								echo "<tr>";
								echo "<td>" . $row1['DOV'] . "</td>";
								echo "<td>" . $row1['Fname'] . "</td>";
								echo "<td>" . $row3['name']."-".$row3['town'] . "</td>";
								echo "<td>" . $row2['name'] . "</td>";
								echo "<td>" . $row1['Status'] . "</td>";
								echo "<td>" . $row1['Timestamp'] . "</td>";
								echo "</tr>";
						}
				}
				
			}
	?>
  </center>

  <?php
if(isset($_POST['check']))
{
		include 'dbconfig.php';
		$name=$_SESSION['user'];
		$sql = "Select * from book where name='$name'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($rows = mysqli_fetch_assoc($result)) 
			{
				echo "Username:".$rows["username"]."Name:".$rows["name"]."Date of Visit:".$rows["dov"]."Town:".$rows["town"]."<br>";
			}
		} 
		else 
		{
			echo "0 results";
		}
}
if(isset($_POST['cancel']))
{
	header( "Refresh:1; url=cancelbookingpatient.php"); 
}
if(isset($_POST['logout']))
{
	session_unset();
	session_destroy();
	header( "Refresh:1; url=index.php"); 
}
?>
</body>

</html>