<?php

/*
call action
*/

class FacebookAction
{
  public function add_action($tag, $function_to_add=null,  $priority = 10,  $accepted_args = 1)
  {
      $function_to_add = self::choose_callback($tag);
      $facebookaddfilter = new FacebookAddAction($tag, $function_to_add,  $priority,  $accepted_args);
  }
  private function choose_callback($tag)
  {
    switch ( $tag ) {
    case "activated_plugin":
        return "advanced_facebook_activated_plugin_func";
        break;
    case "deactivated_plugin":
        return "advanced_facebook_deactivated_plugin_func";
        break;
    case "admin_menu":
        return "advanced_facebook_menu_func";
        break;
    case "admin_enqueue_scripts":
        return "advanced_facebook_enqueue_scripts_func";
        break;
    case "wp_ajax_save_option":
        return "advanced_facebook_ajax_func";
        break;
    case "parse_request":
        return "advanced_facebook_parse_request_func";
        break;
    case "login_init":
        return "advanced_facebook_login_init_func";
        break;
    case "profile_personal_options":
        return "advanced_facebook_personal_options_func";
        break;
    case "login_form":
        return "advanced_facebook_login_form_func";
        break;
    case "register_form":
        return "advanced_facebook_login_form_func";
        break;
    case "bp_sidebar_login_form":
        return "advanced_facebook_login_form_func";
        break;
    case "login_form_login":
        return "advanced_facebook_jquery_func";
        break;
    case "login_form_register":
        return "advanced_facebook_jquery_func";
        break;
   case "admin_notices":
          return "advanced_facebook_admin_notices_func";
          break;
    default:
         return "wrong function";
       }
  }
}
