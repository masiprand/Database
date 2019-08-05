<?php
namespace Involve\Database;

use Involve\Database\Driver\DriverPDO;
use Involve\Database\Builder\BuilderPDO;

class DB
{

  private static $config = [];
  
  protected static $driver;
  
  protected static $connect;
  
  public function __construct()
  {
    static::$driver = new DriverPDO();
  }
  /*
  *@return set configuration
  */
  public function configuration(array $config)
  {
    static::$config = $config;
    static::$connect = static::$driver->connect(static::$config);
  }
  /*
  *@return table
  */
  public static function table($table)
  {
    return new BuilderPDO(static::$connect,$table);
  }
  /*
  *@return select
  */
  public static function select(string $sql,array $bind = null)
  {
    return static::$driver->select($sql,$bind);
  }  
  
  
  
}