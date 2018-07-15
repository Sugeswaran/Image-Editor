<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){ 
    session_start();
    $id= $_SESSION['Cd'];
    echo $id;
 // echo $_POST['cropped_image'];
 //   echo $_FILES['cropped_image']['tmp_name'];
 $image=addslashes($_FILES['cropped_image']['tmp_name']);
 $name=addslashes($_FILES['cropped_image']['name']);
 $image=file_get_contents($image);
 $image=base64_encode($image);
 saveimage($image);
}
function saveimage($image){
    $id=$_SESSION['Cd'];
    $conn=mysqli_connect('localhost','root','','admin')or die("F***");
    
     $qry="INSERT INTO images(Pid,Image)VALUES('$id','$image')";
        // $qry="UPDATE description_head set desc4_image='$image' WHERE Id='1'";
     //$result=mysqli_query($qry,$conn);
     if($res=mysqli_query($conn,$qry))
     {
         //header("location:dash.php");
    //      $qryq="select * from description_head";
         
    //      if($resq=mysqli_query($conn,$qryq)){
    //          if(mysqli_num_rows($resq)>0)	{
    //              echo"asd";
    //      while($row=mysqli_fetch_array($resq)){
    //          echo '<img height:"300" width:"300" src="data:image;base64,'.$row['desc3_image'].' ">';
    //      }
    //      } 
    //  }
     }
     else{
         echo"****";
     }
}    

?>