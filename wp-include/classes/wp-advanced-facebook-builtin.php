<?php

class FacebbokBuiltIn
{

  public static function wp()
  {
    global $wp;
    return $wp;
  }
  public static function wp_db()
  {
    global $wpdb;
    return $wpdb;
  }
  public static function advanced_facebbook_settings()
  {
    global $advanced_facebbook_settings;
    return $advanced_facebbook_settings;
  }
  public static function is_social_header()
  {
    global $advanced_facebook_is_social_header;
    return $advanced_facebook_is_social_header;
  }
  public static function is_pagenow()
  {
    global $pagenow;
    return $pagenow;
  }
  public static function is_typenow()
  {
    global $typenow;
    return $typenow;
  }
  public static function advanced_facebook_is_social_header()
  {
    global  $new_is_social_header;
    return  $new_is_social_header;
  }
}
?>
