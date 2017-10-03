<!DOCTYPE html>
<html>
<head>
 <title>Web Crawler in PHP</title>
</head>
<body>
 <div id="content" style="margin-top:10px;height:100%;">
 <center><h1>Web Crawler in PHP</h1></center>
 <form action="final.php" method="POST">
   URL : <input name="url" size="35" />
   <input type="submit" name="submit" value="Start Crawling"/>
 </form>
 <?
   include("simple_html_dom.php");
    function crawl_site($u)
   {     
     echo "function called";
     $html= file_get_html($u);
     foreach($html->find('.post-content') as $article) 
     {
       foreach($article->find('li') as $li) 
       {
         $es = $li->plaintext;
         echo "<h1><center>";
         echo $es;
         echo "</center></h1>";
         echo '<br>';
         image($es);
       }
     }
   }

   function image($est)
   {
     $count=0;
     $rl=seoUrl($est);
     $u="https://www.google.com/search?tbm=isch&q=";
     $urli=$u.$rl;
     $htm = file_get_html($urli);
     echo '<br>';
     foreach($htm->find('img') as $li)
     {
       if($count==0)
       {
         $urld=$li->src;
         echo "<center><br><img  src='".$urld."'><br></center>";
         $count=1;
       }
     }
   }      

   function seoUrl($string) 
   {
     $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
     $string = preg_replace("/[\s-]+/", " ", $string);
     $string = preg_replace("/[\s_]/", "+", $string);
     return $string;
   }

   if(isset($_POST['submit']))
   {
    $url=$_POST['url'];
    if($url=='')
    {
     echo "<h2>A valid URL please.</h2>";
    }
    else
    {
     crawl_site($url);
    }
   }
   ?>
</div>
<style>
input
{
 border:none;
 padding:8px;
}
</style>
</body>
</html>
