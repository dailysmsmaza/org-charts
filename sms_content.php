<div class="list-group">
	<ul> </ul>
 	<ul class="w3-ul w3-card-4">
		<li> 
			<?php

				 $msg_data_sms = $client->shortnameToUnicode($msg_data_sms);
				//$msg_data_sms = strip_tags($msg_data_sms);

			    // truncate string
			   // $msg_data_sms = substr($msg_data_sms, 0, 50);

			    // make sure it ends in a word so assassinate doesn't become ass...
			    //$msg_data_sms = substr($msg_data_sms , 0, strrpos($msg_data_sms , ' ')).'... <a href="/this/story">Read More</a>'; 
				//}
				//$msg_data_sms = trunc($msg_data_sms,$msg_limit);
				echo $msg_data_sms;

			?> 
		</li> 
            
		<blockquote class="blockquote-reverse">                          
           	<footer> <a href="<?php echo $url; ?>/user/sms/<?php echo $user_id; ?>/page/1"> <?php echo $user_name; ?> </a> </footer> 
		</blockquote>
                                    
                                         
		<center> 
			<mark> <?php echo $ago; ?> </mark>

   			<?php	
			
				$email_sms = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"%0A",$msg_data_sms); 
				$double_quote_remove = str_replace(array('"','"',':'),'',$email_sms);
				$email_sms_double_quote_remove = str_replace('"',"''",$email_sms);
				
				$msg_double_quote_remove = str_replace('"',"''",$msg_data_sms);
				$msg_data_br_remove = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"",$msg_data_sms); 
				$msg_data_br_to_n = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"\n",$msg_double_quote_remove); 
				
				$msg_data_br_to_n_add_line = $msg_data_br_to_n."\n\n";
				$msg_data_add_line = $msg_data_br_remove."\n\n";
				
			?>

			<br> <br>
				
				<a data-text="<?php echo $msg_data_br_to_n."\n\n"; ?>" class="whatsapp"> 
					<img src="images/whatsapp.png" title="Whatsapp Share For DailySMSMaza">
				</a>
				
				<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.dailysmsmaza.com/view/sms/<?php echo $msg_data_id; ?>" target="_blank" title="Share on Facebook">
					<img alt="Share on Facebook" src="images/facebook.png">
				</a> 								
										
				<!-- <a href="https://twitter.com/intent/tweet?source=http://www.dailysmsmaza.com/view/sms/<?php //echo $double_quote_remove; ?>&amp;text=<?php //echo $email_sms; ?>&amp;via=dailysmsmaza" target="_blank" title="Tweet"><img alt="Tweet" src="images/twitter.png"></a> -->
				
				<a href="https://plus.google.com/share?url=http://www.dailysmsmaza.com/view/sms/<?php echo $msg_data_id; ?>" target="_blank" title="Share on Google+">
					<img alt="Share on Google+" src="images/google-plus.png">
				</a>
										
				<a href="mailto:?subject=
					<?php
						$msg_sub_t = mysqli_query($c,"select * from message_sub where sms_id=$msg_data_id");
						while($msg_sub_data_t = mysqli_fetch_array($msg_sub_t))
						{
							$msg_sub_data_cat_id_t = $msg_sub_data_t["cat_id"];
							
							$category_t = mysqli_query($c,"select * from category where cat_id=$msg_sub_data_cat_id_t");
							while($category_data_t = mysqli_fetch_array($category_t))
							{	
								 $category_cat_name_t = $category_data_t["cat_name"];
								 echo $category_cat_name_t.", ";
							}
						}
					?> 
					&amp;body=<?php echo $email_sms_double_quote_remove; ?>" target="_blank" title="Send an email : www.dailysmsmaza.com"> 
					<img alt="Send an email : www.dailysmsmaza.com" src="images/email.png">
				</a>
				
				<a href="sms:?body=<?php echo $email_sms_double_quote_remove."%0A %0A"; ?>"> 
					<img alt="Send an Message : www.dailysmsmaza.com" src="images/message.png">
				</a>
				
				<br />              
				<br />
				
				<?php	//$remove_html = strip_tags($msg_data_sms);	?>		 
                                 						
					<span id="sms-<?php echo $msg_data["id"]; ?>">
						<input type="hidden" id="likes-<?php echo $msg_data["id"]; ?>" value="<?php echo $msg_data["likes"]; ?>">
							<?php
								$query ="SELECT * FROM like_ipaddress WHERE sms_id = '" . $msg_data["id"] . "' and ip_address = '" . $ip_address . "'";
								$count = $db_handle->numRows($query);
								$str_like = "like";
								if(!empty($count)) 
								{
									$str_like = "unlike";
								}
							?>
											
							<span class="btn-likes">
								<input type="button" title="<?php echo ucwords($str_like); ?>" class="<?php echo $str_like; ?>" onClick="addLikes(<?php echo $msg_data["id"]; ?>,'<?php echo $str_like; ?>')" />
							</span>
											
					</span>
						-
					<button data-tooltip-id="1" data-title="Message Copied" class="btn btn-link trigger" aria-label="<?php echo $msg_data_br_to_n_add_line."www.dailysmsmaza.com"; ?>"> 
						Copy  
					</button> 
				
					<br />
					
					<span class="text-warning"> 
						Tags : 
					</span> 
								
					<?php
								
						$msg_sub = mysqli_query($c,"select * from message_sub where sms_id=$msg_data_id");
						while($msg_sub_data = mysqli_fetch_array($msg_sub))
						{
							$msg_sub_data_cat_id = $msg_sub_data["cat_id"];
						
							$category = mysqli_query($c,"select * from category where cat_id=$msg_sub_data_cat_id");
							while($category_data = mysqli_fetch_array($category))
							{	
								$category_cat_name = $category_data["cat_name"];
								$category_cat_id = $category_data["cat_id"];
								$category_cat_re_name = str_replace(array(" ","(",")"),array(""),$category_cat_name);
										
					?>                            
								
					<a href="<?php echo $url."/sms"."/".$category_cat_id."/".$category_cat_re_name."/page/1"; ?>"> 
						<?php echo $category_cat_name; ?> 
					</a> , 
								
					<?php
							}
								
						}
					?>
		 </center> 
	</ul>                                         
</div>