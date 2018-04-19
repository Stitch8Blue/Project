<?php
	session_start();
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}

	if($_SESSION['Status'] != "ADMIN")
	{
		echo "This page for Admin only!";
		exit();
	}
	
	include("connect.php");
	
	$sql = "SELECT * FROM member WHERE mem_user = '".$_SESSION['UserID']."' ";
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
?>
<html>
<head>
<title>Admin Page</title>
</head>
<body>
  Welcome to Admin Page! <br>
  <table border="1" style="width: 300px">
    <tbody>
      <tr>
        <td width="87"> &nbsp;Username</td>
        <td width="197"><?php echo $row["mem_user"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Name</td>
        <td><?php echo $row["mem_name"];?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <a href="edit_profile.php">Edit</a><br>
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>