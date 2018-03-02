<?php
/*
Hook is two type

Action Hook
Filter Hook
*/

class FacebookHook
{

  public static function action()
  {
    $FacebookAction= new FacebookAction;
    return $FacebookAction;
  }
  public static function filter()
  {
    $FacebookFilter = new FacebookFilter;
    return $FacebookFilter;
  }
}

?>
