<?php
	
		 $d = $msg_data["date"];
		 $time_diff =  time() - $d;
		 $seconds   = $time_diff;
  	    $minutes   = round($time_diff / 60);
  	    $hours     = round($time_diff / (60 * 60));
  	    $days      = round($time_diff / (60 * 60 * 24));
        $weeks     = round($time_diff / (60 * 60 * 24 * 7));
        $months    = round($time_diff / (60 * 60 * 24 * 30));
        $years     = round($time_diff / (60 * 60 * 24 * 365));
		
		 if ($seconds <= 60) 
		 {
        	$ago =  "$seconds seconds ago ";
    	 } 
		else if ($minutes <= 60) 
		{
        	if ($minutes == 1) 
			{
            	$ago =  "1 minute ago";
        	}
			else
			{
            	$ago =  "$minutes minutes ago ";
        	}
    	}
		else if ($hours <= 24) 
		{
        	if ($hours == 1) 
			{
            	$ago =  "1 hour ago ";
        	}
		    else
			{
            	$ago =  "$hours hours ago ";
        	}
    	}
		else if ($days <= 7) 
		{
        	if ($days == 1) 
			{
            	$ago =  "1 day ago ";
        	}
			else
			{
            	$ago =  "$days days ago ";
        	}
    	}
		else if ($weeks <= 4) 
		{
        	if ($weeks == 1) 
			{
            	$ago =  "1 week ago ";
	        }
			else
			{
            	$ago =  "$weeks weeks ago ";
        	}
    	}
		else if ($months <= 12) 
		{
        	if ($months == 1) 
			{
            	$ago =  "1 month ago ";
        	}
			else
			{
            	$ago =  "$months months ago ";
        	}
    	}
		else
		{
        	if ($years == 1) 
			{
            	$ago =  "1 year ago ";
        	}
			else
			{
            	$ago =  "$years years ago ";
        	}
		 
		}
    	
	
	
	
?>