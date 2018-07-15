<html>
<body>
<form method="post" enctype="multipart/form-data">
<input type="file" name="image"/>
<input type="submit" name="sumit" value="upload"/>
</form>
</body>
<?php
if(isset($_POST['sumit'])){
if(getimagesize($_FILES['image']['tmp_name'])==FAlSE)
{
	echo "please slect";
}
else{
	$image=addslashes($_FILES['image']['tmp_name']);
	$name=addslashes($_FILES['image']['name']);
	$image=file_get_contents($image);
	$image=base64_encode($image);
	saveimage($image);
}
}
function saveimage($image)
{
	$conn=mysqli_connect('localhost','root','','e-shop')or die("F***");
   // $qry="INSERT INTO products(Image)VALUES('$image')";
		$qry="UPDATE description_head set desc3_image='$image' WHERE Id='1'";
	//$result=mysqli_query($qry,$conn);
	if($res=mysqli_query($conn,$qry))
	{
		$qryq="select * from description_head";
		
		if($resq=mysqli_query($conn,$qryq)){
			echo "2";
			if(mysqli_num_rows($resq)>0)	{
				echo"asd";
		while($row=mysqli_fetch_array($resq)){
			echo '<img height:"300" width:"300" src="data:image;base64,'.$row['desc3_image'].' ">';
		}
		} 
	}
	}
	else{
		echo"****";
	}
}
?>
</html>