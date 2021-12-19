<div class="bannerwrapper">    
    <div class="bannerbgg">       
        <img src="<?php  echo (get_themeoption('home_banner')!="") ?  base_url('assets/setting/').get_themeoption('home_banner') : 
        base_url('assets/front/images/banner-bg-2.jpg');?>" alt="" />    
    </div>
    
    <div class="bannercaptionwraper">
        <div class="container">
          <div class="bannercaption">
            <?php echo get_themeoption("home_title");?>
            <?php 
             if (get_themeoption('home_description')!="") {        
            ?>
            <?php echo get_themeoption("home_description") ?>
        <?php } ?>
            <form method="GET" action="<?php echo base_url('signup') ?>">
                <input type="email" name="user_email" required="required" class="form-control" placeholder="Enter your work email">
                <input type="submit" class="submitbtn" value="Get Started for Free">
            </form>
            <div class="infotext">No credit card required</div>
          </div>
        </div>
    </div>
</div>
<div class="manually-wrapper">
    <div class="container">
        <div class="row align-items-center">
           
            <div class="col-md-6">
                <div class="manually-images">
                    <img src="<?php echo (get_themeoption('home_middelbanner')!="") ?  base_url('assets/setting/').get_themeoption('home_middelbanner') : base_url('assets/front/images/manually-img.png') ?>" alt="" />
                </div>
            </div>        
            <div class="col-md-6">
                <h2><?php echo get_themeoption("home_middeltitle"); ?></h2>
               <?php echo get_themeoption("home_middeldescription"); ?>
            </div>
        </div>
    </div>
</div>
<div class="testimonial-wrapper">
    <div class="testimonial-container">
      <div class="testimonial-fluid">           
        <div class="laptop-img order-md-1">
          <img src="<?php echo  (get_themeoption('testimonial_banner')!="") ? base_url('assets/setting/').get_themeoption('testimonial_banner') : base_url('assets/front/images/chart-laptop.png') ?>" alt="" />
        </div>      
          <div class="tsti-content">
            <div class="quote-img"><img src="<?php echo base_url('assets/') ?>images/quote-image.png" alt="" /></div>
              <div class="testi-msg">
               <?php echo $testimonial["message"] ?>
              </div>
              <div class="testi-author">
                <div class="testi-avtar"><img src="<?php echo ($testimonial["user_image"]!="") ?  base_url('assets/userimage/').$testimonial["user_image"] : base_url('assets/images/NoImageAvailable.png') ?>" alt="" /></div>
                <div class="avtar-info">
                  <h5><?php echo $testimonial["first_name"]." ".$testimonial["last_name"];?></h5>
                  <div class="designation"><?php echo $testimonial["designation"]; ?></div>
                </div>
              </div>
          </div>
      </div>
    </div>
</div>
<div class="replace-static">
    <div class="container-fluid">
        <div class="row no-guttter align-items-center">
        <div class="col-md-6 replce-img-wrap">
            <img src="<?php echo (get_themeoption('home_fourthsectionbanner')!="") ?  base_url('assets/setting/').get_themeoption('home_fourthsectionbanner') : base_url('assets/front/images/replace-chart.png') ?>" alt="" />
        </div>
        <div class="col-md-6">
            <div class="replace-content">
              <h2><?php echo get_themeoption("home_fourthsectiontitle") ?></h2>
              <?php echo get_themeoption('home_fourthsectiondescription') ?>
              <a href="<?php echo get_themeoption('home_fourthsectionreadmorebuttonlink') ?>" class="readmorebtn"><?php echo get_themeoption('home_fourthsectionreadmorebuttontitle') ?></a>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="managechart">
    <div class="container">
        <div class="managechart-conent">
          <div class="smallarea">
              <h3>Manage your org chart for Free, forever. Upgrade plans anytime.</h3>
              <form class="manageform" method="GET" action="<?php echo base_url('signup') ?>">
                  <input type="email" name="user_email" required="" class="form-control" placeholder="Enter your work email">
                  <input type="submit" class="subntm" value="Get Started for Free">
              </form>
              <div class="infotext">No credit card required</div>
          </div>
        </div>
    </div>
</div>