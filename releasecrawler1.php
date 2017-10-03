<!DOCTYPE html>
<html>
<head>
<title>Web Crawler in PHP</title>
</head>
<body>
<div id="content" style="margin-top:10px;height:100%;">
<center><h1>Web Crawler in PHP</h1></center>
<form action="releasecrawler1.php" method="POST">
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

     $count=$count+1;
     saveurl($url);
$uen1=urlencode($url);
  if((array_key_exists($uen1,$crawled_urls)==0 || $crawled_urls[$uen1] < date("YmdHis",strtotime('-25 seconds', time()))))
  {
   $html = file_get_html($url);
   $crawled_urls[$uen1]=date("YmdHis");
   foreach($html->find("a") as $li)
   {
    $url2=perfect_url($li->href,$u);

     $count=$count+1;
     saveurl($url2);

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