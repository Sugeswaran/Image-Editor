<html>
<head>
<title>E-shop</title>
</head>
<body>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
$user=$_POST['mail'];	
$pswrd=$_POST['password'];
$conn=mysqli_connect('localhost','root','','admin')or die("UNABLE TO CONNECT");
$sql="SELECT * FROM users where mail_id='$user'";
if($res=mysqli_query($conn,$sql)){
	if(mysqli_num_rows($res)){
		while($fetch=mysqli_fetch_assoc($res)){
			$passwrd=$fetch['password'];
			$username=$fetch['Username'];	
			$cd=$fetch['Id'];			
		}
	}
if($pswrd==$passwrd){
	session_start();
	$_SESSION['Username']=$username;
	$_SESSION['Cd']=$cd;
	header("location:dash.php");
}
		
	else{
		header("location:index.html");
}
}
else{
	header("location:index.html");
}
}
	
	else{
		echo"a";
	}
?>
</body>
</html>