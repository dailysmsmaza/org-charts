<!-- footer start -->
  <footer class="footer afterloginfooter smootheffect comleftnone clsfootersec">
      <div class="maincontainer">
      <div class="copyright"><?php echo get_themeoption('copyright');?></div>
      </div>
</footer>
<!-- footer over -->


<script  src="<?php echo base_url('assets/') ?>js/jquery_validation.js"></script>       
<script src="<?php echo base_url('assets/') ?>js/bootstrap.js"></script> 
<!--Admin Side Bar menu Script----> 
<script>
    $(function(){
        $(".menuicon").click(function(e) {
          $(this).toggleClass("active");
          $(".sidebar").toggleClass("hidesidebar");
          $(".brandlogo").toggleClass("hidebrand");
          $(".maincontentarea").toggleClass("fullmaincontent");
          $(".footer").toggleClass("fullfooter");
        });
    });
  </script>
</body>
</html>