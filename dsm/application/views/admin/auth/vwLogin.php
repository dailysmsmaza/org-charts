<div class="m-login__wrapper">
  <div class="m-login__logo">
  
        <img src="<?php echo base_url($setting->website_admin_logo); ?>" alt="<?php echo $setting->website_admin_logo_caption; ?>">
 
  </div>
  <div class="m-login__signin">
    <div class="m-login__head"> <h3 class="m-login__title"> Sign In To Admin </h3> </div>

    <?php echo display_flash('message'); ?>    

    <form class="m-login__form m-form" action="<?php echo base_url('admin/do-login'); ?>" method="post">
     <div class="form-group <?=(has_error('email') !== NULL ) ? 'has-danger' : '';?>">
      <label class="control-label">Email</label>
      <input class="form-control form-control-lg m-input m-input--air" required data-msg-required="Please enter email." type="email" name="email" placeholder="Email" value="<?php echo get_input('email'); ?>" autofocus>
      <span class="form-control-feedback text-capitalize"><?=has_error('email')?></span>
    </div>

    <div class="form-group  <?=(has_error('password') !== NULL ) ? 'has-danger' : '';?>">
      <label class="control-label">Password</label>
      <input class="form-control form-control-lg m-input m-input--air" required data-msg-required="Please enter password" name="password" type="password" placeholder="Password">
      <span class="form-control-feedback text-capitalize"><?=has_error('password')?></span>
    </div>

    <div class="row m-login__form-sub">
      <div class="col m--align-right">
       <!-- <a href="<?php echo site_url('admin/forgot-password'); ?>" id="m_login_forget_password" class="m-link">
          Forget Password ?
        </a>-->
      </div>
    </div>
    
    <div class="m-login__form-action">
      <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
      Sign In
      </button>
    </div>
  </form>
  </div>
</div>