<?php
declare(strict_types=1);

namespace App\Repository;

use App\Http\Enum\StatusCodeEnum;


class RepositoryException extends \Exception implements \App\Interface\AppErrorInterface {

  const NOT_FOUND = 404;

  public function getStatusCodeEnum(): StatusCodeEnum {
    return match ($this->code) {
      self::NOT_FOUND => StatusCodeEnum::STATUS_NOT_FOUND,
    };
  }

}