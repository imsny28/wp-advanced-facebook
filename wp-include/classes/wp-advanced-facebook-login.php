<?php

class FacebookLogin
{

  public function advanced_facebook_login_action()
  {
    //global $wp, $wpdb, $new_fb_settings;
    $_wp = FacebbokBuiltIn::wp();
    $_wpdb = FacebbokBuiltIn::wp_db();
    $_advanced_facebbook_settings = FacebbokBuiltIn::advanced_facebbook_settings();
    $this->delete_table();
    $this->is_user_login();
    # checking facebook class existning
    if (!class_exists('Facebook')) {
        require(PLUGIN_PATH . '/Facebook/autoload.php');
    }
    $settings  = maybe_unserialize(get_option('Facebook_app'));
    if (defined('NEXTEND_FB_APP_ID')) $settings['facebook_app_id'] = NEXTEND_FB_APP_ID;
    if (defined('NEXTEND_FB_APP_SECRET')) $settings['facebook_app_scret'] = NEXTEND_FB_APP_SECRET;

    $fb = $this->facebook_app( $settings['facebook_app_id'], $settings['facebook_app_scret'], FacebookFunction::advanced_facebook_uniqid() );
    if (isset($_REQUEST['code'])) {
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken(FacebookFunction::advanced_facebook_login_url());
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }
        }

        $response     = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
        $user_profile = $response->getGraphUser();

        $ID = $_wpdb->get_var($_wpdb->prepare('
        SELECT ID FROM ' . $_wpdb->prefix . 'social_users WHERE type = "fb" AND identifier = "%d"
      ', $user_profile['id']));
        if (!get_user_by('id', $ID)) {
            $_wpdb->query($_wpdb->prepare('
          DELETE FROM ' . $_wpdb->prefix . 'social_users WHERE ID = "%d"
        ', $ID));
            $ID = null;
        }
        if (!is_user_logged_in()) {
            if ($ID == NULL) { // Register

                if (!isset($user_profile['email'])) $user_profile['email'] = $user_profile['id'] . '@facebook.com';
                $ID = email_exists($user_profile['email']);
                if ($ID == false) { // Real register

                    require_once(ABSPATH . WPINC . '/registration.php');
                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    if (!isset($_advanced_facebbook_settings['fb_user_prefix'])) $_advanced_facebbook_settings['fb_user_prefix'] = 'facebook-';

                    $username             = strtolower($user_profile['first_name'] . $user_profile['last_name']);
                    $sanitized_user_login = sanitize_user($_advanced_facebbook_settings['fb_user_prefix'] . $username);
                    if (!validate_username($sanitized_user_login)) {
                        $sanitized_user_login = sanitize_user('facebook' . $user_profile['id']);
                    }
                    $defaul_user_name = $sanitized_user_login;
                    $i                = 1;
                    while (username_exists($sanitized_user_login)) {
                        $sanitized_user_login = $defaul_user_name . $i;
                        $i++;
                    }
                    $ID = wp_create_user($sanitized_user_login, $random_password, $user_profile['email']);
                    if (!is_wp_error($ID)) {
                        wp_new_user_notification($ID, $random_password);
                        $user_info = get_userdata($ID);
                        wp_update_user(array(
                            'ID'           => $ID,
                            'display_name' => $user_profile['name'],
                            'first_name'   => $user_profile['first_name'],
                            'last_name'    => $user_profile['last_name']
                        ));

                        //update_user_meta( $ID, 'new_fb_default_password', $user_info->user_pass);
                        do_action('user_registered', $ID, $user_profile, $fb);
                    } else {
                        return;
                    }
                }
                if ($ID) {
                    $_wpdb->insert($wpdb->prefix . 'social_users', array(
                        'ID'         => $ID,
                        'type'       => 'fb',
                        'identifier' => $user_profile['id']
                    ), array(
                        '%d',
                        '%s',
                        '%s'
                    ));
                }
                if (isset($_advanced_facebbook_settings['fb_redirect_reg']) && $_advanced_facebbook_settings['fb_redirect_reg'] != '' && $_advanced_facebbook_settings['fb_redirect_reg'] != 'auto') {
                    set_site_transient(FacebookFunction::advanced_facebook_uniqid() . '_fb_r', $_advanced_facebbook_settings['fb_redirect_reg'], 3600);
                }
            }
            if ($ID) { // Login

                $secure_cookie = is_ssl();
                $secure_cookie = apply_filters('secure_signon_cookie', $secure_cookie, array());
                global $auth_secure_cookie; // XXX ugly hack to pass this to wp_authenticate_cookie

                $auth_secure_cookie = $secure_cookie;
                wp_set_auth_cookie($ID, true, $secure_cookie);
                $user_info = get_userdata($ID);
                update_user_meta($ID, 'fb_profile_picture', 'https://graph.facebook.com/' . $user_profile['id'] . '/picture?type=large');
                do_action('wp_login', $user_info->user_login, $user_info);
                update_user_meta($ID, 'fb_user_access_token', $accessToken);
                do_action('user_logged_in', $ID, $user_profile, $fb);
            }
        } else {
            $current_user = wp_get_current_user();
            if ($current_user->ID == $ID) {

                // It was a simple login

            } elseif ($ID === NULL) { // Let's connect the accout to the current user!

                $_wpdb->insert($wpdb->prefix . 'social_users', array(
                    'ID'         => $current_user->ID,
                    'type'       => 'fb',
                    'identifier' => $user_profile['id']
                ), array(
                    '%d',
                    '%s',
                    '%s'
                ));
                update_user_meta($current_user->ID, 'fb_user_access_token', (string) $accessToken);
                do_action('user_account_linked', $ID, $user_profile, $fb);
                $user_info = wp_get_current_user();
                set_site_transient($user_info->ID . '_new_fb_admin_notice', __('Your Facebook profile is successfully linked with your account. Now you can sign in with Facebook easily.', 'nextend-facebook-connect'), 3600);
            } else {
                $user_info = wp_get_current_user();
                set_site_transient($user_info->ID . '_new_fb_admin_notice', __('This Facebook profile is already linked with other account. Linking process failed!', 'nextend-facebook-connect'), 3600);
            }
        }
        FacebookFunction::advanced_facebook__redirect();
    } else {
        $helper = $fb->getRedirectLoginHelper();

        $permissions = apply_filters('nextend_fb_permissions', array('email'));
        $loginUrl    = $helper->getLoginUrl(FacebookFunction::advanced_facebook_login_url(), $permissions);

        if (isset($_advanced_facebbook_settings['fb_redirect']) && $_advanced_facebbook_settings['fb_redirect'] != '' && $_advanced_facebbook_settings['fb_redirect'] != 'auto') {
            $_GET['redirect'] = $_advanced_facebbook_settings['fb_redirect'];
        }
        if (isset($_GET['redirect'])) {
            set_site_transient(FacebookFunction::advanced_facebook_uniqid() . '_fb_r', $_GET['redirect'], 3600);
        }
        $redirect = get_site_transient(FacebookFunction::advanced_facebook_uniqid() . '_fb_r');
        if ($redirect == '' || $redirect == FacebookFunction::advanced_facebook_login_url()) {
            set_site_transient(FacebookFunction::advanced_facebook_uniqid() . '_fb_r', site_url(), 3600);
        }

        header('Location: ' . $loginUrl);
        exit;
    }
  }
  // delete the file
  private function delete_table()
  {
    if (isset($_GET['action']) && $_GET['action'] == 'unlink') {
        $user_info = wp_get_current_user();
        if ($user_info->ID) {
            $_wpdb->query($_wpdb->prepare('DELETE FROM ' . $_wpdb->prefix . 'social_users
          WHERE ID = %d
          AND type = \'fb\'', $user_info->ID));
            set_site_transient($user_info->ID . '_new_fb_admin_notice', __('Your Facebook profile is successfully unlinked from your account.', 'wp-advanced-facebook'), 3600);
        }
        FacebookFunction::advanced_facebook__redirect();
    }
  }
  //checking user logined
  private function is_user_login()
  {
    if (is_user_logged_in() && FacebookFunction::advanced_facebook_is_user_connected()) {
        FacebookFunction::advanced_facebook__redirect();
        exit;
    }
  }
  private function facebook_app( $app_id, $app_scret, $uniqid )
  {
    $fb = new Facebook\Facebook(array(
        'app_id'                  => $app_id,
        'app_secret'              => $app_scret,
        'persistent_data_handler' => new Facebook\PersistentData\FacebookWordPressPersistentDataHandler($uniqid)
    ));
    return $fb;
  }

}
?>
