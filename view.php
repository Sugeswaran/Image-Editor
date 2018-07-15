<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>E-edit!</title> 
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js"></script>
</head>

<body>
<?php 
session_start();
$id=$_SESSION['Cd'];
$j=0;
$qwe=array();
$conn=mysqli_connect('localhost','root','','admin');
$sql="Select * from images where Pid='$id'";	
if($res1=mysqli_query($conn,$sql)){
	if(mysqli_num_rows($res1)>0){
		while($fetch=mysqli_fetch_assoc($res1)){
			$qwe[$j] ='<img height:"150" width:"50" class="part2-image" src="data:image;base64, '.$fetch['Image'].'">';
				$qwe1[$j] ='<img height:"150" width:"50"  src="data:image;base64, '.$fetch['Image'].'">';
				$j=$j+1;
		}
		//echo $qwe[0];
		$len_img=$j;
    }
    $k=0;
    echo "<div class=\"next_slide\">";
        echo " <span class=\"prev22\" onclick=\"Pslidechange1(-1)\">&#10094;</span>";
        echo " <span class=\"next22\" onclick=\"Pslidechange1(1)\">&#10095;</span>";
	for($k=0;$k<$len_img;$k++){
        echo "<div class=\"featured_slide\">";
        echo $qwe[$k];
        echo "</div>";       
    }
    echo "</div>";
}
else{
	echo "error";
}
?>
</body>
<script>

var pslide=document.getElementsByClassName("featured_slide");
var pslideindex=1;
var i;
pslideshow(pslideindex);
function Pslidechange1(n){
	pslideshow(pslideindex+=n);
}
function pslideshow(n){
  if(n>pslide.length){pslideindex=1;}
  if(n<=0){pslideindex=pslide.length;}
  for(i=0;i<pslide.length;i++)
	  pslide[i].style.display="none";
  pslide[pslideindex-1].style.display="block";
}
</script>

</html>