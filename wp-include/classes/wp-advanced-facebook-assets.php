<?php

class FacebookAssets
{
  public static function advanced_fb_enqueue_scripts()
  {
    $_page = FacebbokBuiltIn::is_pagenow();
    $_screen = get_current_screen();
    if(self::is_advanced_fb_setting_page( $_page , $_screen ) )
    {
      /* Adding css */
      self::add_css_files();
      /* Adding js */
      self::add_js_files();
    }
  }


  // check we are at facebook setting page
  private static function is_advanced_fb_setting_page( $page , $screens )
  {
    return $page == "options-general.php" && $screens->base == "settings_page_advanced_facebook_settings_slug";
  }
  // Add css files function
  private  static function add_css_files()
  {
    wp_enqueue_style( 'advaced_fb-admin-bootstrap-min', PLUGIN_URL . '/assets/css/bootstrap.min.css' , array(), null, 'all' );
    wp_enqueue_style( 'advaced_fb-admin-css',PLUGIN_URL . '/assets/css/admin-custom-css.css');
    wp_enqueue_style( 'advaced_fb-admin-bootstrap-toggle', PLUGIN_URL . '/assets/css/bootstrap-toggle.min.css', array(), null, 'all' );
  }
  // Add js files function
  private static function add_js_files()
  {
    wp_enqueue_script('advaced_fb-admin-js', PLUGIN_URL . '/assets/js/admin-custom-js.js',array('jquery','jquery-ui-datepicker'),true);
    wp_enqueue_script('advaced_fb-admin-bootstrap-min',PLUGIN_URL . '/assets/js/bootstrap.min.js');
    wp_enqueue_script('advaced_fb-admin-bootstrap-toggle',PLUGIN_URL . '/assets/js/bootstrap-toggle.min.js',array(),true);
  }
}
