<html>

<head>
  <title>Change booking</title>
  <link rel="stylesheet" href="../assets/main.css">
  <link rel="stylesheet" href="../assets/bootstrap.css">
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
  <style>
    body {
      background: url("../images/mgrchange.jpg") repeat;

    }
    a:hover {
      color: #f1f1f1;
    }
    .mgrform {
      display: flex;
      margin: auto;
      width: 50%;
      flex-direction: column;
    }
    .formtable {
      display: flex;
      margin: auto;
      width: 100%;
      padding: 10px;
      flex-direction: column;
    }
    .formtable > div {
      margin: 10px;
      align-self: center;
    }
  </style>
</head>
<?php include "../dbconfig.php"; ?>
<style>
  table {
    width: 100%;
    border-collapse: collapse;
    border: 4px solid black;
    padding: 1px;
    font-size: 25px;
  }

  th {
    border: 1px solid black;
    background-color: #4CAF50;
    color: white;
    text-align: center;
  }

  tr,
  td {
    border: 1px solid black;
    background-color: white;
    color: black;
  }
</style>

<body>
  <form id="log-out-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="logout" value="pass">
  </form>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="mgrmenu.php" class="logo">
      Change/View Booking Status - 
      <?php session_start(); echo $_SESSION['mgrname']; ?>
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item animation1">
          <a href="#" onclick="document.forms['log-out-form'].submit(); return false;">Log Out</a>
        </li>
      </ul>
    </div>
  </nav>
  <?php
    if(isset($_POST['logout']))
    {
      session_unset();
      session_destroy();
      header( "Refresh:1; url=../index.php"); 
    }
  ?>

  <form class="mgrform" action="changebookingstatus.php" method="post">
      <label style="font-size:30px; margin-top: 15px"><b>Doctor:</b></label><br>
      <select name="doctor" id="doctor-list" class="demoInputBox" style="width:100%;height:55px;border-radius:9px">
        <option value="">Select Doctor</option>
        <?php
      		session_start();
		      $mid=$_SESSION['mgrid'];
		      $sql1="SELECT * FROM doctor where did in(select did from doctor_availability where cid in (select cid from manager_clinic where mid=$mid));";
          $results=$conn->query($sql1); 
		      while($rs=$results->fetch_assoc()) { 
		    ?>
        <option value="<?php echo $rs["did"]; ?>">
          <?php echo "Dr. ".$rs["name"]; ?>
        </option>
        <?php
		      }
		    ?>
      </select>
      <br>

      <label style="font-size: 30px"><b>Date:</b></label><br>
      <input type="date" name="dateselected" required><br><br>
      <br>
      <div>
        <button type="submit" style="position:center" name="submit" value="Submit">Submit</button>
      </div>
  </form>

  <?php
    if(isset($_POST['submit']))
    {
      include '../dbconfig.php';
      $did=$_POST['doctor'];
      $cid=1;
      $dateselected=$_POST['dateselected'];
      $sql1 = "select * from book where DOV='". $_POST['dateselected']."' AND DID= $did AND CID= $cid order by Timestamp ASC";
		  $results1=$conn->query($sql1); 
			require_once("dbconfig.php");

  ?>

  <form class="formtable" action="changebookingstatus.php" method="post">;
    <table>
      <tr>
        <th>UserName</th>
        <th>First Name</th>
        <th>Date</th>
        <th>Timestamp</th>
        <th>Status</th>
      </tr>
      <?php
        while($rs1=$results1->fetch_assoc())
        {
          echo "<tr>";
          echo '<td><input type="text" name="username[]" id="username" value="'.$rs1["Username"].'" readonly></td>'
              .'<td><input type="text" name="fname[]" id="fname" value="'.$rs1["Fname"].'" readonly></td>'
              .'<td><input type="date" name="dov[]" id="dov" value="'.$rs1["DOV"].'" readonly></td>'
              .'<td><input type="text" name="timestamp[]" id="timestamp" value="'.$rs1["Timestamp"].'" readonly></td>'
              .'<td><input type="text" name="status[]" id="status" value="'.$rs1["Status"].'"></td></tr>' ;
        }
      ?>
    </table>
    <div>
      <button type="submit" style="position:center" name="submit2" value="Submit">Submit Changes</button>
    </div>
  </form>

  <?php
    }
    require_once("../dbconfig.php");
		if(isset($_POST['submit2']))
		{
			$usrnm=$_POST["username"];
			$fnm=$_POST["fname"];
			$tmstmp=$_POST["timestamp"];
			$stts=$_POST["status"];
			$dt=$_POST["dov"];
			$n=count($usrnm);
			for($j=0;$j<$n;$j++)
			{	
				$updatequery="update book set Status='$stts[$j]' where username='$usrnm[$j]' and timestamp='$tmstmp[$j]'";
				if (mysqli_query($conn, $updatequery)) 
				{
          echo "<script src=\"../assets/modal.js\"></script>";
					$msg = "$fnm[$j] :Status updated successfully..!!<br>";
          echo "<script>MsgBox('".$msg."');</script>";
				} 
				else
				{
          echo "<script src=\"../assets/modal.js\"></script>";
					$msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
          echo "<script>MsgBox('".$msg."');</script>";
				}
			}
			echo "Redirecting.....";
			header( "Refresh:3; url=changebookingstatus.php");
		}
?>

</body>

</html>