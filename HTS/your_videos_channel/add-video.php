<?php include('session.php'); ?>
<?php include 'public/menubar.php'; ?>

<script src="assets/js/ckeditor/ckeditor.js"></script>
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>

<script type="text/javascript">

	(function($,W,D) {
	    var JQUERY4U = {};
	    JQUERY4U.UTIL = {
	        setupFormValidation: function() {
	            //form validation rules
	            $("#form-validation").validate({
	                rules: {
						cat_id				: "required",
	                	video_title			: "required",
	                	video_duration		: "required",
	                	video_description	: "required",
	                	youtube				: "required",
	                	url_source			: "required",
	                	video				: "required",
	                	image				: "required",
						video_thumbnail 	: "required"					 
	   				},

	                 messages: { 
						cat_id 				: "Please fill out this field!",
						video_title 		: "Please fill out this field!",
						video_duration 		: "Please fill out this field!",
						video_description 	: "Please fill out this field!",
						youtube 			: "Please fill out this field!",
						url_source 			: "Please fill out this field!",
						video 				: "Please fill out this field!",
						image 				: "Please fill out this field!",
						video_thumbnail 	: "Please fill out this field!"

					},
					errorElement : 'div',
	                submitHandler: function(form) {
	                    form.submit();
	                }

	            });
	        }
	    }

	    //when the dom has loaded setup form validation rules
	    $(D).ready(function($) {
	        JQUERY4U.UTIL.setupFormValidation();
	    });

	})(jQuery, window, document);

</script>

<?php include 'public/add-video-form.php'; ?>
<?php include('public/footer.php'); ?>