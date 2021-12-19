<div class="subbannerwrapper">
    <div class="container">
        <div class="row">
          <div class="col-lg-7 pagetitle">
              <h1>Contact Us</h1>
          </div>
          <div class="col-lg-5 breadcrumb-wrap">
              <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                  <li class="breadcrumb-item active"><span>Contact Us</span></li>
              </ul>
          </div>
        </div>
    </div>
</div>

<div class="contentpage-section contactpage">
    <div class="container">
       <div class="row">
            <div class="col-lg-4">
                <h3>Contact Details</h3>
                <div class="cntboxwrap">
                      <div class="cntcbxicn"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                      <div class="cntcbxinfo">
                          <h5>Our Location</h5>
                          <?=get_themeoption('address');?>
                      </div>
                </div>
                <div class="cntboxwrap">
                    <div class="cntcbxicn"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <div class="cntcbxinfo">
                        <h5>Call Us</h5>
                        <?=get_themeoption('phone');?>
                    </div>
               </div>
                  <div class="cntboxwrap">
                      <div class="cntcbxicn"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                      <div class="cntcbxinfo">
                          <h5>Email</h5>
                          <a href="mailto:<?=get_themeoption('email');?>"><?=get_themeoption('email');?></a>
                      </div>
                  </div>

                  <div class="followus">
                      <h4>Follow us on</h4><?php
                      $facebook = get_themeoption('facebook');
                      $twitter = get_themeoption('twitter');
                      $linkedin = get_themeoption('linkedin');
                      $instagram = get_themeoption('instagram');

                      if($facebook){ ?>
                        <a href="<?=$facebook;?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a><?php
                      }
                      if($twitter){ ?>
                        <a href="<?=$twitter;?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a><?php
                      }
                      if($linkedin){ ?>
                        <a href="<?=$linkedin;?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a><?php
                      }
                      if($instagram){ ?>
                        <a href="<?=$instagram;?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a> <?php
                      }?>
                  </div>

            </div>

            <div class="col-lg-8">
                <div class="contact-form">
                    <h3>Send a Message</h3>
                    <form method="post" action=""><?php
                      $success = $this->session->flashdata("success");
                      if($success){ ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success") ?>
                        </div><?php
                      } ?>
                      <div class="row">
                        <div class="col-sm-6 form-group">
                            <input class="form-control" name="name" required value="<?=set_value('name');?>" placeholder="Name">
                        </div>

                        <div class="col-sm-6 form-group">
                            <input type="email" name="email" required value="<?=set_value('email');?>" placeholder="Email Address" class="form-control">
                        </div>

                        <div class="col-sm-6 form-group">
                            <input type="text" name="phone" placeholder="Phone Number" value="<?=set_value('phone');?>" class="form-control">
                        </div>

                        <div class="col-sm-6 form-group">
                            <input class="form-control" name="subject" placeholder="Subject" value="<?=set_value('subject');?>">
                        </div>

                        <div class="col-sm-12 form-group">
                            <textarea placeholder="Message" name="message" required class="form-control" spellcheck="false"><?=set_value('message');?></textarea>
                        </div>
                        <div class="col-sm-12 form-group">
                            <input type="submit" value="Send Message">
                        </div>
                      </div>
                    </form>
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