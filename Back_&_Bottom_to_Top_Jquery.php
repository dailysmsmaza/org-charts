<html>
<head>

	<link href="/style.css" rel="stylesheet">
	
	<script src="/bootstrap/jquery.min.js"></script>
	<script type='text/javascript'>
		$(document).ready(function(){ 
			$(window).scroll(function(){ 
				if ($(this).scrollTop() > 100) { 
					$('#scroll').fadeIn(); 
				} else { 
					$('#scroll').fadeOut(); 
				} 
			}); 
			$('#scroll').click(function(){ 
				$("html , body").animate({ scrollTop: 0 }, 600); 
				return false; 
			}); 
		});
	</script>

<body>
   
  	  <a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
	
</body>
</html>