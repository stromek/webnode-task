<?php
declare(strict_types=1);

namespace App\Repository;

use App\Repository\Enum\RepositorySourceEnum;


abstract class RepositoryMySQL implements RepositoryInterface {

  protected \Dibi\Connection $db;

  public function __construct(\Dibi\Connection $db) {
    $this->db = $db;
  }


  public function getSource(): RepositorySourceEnum {
    return RepositorySourceEnum::MYSQL;
  }
  
}