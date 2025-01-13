<?php
declare(strict_types=1);

namespace App\Repository\Enum;


enum RepositorySourceEnum {

  case ELASTIC;

  case MYSQL;
  
}