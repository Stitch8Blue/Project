<?php
	session_start();
	
	include("connect.php");
	
	$userSear = $_POST['txtUsername'];
	$passSear = $_POST['txtPassword'];
	
	$sql = "select * from member where mem_user = '".$userSear."' and mem_pass = '".$passSear."'";
	//$sql = "select * from member where mem_user = 'admin' and mem_pass = '1234'";
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);

	if(!$row)
	{
			echo "Username and Password Incorrect!";
	}
	else
	{
			$_SESSION["UserID"] = $row["mem_user"];
			$_SESSION["Status"] = $row["mem_status"];

			session_write_close();
			
			if($row["mem_status"] == "ADMIN")
			{
				header("location:admin_page.php");
			}
			else
			{
				header("location:user_page.php");
			}
	}

	mysqli_close($conn);
	
?>