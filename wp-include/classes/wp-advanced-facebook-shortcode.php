<?php

/**
 *  Advanced Facebook Shortcode
 */
class FacebookShortcode
{

  function __construct()
  {
    add_shortcode('facebok_login', array($this,'facebok_login_func'));
  }
  public function facebok_login_func( $atts ,$content = null ) {
      $button_atts = shortcode_atts( array(
          'text' => 'Login with facebook',
          'class' => '',
          'url'=> '',
          'width'=>'',
          'height'=>'',
      ), $atts );
      return $this->facebook_button_display( $button_atts ) ;
  }
  public function facebook_button_display( $button_atts )
  {

    $text = $this->check_image_url( $button_atts );
    $facebook_button_display = '<a href= "'. FacebookFunction::advanced_facebook_login_url() . '&redirect=' . get_option('siteurl').'" onclick="window.location = \'' . FacebookFunction::advanced_facebook_login_url() . '&redirect=\'+window.location.href; return false;" class = "login-facebook '.$button_atts['class'].'">';
    $facebook_button_display .= $text ;
    $facebook_button_display .= "</a>";
    return $facebook_button_display ;
  }

  public function check_image_url( $button_atts )
  {
    if($button_atts['url'] != '')
    {
      $text = '<img src = "'. $button_atts['url'] .'"' ;
      $text .=  'width = "' . $button_atts['width'] .'"' ;
      $text .= ' height = "' . $button_atts['height'] . '"' ;
      $text .= '/>' ;
      return $text ;
    }
    else {
      $text = $button_atts['text'] ;
      return $text ;
    }
  }
}


?>
