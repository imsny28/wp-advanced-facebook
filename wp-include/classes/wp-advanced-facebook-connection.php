<?php
/*
Facebook Connection

*/

class FacebookDB
{
  protected static $table = 'social_users';
  protected static function tablename(){
    $_wpdb = FacebbokBuiltIn::wp_db();
    return $_wpdb->prefix .static::$table;
  }
  public static function install() {
    $sql= self::create( self::tablename() );
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
   }
  protected function create( $table_name )
  {
    $query        = "CREATE TABLE $table_name (
    `ID` int(11) NOT NULL,
    `type` varchar(20) NOT NULL,
    `identifier` varchar(100) NOT NULL,
    KEY `ID` (`ID`,`type`)
    );";
    return $query;
  }

}
