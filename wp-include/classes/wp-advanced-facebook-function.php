<?php
/*
Facebook  Important Function
*/

class FacebookFunction
{
  private static $instance;
  public static function instance()
  {

       if (!isset(self::$instance))
       {
           self::$instance = new self();
       }
       return self::$instance;
  }
  public static function  advanced_facebook_Menu() {
    add_options_page(
      'Facebook settings',
      'Advanced Facebook settings',
      'manage_options',
      'advanced_facebook_settings_slug',
      array( self::instance(),"advanced_facebook_settings_func_callback" )
    );
  }
  public static function advanced_facebook_settings_func_callback()
  {
    if(get_option('advanced_facebook_plugin'))
    {
      echo get_option('advanced_facebook_plugin');
      echo '<script>jQuery(document).ready(function(){jQuery("#welcome").modal("show")});</script>';
      require_once ( PLUGIN_PATH . 'template/wp-advanced-facebook-main.php' );
    }
    exit;
  }
  public static function advanced_facebook_ajax( $_facebook_app )
  {
    $savevalues = get_option('Facebook_app');
    $savevalues[ 'facebook_app_id' ]    = self::check_app_id( $_facebook_app[ 'facebook_app_id' ] ) ;
    $savevalues[ 'facebook_app_scret' ] = self::check_app_scret( $_facebook_app[ 'facebook_app_scret' ] ) ;
    update_option('Facebook_app', $savevalues);
    $savevalues = get_option('Facebook_app');
    return $savevalues;

  }
  public static function check_app_id( $_facebook_app_id )
  {
      if( isset( $_facebook_app_id ) )
      {
        return esc_attr( $_facebook_app_id );
      }
  }

  public static function check_app_scret( $_facebook_app_scret )
  {
    if( isset( $_facebook_app_scret ) ){
       return esc_attr( $_facebook_app_scret ) ;
    }
  }
  // Adavanced Facebook Unique ID
  public static function advanced_facebook_uniqid() {
        if (isset($_COOKIE['advanced_facebook_uniqid'])) {
            if (get_site_transient('n_' . $_COOKIE['advanced_facebook_uniqid']) !== false) {
                return $_COOKIE['advanced_facebook_uniqid'];
            }
        }
        $_COOKIE['advanced_facebook_uniqid'] = uniqid('advanced_facebook_uniqid', true);
        setcookie('advanced_facebook_uniqid', $_COOKIE['advanced_facebook_uniqid'], time() + 3600, '/', '', false, true);
        set_site_transient('n_' . $_COOKIE['advanced_facebook_uniqid'], 1, 3600);

        return $_COOKIE['advanced_facebook_uniqid'];
  }

  public static function advanced_facebook_edit_profile_redirect() {
    $_wp = FacebbokBuiltIn::wp();
    if (isset($_wp->query_vars['editProfileRedirect'])) {
      //method_exists('FacebookFunction','bp_loggedin_user_domain')
        //if (function_exists('bp_loggedin_user_domain')) {
        if (method_exists('FacebookFunction','bp_loggedin_user_domain'))
        {
          header('LOCATION: ' . bp_loggedin_user_domain() . 'profile/edit/group/1/');
        }
        else {
          header('LOCATION: ' . self_admin_url('profile.php'));
        }
        exit;
    }
  }

  /*
  Compatibility for older versions
  */
  public static function advanced_facebook_login_compat() {
      $_wp = FacebbokBuiltIn::wp();
      if ($_wp->request == 'loginFacebook' || isset($_wp->query_vars['loginFacebook'])) {
          $facebooklogin = new FacebookLogin ;
          $facebooklogin->advanced_facebook_login_action();
      }
  }

  /*
  Is the current user connected the Facebook profile?
  */

    public static function advanced_facebook_is_user_connected() {
      $_wpdb = FacebbokBuiltIn::wp_db();
      $current_user = wp_get_current_user();
      $ID           = $_wpdb->get_var($_wpdb->prepare('
      SELECT identifier FROM ' . $_wpdb->prefix . 'social_users WHERE type = "fb" AND ID = "%d"
    ', $current_user->ID));
      if ($ID === NULL) return false;

      return $ID;
  }

  function advanced_facebook_get_user_access_token($id) {

      return get_user_meta($id, 'fb_user_access_token', true);
  }

  /*
  Connect Field in the Profile page
  */

  public static function advanced_facebook_add_connect_field() {
      $_is_social_header = FacebbokBuiltIn::advanced_facebook_is_social_header();
      //if(new_fb_is_user_connected()) return;
      if ($_is_social_header === NULL) {
          ?>
          <h3>Social connect</h3>
          <?php
          $_is_social_header = true;
      }
      ?>
      <table class="form-table">
      <tbody>
        <tr>
          <th>
          </th>
          <td>
            <?php
            if (self::advanced_facebook_is_user_connected()) {
                echo self::advanced_facebook_unlink_button();
            } else {
                echo self::advanced_facebook_link_button();
            }
            ?>
          </td>
        </tr>
      </tbody>
    </table>
      <?php
  }
  public static function advanced_facebook_add_login_form() {


      ?>
      <script>

    if (jQuery.type(has_social_form) === "undefined") {
        var has_social_form = false;
        var socialLogins = null;
    }
    jQuery(document).ready(function () {
        (function ($) {
            if (!has_social_form) {
                has_social_form = true;
                var loginForm = $('#loginform,#registerform,#front-login-form,#setupform');
                socialLogins = $('<div class="newsociallogins" style="text-align: center;"><div style="clear:both;"></div></div>');
                if (loginForm.find('input').length > 0)
                    loginForm.prepend("<h3 style='text-align:center;'><?php _e('OR'); ?></h3>");
                loginForm.prepend(socialLogins);
                socialLogins = loginForm.find('.newsociallogins');
            }
            if (!window.fb_added) {
                socialLogins.prepend('<?php echo addslashes(preg_replace('/^\s+|\n|\r|\s+$/m', '', self::advanced_facebook_sign_button())); ?>');
                window.fb_added = true;
            }
        }(jQuery));
    });
    </script>
      <?php
  }
  // check again argument
  public function advanced_facebook_bp_insert_avatar($avatar = '', $params, $id) {
        if (!is_numeric($id) || strpos($avatar, 'gravatar') === false) return $avatar;
        $pic = get_user_meta($id, 'fb_profile_picture', true);
        if (!$pic || $pic == '') return $avatar;
        $avatar = preg_replace('/src=("|\').*?("|\')/i', 'src=\'' . $pic . '\'', $avatar);

        return $avatar;
    }
  // More functions
  public static function advanced_facebook_login_url() {

  return site_url('wp-login.php') . '?loginFacebook=1';
  }
  public static function advanced_facebook_sign_button() {
      $_fb_settings = FacebbokBuiltIn::advanced_facebbook_settings();
      return '<a href="' . esc_url(self::advanced_facebook_login_url() . (isset($_GET['redirect_to']) ? '&redirect=' . $_GET['redirect_to'] : '')) . '" rel="nofollow">' . $_fb_settings['fb_login_button'] . '</a><br />';
  }
  public static function advanced_facebook_link_button() {
    $_fb_settings = FacebbokBuiltIn::advanced_facebbook_settings();
    return '<a href="' . esc_url(self::advanced_facebook_login_url() . '&redirect=' . self::advanced_facebook_curPageURL()) . '">' . $_fb_settings['fb_link_button'] . '</a><br />';
  }

  public static function advanced_facebook_unlink_button() {
    $_fb_settings = FacebbokBuiltIn::advanced_facebbook_settings();
    return '<a href="' . esc_url(self::advanced_facebook_login_url() . '&action=unlink&redirect=' . self::advanced_facebook_curPageURL()) . '">' . $_fb_settings['fb_unlink_button'] . '</a><br />';
  }

  public static function advanced_facebook_curPageURL() {
    $_wp = FacebbokBuiltIn::wp();
    return home_url(add_query_arg(array(),$_wp->request));
  }
  public static function advanced_facebook__redirect() {

    $redirect = get_site_transient(self::advanced_facebook_uniqid() . '_fb_r');

    if (!$redirect || $redirect == '' || $redirect == self::advanced_facebook_login_url()) {
        if (isset($_GET['redirect'])) {
            $redirect = $_GET['redirect'];
        } else {
            $redirect = site_url();
        }
    }
    $redirect = wp_sanitize_redirect($redirect);
    $redirect = wp_validate_redirect($redirect, site_url());
    header('LOCATION: ' . $redirect);
    delete_site_transient(self::advanced_facebook_uniqid() . '_fb_r');
    exit;
  }
  // public static function advanced_facebook_edit_profile_redirect() {
  //
  //   $_wp = FacebbokBuiltIn::wp();
  //   if (isset($_wp->query_vars['editProfileRedirect'])) {
  //       if (function_exists('bp_loggedin_user_domain')) {
  //           header('LOCATION: ' . bp_loggedin_user_domain() . 'profile/edit/group/1/');
  //       } else {
  //           header('LOCATION: ' . self_admin_url('profile.php'));
  //       }
  //       exit;
  //   }


}
?>
