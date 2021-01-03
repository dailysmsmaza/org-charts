<!-- --><div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true"
     data-menu-scrollable="false" data-menu-dropdown-timeout="500">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item " aria-haspopup="true">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">
                            Dashboard
                        </span>
                    </span>
                </span>
            </a>
        </li>

        <!-- Application -->
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('application'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="javascript:voide(0);" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon fa fa-desktop"></i> 
                <span class="m-menu__link-text">Applications<span class="m-menu__link-badge pull-right"> <span class="m-badge m-badge--danger"> 
                            <?php echo $this->common->CountByTable('application'); ?> </span> </span>  
                </span> 
                <i class="m-menu__ver-arrow la la-angle-right"></i>         
            </a>
            <div class="m-menu__submenu">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <?php echo get_subnav('application/create', 'Add Application'); ?>
                    <?php echo get_subnav('application', 'Manage Applications'); ?>
                </ul>
            </div>
        </li>
		<!--End Application -->
        
        <!-- Category -->
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('category'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="javascript:voide(0);" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon fa fa-file-video-o"></i> 
                <span class="m-menu__link-text">Categories<span class="m-menu__link-badge pull-right"> <span class="m-badge m-badge--danger"> 
                            <?php echo $this->common->CountByTable('category'); ?> </span> </span>  
                </span> 
                <i class="m-menu__ver-arrow la la-angle-right"></i>         
            </a>
            <div class="m-menu__submenu">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <?php echo get_subnav('category/create', 'Add Category'); ?>
                    <?php echo get_subnav('category', 'Manage Categories'); ?>
                </ul>
            </div>
        </li>
		<!--End Category -->
		
        <!-- Wallpaper -->
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('wallpaper'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="javascript:voide(0);" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-image"></i> 
                <span class="m-menu__link-text">Wallpapers<span class="m-menu__link-badge pull-right"> <span class="m-badge m-badge--danger"> 
                            <?php echo $this->common->CountByTable('wallpaper'); ?> </span> </span>  
                </span> 
                <i class="m-menu__ver-arrow la la-angle-right"></i>         
            </a>
            <div class="m-menu__submenu">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <?php echo get_subnav('wallpaper/create', 'Add Wallpaper'); ?>
                    <?php echo get_subnav('wallpaper', 'Manage Wallpapers'); ?>
                </ul>
            </div>
        </li>
		<!--End Wallpaper -->
        
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('backup_db'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="<?php echo base_url('admin/backup_db'); ?>" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-ellipsis-h"></i> 
                <span class="m-menu__link-text">Database Backups <span class="m-menu__link-badge pull-right"> 
                        <span class="m-badge m-badge--danger"> 
                            <?php echo $this->common->CountByTable('manage_backup_db'); ?> 
                        </span>
                    </span>  
                </span> 
                <i class="m-menu__ver-arrow"></i>         
            </a>
        </li>


        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('backup'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="<?php echo base_url('admin/backup'); ?>" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-code-fork"></i> 
                <span class="m-menu__link-text">Code Backups<span class="m-menu__link-badge pull-right">
                        <span class="m-badge m-badge--danger"> 
                            <?php echo $this->common->CountByTable('manage_backup'); ?>
                        </span> 
                    </span>
                </span>  
                <i class="m-menu__ver-arrow"></i>         
            </a>
        </li>
        
        <!-- Site Setting -->
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('site_settings'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="<?php echo base_url('admin/site-setting'); ?>" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-cogwheel"></i> 
                <span class="m-menu__link-text">Site Setting </span> 
            </a>
        </li>
        <!-- End Site Setting -->


        <!-- Change Plofile -->
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('profile'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="<?php echo base_url('admin/profile'); ?>" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-profile-1"></i> 
                <span class="m-menu__link-text">Profile</span>  
            </a>
        </li>
        <!-- End Change Plofile -->

        <!-- Change passowed -->
        <li class="m-menu__item  m-menu__item--submenu <?php echo is_menu_active('change_password'); ?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="<?php echo base_url('admin/change-password'); ?>" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-exclamation-triangle"></i> 
                <span class="m-menu__link-text">Change Password</span>  
            </a>
        </li>
        <!-- End Change  passowrd -->

    </ul>
</div>
<!--https://icons8.com/line-awesome-->