<?php

class FacebookAddAction
{
  private $action_array = array();
  public function __construct( $tag, $function_to_add,  $priority ,  $accepted_args )
  {
     $this->action_array['tag'] = $tag;
    $this->action_array['priority'] = $priority;
    $this->action_array['accepted_args'] = $accepted_args;

    add_action($tag, array( &$this, $function_to_add ) ,  $priority ,  $accepted_args );
  }
  public function advanced_facebook_menu_func()
  {
    FacebookFunction::advanced_facebook_Menu();
  }
  public function advanced_facebook_enqueue_scripts_func()
  {
    FacebookAssets::advanced_fb_enqueue_scripts();
  }
  public function advanced_facebook_activated_plugin_func()
  {
      $advanced_facebook_activate_plugin = get_option('advanced_facebook_plugin');
      if( !$advanced_facebook_activate_plugin )
      {
        update_option('advanced_facebook_plugin', 1);
        exit( wp_redirect( admin_url( 'options-general.php?page=advanced_facebook_settings_slug' ) ) );
      }
  }
  public static function advanced_facebook_deactivated_plugin_func()
  {
    $advanced_facebook_deactivate_plugin = get_option('advanced_facebook_plugin');
    if( $advanced_facebook_deactivate_plugin )
    {
      update_option('advanced_facebook_plugin', 0);
    }
  }
  public function advanced_facebook_ajax_func()
  {
    check_ajax_referer( 'my-special-string', 'security',false );
    $_facebook_app['facebook_app_id'] = $_POST['facebook_app_id'];
    $_facebook_app['facebook_app_scret'] = $_POST['facebook_app_scret'];
    $get_facebook_app = FacebookFunction::advanced_facebook_ajax( $_facebook_app );

    $sucess_message = '<div class="alert alert-dismissible alert-success">';
    $sucess_message .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    $sucess_message .= '<strong>Well done!</strong> You successfully read <a href="#" class="alert-link">this important alert message</a>.';
    $sucess_message .= '</div>';

    $_result['get_facebook_app'] = json_encode( $get_facebook_app );
    $_result['success'] = $sucess_message;
    echo json_encode( $_result );
    wp_die();
  }

  public function advanced_facebook_parse_request_func()
  {
    FacebookFunction::advanced_facebook_edit_profile_redirect();
    FacebookFunction::advanced_facebook_login_compat();
    FacebookFunction::advanced_facebook_edit_profile_redirect();
  }
  public function advanced_facebook_login_init_func()
  {
    if (isset($_REQUEST['loginFacebook']) && $_REQUEST['loginFacebook'] == '1') {
      $facebooklogin = new FacebookLogin;
      $facebooklogin->advanced_facebook_login_action();
    }
  }
  public function advanced_facebook_personal_options_func()
  {
    FacebookFunction::advanced_facebook_add_connect_field();
  }
  public function advanced_facebook_login_form_func()
  {
    $current_user = get_current_user_id();

    FacebookFunction::advanced_facebook_add_login_form('',$current_user);
  }
  public function advanced_facebook_jquery_func()
  {
    wp_enqueue_script('jquery');
  }
  public function advanced_facebook_admin_notices_func() {
    $user_info = wp_get_current_user();
    $notice    = get_site_transient($user_info->ID . '_new_fb_admin_notice');
    if ($notice !== false) {
        echo '<div class="updated">
       <p>' . $notice . '</p>
    </div>';
        delete_site_transient($user_info->ID . '_new_fb_admin_notice');
    }
}





}

?>
