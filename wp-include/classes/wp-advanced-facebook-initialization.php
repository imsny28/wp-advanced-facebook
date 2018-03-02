<?php

class AdvancedFacebook
{
  public static function init()
  {
    self::addfiles();
    self::facebook_db_connection();
    $filter = FacebookHook::filter();
    $action = FacebookHook::action();
    $filter->add_filter('init');
    $action->add_action('activated_plugin');
    $action->add_action('deactivated_plugin');
    $action->add_action('admin_menu');
    $action->add_action('admin_enqueue_scripts');
    $action->add_action('wp_ajax_save_option');

    $action->add_action('parse_request');
    $action->add_action('login_init');
    $action->add_action('profile_personal_options');
    $action->add_action('login_form');
    $action->add_action('register_form');
    $action->add_action('bp_sidebar_login_form');
    $filter->add_filter('get_avatar');
    $filter->add_filter('bp_core_fetch_avatar');
    //$filter->add_filter('plugin_action_links');

    $action->add_action('login_form_login');
    $action->add_action('login_form_register');
    $action->add_action('admin_notices');




    new FacebookShortcode();
  }
  private static function addfiles()
  {
    // WP Advanced Facebook predefined
    self::wp_predefined();

    // WP Advanced Facebook hooks
    self::wp_hooks();

  }
  private static function include_file( $filename = null)
	{
		require_once ( PLUGIN_PATH . 'wp-include/classes/' .$filename. '.php' );
	}
  private static function wp_predefined()
  {
    self::include_file('wp-advanced-facebook-assets');
    self::include_file('wp-advanced-facebook-builtin');
    self::include_file('wp-advanced-facebook-connection');
    self::include_file('wp-advanced-facebook-function');
    self::include_file('wp-advanced-facebook-shortcode');
    self::include_file('wp-advanced-facebook-login');

  }
  private static function wp_hooks()
  {
    self::include_file('wp-advanced-facebook-hook');
    self::include_file('wp-advanced-facebook-filter');
    self::include_file('wp-advanced-facebook-action');
    self::include_file('wp-advanced-facebook-add-filter');
    self::include_file('wp-advanced-facebook-add-action');
  }

  public static function wp_admin_template($filename = null, $foldername = null )
  {
    if( $foldername != null )
    {
      require_once ( PLUGIN_PATH . 'template/' .$foldername. '/' .$filename. '.php' );
    }
    else {
      require_once ( PLUGIN_PATH . 'template/' .$filename. '.php' );
    }
  }
  private static function facebook_db_connection()
	{
		register_activation_hook( FACEBOOK_BASE_FILE , array( 'FacebookDB', 'install' ));
	}

}



?>
