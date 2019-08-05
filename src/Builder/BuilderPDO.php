<?php
namespace Involve\Database\Builder;

use Involve\Database\Driver\DriverPDO;

class BuilderPDO
{
  /*
  *@var bind
  */
  private $bind;
  /*
  *@var driver
  */
  protected $driver;
  /*
  *@var propertis
  */
  protected $propertis = [
        'select'   => null,
        'from'     => null,
        'where'    => null,
        'order by' => null,
        'join'     => null,
        'update'   => null,
        'delete'   => null,
        'insert'   => null,
        'into'     => null,
     ];
  
  public function __construct($driver,$table)
  {
    $this->table = $table;
    $this->driver = $driver;
    $this->propertis['from'] = $table;
 
  }
  /*
  *@return get
  */
  public function get(string $select = '*')
  {
   $from = $this->propertis['from'];
   $where = $this->propertis['where'];
   $order = $this->properris['order by'];
   if(!isset($this->bind)){
     return $this->driver->select("select {$select} from {$from} {$where} {$order}");
   }
   
   if(isset($this->bind)){
     return $this->driver->select("select {$select} from {$from} {$where} {$order}",$this->bind);
   }
   
  }
  /*
  *@return where
  */
  public function where($where,array $bind = null)
  {
    if(is_null($bind)){
      $this->propertis['where'] = " where ".$where;
    }else{
      $this->propertis['where'] = " where ".$where;
      $this->bind = $bind;
    }
    
    return $this;
  }
  
  

}