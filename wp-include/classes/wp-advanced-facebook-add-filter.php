<?php

class FacebookAddFilter
{
  private $filter_array = array();
  public function __construct( $tag, $function_to_add,  $priority ,  $accepted_args )
  {
    $this->filter_array['tag'] = $tag;
    $this->filter_array['priority'] = $priority;
    $this->filter_array['accepted_args'] = $accepted_args;
    add_filter($tag, array( $this, $function_to_add ) ,  $priority ,  $accepted_args );
  }

  public function advanced_facebook_query_var_func()
  {
    $_wp = FacebbokBuiltIn::wp();
    $_wp->add_query_var('editProfileRedirect');
    $_wp->add_query_var('loginFacebook');
    $_wp->add_query_var('loginFacebookdoauth');
  }
  public function advanced_facebook_bp_insert_avatar_func()
  {
    FacebookFacebook::advanced_facebook_bp_insert_avatar();
  }

}
?>
