<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript">//alert("sdfsd");</script>
<body>
<?php
	require_once("dbconfig.php");
	$cid = $_POST["cid"];
	$query = "select * from manager_clinic join manager on manager.mid=manager_clinic.mid where cid=".$cid;
	$results=$conn->query($query); 
	echo "<option value=\"\">Select Manager</option>";
	while($rs=$results->fetch_assoc()) { 
	?>
	<option value="<?php echo $rs["mid"]; ?>"><?php echo "MID=(".$rs["mid"].") ".$rs["name"]; ?></option>
	<?php
	}
	?>
</body>
</html>