<?php
function save($i,$a)
{
   $con=mysqli_connect("sql308.byethost11.com","b11_18001806","eshu@123","b11_18001806_stock");

   if (mysqli_connect_errno($con))
   {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
      $result = mysqli_query($con,"SELECT fact FROM `b11_18001806_stock`.`fact` where fact='$i' ");
   $row = mysqli_fetch_array($result);
   $data = $row[0];

   if(!$data){
      
   $sql="INSERT INTO  `b11_18001806_stock`.`fact` (`fact` ,`img`) VALUES ( '$i',  '$a')";
   $result = mysqli_query($con,$sql) ;
   echo "inputed";
   }

   
echo "<br>";


  
}
?>
