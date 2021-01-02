<html>
<head>
</head>

<body>
	<script>
	
		function goBack()
		{
			window.history.back();
		}


		$(document).ready(function() 
		{

		var isMobile = {
		    Android: function() {
		        return navigator.userAgent.match(/Android/i);
		    },
		    BlackBerry: function() {
		        return navigator.userAgent.match(/BlackBerry/i);
		    },
		    iOS: function() {
		        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		    },
		    Opera: function() {
		        return navigator.userAgent.match(/Opera Mini/i);
		    },
		    Windows: function() {
		        return navigator.userAgent.match(/IEMobile/i);
		    },
		    any: function() {
		        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		    }
		};

	    $(document).on("click",'.whatsapp',function() {

		if( isMobile.any() ) {

		        var text = $(this).attr("data-text");
		        <!-- var url = $(this).attr("data-link"); -->
		        var message = encodeURIComponent(text);<!-- +" - "+encodeURIComponent(url); -->
		        var whatsapp_url = "whatsapp://send?text="+message;
		        window.location.href= whatsapp_url;
		} else {
		    alert("Please share this sms in mobile device");
		}

		    });
		});


	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/platform.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();

	</script>

</body>
</html>

<?php
	function limit_words($words, $limit, $append = ' &hellip;') 
	{
	       
	       $limit = $limit+1;
	       
	       $words = explode(' ', $words, $limit);
	       
	       array_pop($words);
	       
	       $words = implode(' ', $words) . $append;
	       
	       return $words;
	}
?>