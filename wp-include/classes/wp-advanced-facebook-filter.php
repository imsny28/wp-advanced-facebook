<?php
/*
call Facebook Filter
add filter
do filter
*/
class FacebookFilter
{
  public function add_filter($tag, $function_to_add=null,  $priority = 10,  $accepted_args = 1)
  {
    $function_to_add = self::choose_callback($tag);
    $facebookaddfilter = new FacebookAddFilter($tag, $function_to_add,  $priority,  $accepted_args);
  }
  private function choose_callback($tag)
  {
    switch ($tag) {
    case "init":
        return "advanced_facebook_query_var_func";
        break;
    case "get_avatar":
        return "advanced_facebook_insert_avatar_func";
        break;
    case "bp_core_fetch_avatar":
        return "advanced_facebook_bp_insert_avatar_func";
        break;
    case "plugin_action_links":
        return "advanced_facebook_plugin_action_links_func";
        break;
    default:
         return "wrong function";
       }
  }
}
?>
