<!DOCTYPE html>
<html>
<head>
<title>Web Crawler in PHP</title>
</head>
<body>
<div id="content" style="margin-top:10px;height:100%;">
<center><h1>Web Crawler in PHP</h1></center>
<form action="finalcrawler.php" method="POST">
URL : <input name="url" size="35"  />
<input type="submit" name="submit" value="Start Crawling"/>
</form>
<br/>
<?
 include("simple_html_dom.php");
 include("saveurl.php");
 
 $crawled_urls=array();
 global $count;
 $count=0;
 function rel2abs($rel, $base)
 {
  if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
  if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;
  extract(parse_url($base));
  $path = preg_replace('#/[^/]*$#', '', $path);
  if ($rel[0] == '/') $path = '';
  $abs = "$host$path/$rel";
  $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
  for($n=1; $n>0;$abs=preg_replace($re,'/', $abs,-1,$n)){}
  $abs=str_replace("../","",$abs);
  return $scheme.'://'.$abs;
 }
 function perfect_url($u,$b)
 {
  $bp=parse_url($b);
  if(($bp['path']!="/" && $bp['path']!="") || $bp['path']=='') 
  {
   if($bp['scheme']=="")
   {
    $scheme="http";
   }
   else
   {
    $scheme=$bp['scheme'];
   }
   $b=$scheme."://".$bp['host']."/";
  }
  if(substr($u,0,2)=="//")
  {
   $u="http:".$u;
  }
  if(substr($u,0,4)!="http")
  {
   $u=rel2abs($u,$b);
  }
  return $u;
 }
 function crawl_site($u)
 {
  global $crawled_urls;
  $uen=urlencode($u);
  if((array_key_exists($uen,$crawled_urls)==0 || $crawled_urls[$uen] < date("YmdHis",strtotime('-25 seconds', time()))))
  {
   $html = file_get_html($u);
   $crawled_urls[$uen]=date("YmdHis");
   foreach($html->find("a") as $li)
   {
    $url=perfect_url($li->href,$u);
    $enurl=urlencode($url);
    if(strpos($url, $u)=="0"&&$url!='' && (strpos($url, 'html') != "false")&& substr($url,0,4)!="mail" && substr($url,0,4)!="java" && substr($url,-1)!="#"&& substr($url,-7)!="contact"&& substr($url,-5)!="about"&& substr($url,-7)!="sitemap"&& substr($url,-14)!="privacy-policy"&& substr($url,-9)!="advertise"&& substr($url,-6)!="submit"&& substr($url,0,24)!="https://www.facebook.com/"&&strpos($url, 'facebook') == false&&strpos($url1, 'twitter') == false&&strpos($url1, 'google') == false)
    {
     $count=$count+1;
     saveurl($url);  //replace this with function
     $uen=urlencode($url);
     if((array_key_exists($uen,$crawled_urls)==0 || $crawled_urls[$uen] < date("YmdHis",strtotime('-25 seconds', time()))))
     {
      $html = file_get_html($url);
      $crawled_urls[$uen]=date("YmdHis");
      foreach($html->find("a") as $li)
      {
       $url1=perfect_url($li->href,$url);
       $enurl=urlencode($url1);
       
       if(strpos($url1, $u)=="0"&& (strpos($url1, 'html') != "false")&&$url1!='' && substr($url1,0,4)!="mail" && substr($url1,0,4)!="java" && substr($url1,-1)!="#"&& substr($url1,-7)!="contact"&& substr($url1,-5)!="about"&& substr($url1,-7)!="sitemap"&& substr($url1,-14)!="privacy-policy"&& substr($url1,-9)!="advertise"&& substr($url1,-6)!="submit"&& substr($url1,0,24)!="https://www.facebook.com/"&&strpos($url1, 'facebook') == false&&strpos($url1, 'twitter') == false&&strpos($url1, 'google') == false) 
       {
        $count=$count+1;
        saveurl($url1);    //replace this also with function 
       }
      }
     }  
    }
   }
  }
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
   echo "done";
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
