<html>
<head>
</head>
<body>
			<script>
			
				function page_call(file_name)
				{
					 window.location = "<?php echo $adminurl ?>/"+file_name;
				}
				function add_confirm(adtype,file_name,name,id,pid) // adtype that means add or delete type[file or category]
				{
					if(confirm("Do you want to "+adtype+" id : "+name))
			 		{
						document.location.href ="<?=$adminurl?>/"+file_name+"?id="+id+"&pid="+pid;
			 		}
				}	
				function del_confirm(adtype,file_name,name,id,pid)
				{
					if(confirm("Do you want to delete category id : "+name))
			 		{
						document.location.href ="<?=$adminurl?>/"+file_name+"?id="+id+"&pid="+pid;
			 		}
				}		
				
		</script>
</body>
</html>