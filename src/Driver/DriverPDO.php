<?php
namespace Involve\Database\Driver;

use PDO;

class DriverPDO
{
  
  private $options;
  private $fetch;
  private $dbh;
  
  public function __construct()
  {
  
    $this->options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    
  }
  
  public function connect(array $config)
  {
    $dsn = "mysql:dbhost={$config['PDO']['host']};dbname={$config['PDO']['dbname']}";
    $this->fetch = $config['PDO']['fetch'];
    try{
      $this->dbh = new PDO($dsn,$config['PDO']['user'],$config['PDO']['pass'],$this->options);
    }catch(PDOException $e){
      die($e->getMessage());
    }
    
    return $this;
    
  }
  
  public function prepare(string $query)
  {
    $this->stmt = $this->dbh->prepare($query);
  }
  
  public function bind($param,$value,$type = null)
  {
    if(is_null($type)){
      switch(true){
        case is_int($value):
          $type = PDO::PARAM_INT;
        break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
        break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
        break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    
    $this->stmt->bindValue($param,$value,$type);
  }
  
  public function execute()
  {
    $this->stmt->execute();
  }
  
  public function select(string $select,array $bind = null,$key = 'select')
  {
   if($key = 'select'){
     if(is_null($bind)){
       $sql = $select;
       $stmt = $this->dbh->query($sql);
       return $stmt->fetchAll($this->fetch);
     }else{
      
       $sql = $select;
       $this->prepare($sql);
       foreach($bind as $key => $value){
         $this->bind($key,$value);
       }
       $this->execute();
       return $this->stmt->fetchAll($this->fetch);
      
     }
   }
  }
  
  public function delete($table,)
  {
  
  }
  
}