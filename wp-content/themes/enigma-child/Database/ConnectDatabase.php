<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Connect Database File</title>
</head>

<body>
<?php

	// Separated Config File to Connect Database , We can re-use this file by changing attribute of server,Username,Password and DatabaseName
	$Server = "localhost";
	$Username = "root";
	$Password = "";
	$DatabaseName = "rainbowdb";
	$conn = mysqli_connect($Server,$Username,$Password);
	if(!$conn)
	{
		die("Cannot Connect to MySQL");	
	}
	else
	{
		mysqli_select_db($conn,$DatabaseName) or die("Cannot choose Database: ".mysql_error($conn));
	}
?>
</body>
</html>