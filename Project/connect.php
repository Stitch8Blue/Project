<?php
	ini_set('display_errors', 1);
	error_reporting(~0);

   $serverName = "localhost";
   $userName = "root";
   $userPassword = "admin1234";
   $dbName = "ecommerce";
  
	$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

	if (mysqli_connect_errno())
	{
		echo "Database Connect Failed : " . mysqli_connect_error();
	}
	else
	{
		//echo "Database Connected.";
	}

    $conn->query("set names utf8");
?>
