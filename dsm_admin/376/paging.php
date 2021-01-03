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
	$x="";

	if($total_pages>1)
	{
		$x.="<div class=\"pagination\">";
				
		if($current_page>1)
		{
			$x.="<ul class='pager pagination'> <li> <a href='$targetpage=1'> << </a> </li> ";
        	//$x.="<li> <a href='$targetpage=$previous'> < </a> </li>";
		}
		
				
		else
		{
			$x.="<ul class='pager pagination'> ";	
		}
		
		for($i=1;$i<=$total_pages;$i++)
   		{	
			if ($i<$current_page && $i>=($current_page-$adjacents) && $i!=$total_pages) 
			{
				$x.="<li> <a href='$targetpage=$i'>".$i."</a> </li>";
  			} 	
  			if($i==$current_page) 
			{
     			$x.="<li> <a href='$targetpage=$i' class='active' >".$i."</a> </li>";
  			}
			if ($i>$current_page && $i<=($current_page+$adjacents) && $i<=$total_pages) 
			{
				$x.="<li> <a href='$targetpage=$i' >".$i."</a></li>";
  			} 	
    	}

		if($current_page!=$total_pages)
    	{
        	//$x.="<li> <a href='$targetpage=$next'> > </a> </li>";
        	$x.="<li> <a href='$targetpage=$total_pages'> >> </a> </li>";
    	}
	}
	

	/*for($i=1;$i<=$total_pages;$i++) 
	{
  		if($i==$current_page) 
		{
     		$x.= "<strong><a href='' style='color:red;text-decoration:none'>".$i."</a></strong>&nbsp;&nbsp;";
  		} 
  		elseif ($i>4 && $i!=$total_no_of_pages) 
		{
     		$x.= ".";
  		}
  		else
		{
     		$x.= "<a href=''>".$i."</a>&nbsp;&nbsp;";
  		}
	}
echo $x;
*/	
?>