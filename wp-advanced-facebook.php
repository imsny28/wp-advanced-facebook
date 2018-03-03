<?php
   /*
   Plugin Name: WP Advanced Facebook
   Plugin URI: https://www.facebook.com/
   description: This plugins helps you create Facebook login and register buttons. The login and register process only takes one click. if you want get all the images from facebook and want to post images on facebook this plugin will help you
   Version: 1.0
   Author: Mr. Fateh Singh
   Author URI: https://www.facebook.com/sunny.13.3.93
   */

  if( !defined('ABSPATH') )
  {
     exit;
  }
  // in the main plugin file ../wp-advanced-facebook/wp-advanced-facebook.php
  define( 'FACEBOOK_BASE_FILE', __FILE__ );

  // Path from root htdoc/wordpress/wp-content/plugins/wp-advanced-facebook/
  define('PLUGIN_PATH', plugin_dir_path(__FILE__));

  //Path from url http://www.xyz.com/wp-content/plugins/wp-advanced-facebook
  define('PLUGIN_URL',plugins_url()."/wp-advanced-facebook");

  require_once ( PLUGIN_PATH . 'wp-include/classes/wp-advanced-facebook-initialization.php' );
  require_once ( PLUGIN_PATH . '/wp-advanced-facebook-function-common.php' );
  AdvancedFacebook::init();
