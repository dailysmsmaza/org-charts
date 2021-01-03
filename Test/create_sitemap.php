<?php
	
	include("connect.php");
	include("names.php");
	
	unlink("sitemap.xml");
	
	$file_nm = fopen("../sitemap.xml","w");
	
	$xmltag = '<?xml version="1.0" encoding="UTF-8"?>';
	
	$urlset = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	
	fwrite($file_nm,$xmltag.PHP_EOL.PHP_EOL.$urlset.PHP_EOL.PHP_EOL);
	
	
	$q = mysqli_query($c,"select * from category order by cat_id");
	while($r = mysqli_fetch_array($q))
	{
		$cat_id = $r["cat_id"];
		$cat_name = $r["cat_name"];
		$cat_rem_name = str_replace(array(" ","(",")"),array(""),$cat_name); //$cat_rem_name means category special character removed name
		$url_start = "<url>";
		$loc_start = "<loc>";
		$link = "http://www.dailysmsmaza.com/category/".$cat_id."/".$cat_rem_name;
		$loc_end = "</loc>";
		$url_end = "</url>";
		
		fwrite($file_nm,$url_start.PHP_EOL.$loc_start.$link.$loc_end.PHP_EOL.$url_end.PHP_EOL.PHP_EOL);
		
	}
	
	
	fwrite($file_nm,"</urlset>");
	
	fclose($file_nm);
	
	//header("location:/sitemap.xml");
	

	
?>


