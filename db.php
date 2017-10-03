<html>
<head>

</head>
<body>
<center>
<?php
include 'sql.php';
  function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
    $ip= get_client_ip();

   $con=mysqli_connect("sql308.byethost11.com","b11_18001806","eshu@123","b11_18001806_stock");

   if (mysqli_connect_errno($con)) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   	
  
   $result1 = mysqli_query($con,"SELECT count(*) FROM fact ");
   $row1 = mysqli_fetch_array($result1);
   $max = $row1[0];


  $result2 = mysqli_query($con,"SELECT id FROM fact");
   $row2 = mysqli_fetch_array($result2);
   $min = $row2[0];

   $max=$max+$min;


 
   $no=rand($max,$min);


$check=check($ip,$no);
if($check=='1')
{


 goto l;

}
else
{
header("http://stockmanager.byethost11.com/app/db.php");

}
l:
$result5 = mysqli_query($con,"INSERT INTO ip(ip,fact) VALUES('$ip','$no')") ;
if($result5)
{
Goto b;
}
else 
goto x;

b:
   $result = mysqli_query($con,"SELECT fact,img FROM fact  WHERE id= '$no' ");
   $row = mysqli_fetch_array($result);
   $data = $row[0];
   $data2=$row[1];

   if($data){
      echo $data;
      echo "<br>";
      echo "<img  width=250 height=250 src=".$data2.">";
      echo "<br>";
}
      x:

   mysqli_close($con);
  echo "<br /><center><input type='submit' name='submitAdd' value='next' onclick='window.location.reload(true);'></center>";
?>
</center>
</body>
</html>
