<?php
function saveurl($i)
{

   $con=mysqli_connect("sql308.byethost11.com","b11_18001806","eshu@123","b11_18001806_stock");

   if (mysqli_connect_errno($con))
   {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
      $result = mysqli_query($con,"SELECT url FROM `b11_18001806_stock`.`url` where url='$i' ");
   $row = mysqli_fetch_array($result);
   $data = $row[0];

   if(!$data){
      
   $sql="INSERT INTO  `b11_18001806_stock`.`url` (`url` ) VALUES ( '$i')";

   if($result= mysqli_query($con,$sql) )
 {
    echo " ";
}
   }


   
echo "<br>";

  
}
?>
