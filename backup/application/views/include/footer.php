<!-- footer start -->
<footer class="footer">
  <div class="container">
      <div class="footertop">
          <div class="row">
              <div class="col-md-4">
                  <h4>Information</h4>
                  <ul>
                      <li><a href="<?php echo base_url() ?>">Home</a></li>
                      <li><a href="<?php echo base_url() ?>">About Us</a></li>                      
                  </ul>
              </div>
              <div class="col-md-4">
                  <h4>Support</h4>
                  <ul>
                      <li><a href="<?php echo base_url('contact') ?>">Contact Us</a></li>
                      <li><a href="#">Security</a></li>
                      <li><a href="#">Privacy Policy</a></li>
                      <li><a href="#">Tearms & Conditions</a></li>
                  </ul>
              </div>
              <div class="col-md-4">
                  <h4>Contact</h4>
                  <div class="cntc-box">
                      <span class="cntcicn"><img src="<?php echo base_url('assets/') ?>images/location.png" alt="" /></span><?php echo get_themeoption("address"); ?>
                  </div>
                  <div class="cntc-box">
                      <span class="cntcicn"><img src="<?php echo base_url('assets/') ?>images/phone.png" alt="" /></span><a href="telto:<?php echo get_themeoption('phone') ?>"> <?php echo (get_themeoption("phone") !="") ? "+"." ".get_themeoption("phone") : ""; ?></a>
                  </div>
                  <div class="cntc-box">
                      <span class="cntcicn"><img src="<?php echo base_url('assets/') ?>images/email.png" alt="" /></span><a href="mailto:<?php echo get_themeoption('email') ?>"><?php echo get_themeoption("email") ?></a>
                  </div>
              </div>
          </div>
      </div>
      <div class="footercopyright">
          <div class="row">
              <div class="col-md-6 order-md-1">
                  <div class="ftr-social">
                      <a href="<?php echo get_themeoption('facebook');?>" target="_blank"><i class="fa fa-facebook"></i></a>
                      <a href="<?php echo get_themeoption('twitter');?>" target="_blank"><i class="fa fa-twitter"></i></a>
                      <a href="<?php echo get_themeoption('instagram');?>" target="_blank"><i class="fa fa-instagram"></i></a>
                      <a href="<?php echo get_themeoption('pinterest');?>" target="_blank"><i class="fa fa-pinterest-p"></i></a>
                      <a href="<?php echo get_themeoption('linkedin');?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="copyright"><?php echo get_themeoption('copyright');?></div>
              </div>
          </div>
      </div>
  </div>
</footer>
<!-- footer over -->
<script src="<?php echo base_url('assets/') ?>js/jquery-3.2.1.min.js"></script> 
<script src="<?php echo base_url('assets/') ?>js/bootstrap.js"></script> 

</body>
</html>