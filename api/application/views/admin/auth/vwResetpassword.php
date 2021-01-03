<div class="m-login__wrapper">
  <div class="m-login__logo">
    <a href="<?php echo $setting->site_url; ?>">
        <img src="<?php echo base_url($setting->website_admin_logo); ?>" alt="<?php echo $setting->website_admin_logo_caption; ?>">
    </a>
  </div>
  <div class="m-login__signin">
    <div class="m-login__head"> <h3 class="m-login__title"> Reset Passeord </h3> </div>
    <?php echo display_flash('message'); ?>    
    <form class="m-login__form m-form" action="<?php echo base_url('admin/do-resetpassword/').$this->uri->segment(3); ?>" method="post">

     <div class="form-group <?=(has_error('password') !== NULL ) ? 'has-danger' : '';?>">
        <label class="password">Password</label>
        <input class="form-control form-control-lg m-input m-input--air" data-msg-required="Please enter password" required id="password" type="password" name="password" placeholder="Password" value="<?php echo get_input('password'); ?>" autofocus>
        <span class="form-control-feedback text-capitalize"><?=has_error('password')?></span>
      </div>
      <div class="form-group  <?=(has_error('password') !== NULL ) ? 'has-danger' : '';?>">
         <label class="cpassword">Confrim Password</label>
         <input class="form-control form-control-lg m-input m-input--air" data-rule-equalTo="#password" data-msg-required="Please enter confrim password" data-msg-equalTo="Please enter same as password." required id="cpassword" name="cpassword" type="password" placeholder="Confrim Password">
          <span class="form-control-feedback text-capitalize"><?=has_error('cpassword')?></span>
      </div>
      
      <div class="m-login__form-action">
        <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air"><i class="fa fa-sign-in fa-lg fa-fw"></i> Reset</button>
      </div>

    </form>
  </div>
</div>

