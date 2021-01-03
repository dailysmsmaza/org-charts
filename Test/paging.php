<html>
	<head>
    </head>
</html>

<?php

	if(isset($_GET["page"]))
	{
		$current_page = $_GET["page"];
	}
	else
	{
		$current_page = 1;
	}
	
	if($current_page==0)
	{
		$current_page = 1;
	}
	
	if($current_page)
	{
		$start = ($current_page - 1) * $limit;
	}
	else
	{
		$start = 0;
	}
	
	$previous = $current_page - 1;
	$next = $current_page + 1;
	$total_pages = ceil($total_records/$limit);
	$pagination="";

	if($total_pages>1)
	{
		$pagination.="<div class=\"pagination\">";
				
		if($current_page>1)
		{
			$pagination.="<ul class='pager pagination'> <li> <a href='$targetpage=1'> << </a> </li> ";
		}		
		else
		{
			$pagination.="<ul class='pager pagination'> ";	
		}
		
		for($i=1;$i<=$total_pages;$i++)
   		{	
			if ($i<$current_page && $i>=($current_page-$adjacents) && $i!=$total_pages) 
			{
				$pagination.="<li> <a href='$targetpage=$i'>".$i."</a> </li>";
  			} 	
  			if($i==$current_page) 
			{
     			$pagination.="<li class='active'> <a href='$targetpage=$i' >".$i."</a> </li>";
  			}
			if ($i>$current_page && $i<=($current_page+$adjacents) && $i<=$total_pages) 
			{
				$pagination.="<li> <a href='$targetpage=$i' >".$i."</a></li>";
  			} 	
    	}

		if($current_page!=$total_pages)
    	{
        	$pagination.="<li> <a href='$targetpage=$total_pages'> >> </a> </li>";
    	}
	}
	
?>