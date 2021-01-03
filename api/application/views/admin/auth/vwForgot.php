<div class="m-login__wrapper">
  <div class="m-login__logo">
    <a href="<?php echo $setting->site_url; ?>">
    <img src="<?php echo base_url($setting->website_admin_logo); ?>" alt="<?php echo $setting->website_admin_logo_caption; ?>">
    </a>
  </div>
  <div class="m-login__signin">
    <div class="m-login__head"> <h3 class="m-login__title"> Forgot Password ? </h3> </div>
    <?php echo display_flash('message'); ?>    

    <form class="m-login__form m-form" action="<?php echo base_url('admin/do-forgot'); ?>" method="post">

      <div class="form-group <?=(has_error('email') !== NULL ) ? 'has-danger' : '';?>">
        <label class="control-label">Email</label>
        <input class="form-control form-control-lg m-input m-input--air" required data-msg-required="Please enter email." type="email" name="email" placeholder="Email" value="<?php echo get_input('email'); ?>" autofocus>
        <span class="form-control-feedback text-capitalize"><?=has_error('email')?></span>
      </div>

      <div class="m-login__form-action">
        <button id="m_login_signin_submit" type="submit" name="login" value="login"  class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air"> Reset </button>
      </div>

      <div class="col m--align-left">
        <a href="<?php echo site_url('admin'); ?>" id="m_login_forget_password" class="m-link"> <i class="fa fa-chevron-left"></i> Back to Login  </a>
      </div>

  </form>
  </div>
</div>
