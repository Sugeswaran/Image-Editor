<html>
<head>
<title>Signup</title>
</head>
<body>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	
	$mailid=$_POST["mailid"];
	if(!empty($_POST["mailid"]))
	{
		$mailid=$_POST["mailid"];
	}
	$password=$_POST["password"];
	if(!empty($_POST["password"]))	
	{
		$password=$_POST["password"];
	}
	$uname=$_POST["uname"];
	
	if(!empty($_POST["uname"]))
	{
		$uname=$_POST["uname"];
	}
$Email_id=$_POST['mailid'];
$Password=$_POST['password'];
$Username=$_POST['uname'];
$conn=mysqli_connect('localhost','root','','admin');
$sql="SELECT mail_id FROM users WHERE mail_id='$Email_id'";

$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{

	while($row=mysqli_fetch_assoc($result))
	{
	echo "ALREADY EXISTS";
	}
}
else{
	echo "123";
	$v="INSERT INTO users(mail_id,Password,Username) VALUES('$Email_id','$Password','$Username')";
	if(mysqli_query($conn,$v))
	{
        session_start();
        $_SESSION['Username']=$username;
        $_SESSION['Cd']=$cd;
        header("location:dash.php");
 }
	else{
	echo "noo";
	}
}
mysqli_close($conn);
}
?>