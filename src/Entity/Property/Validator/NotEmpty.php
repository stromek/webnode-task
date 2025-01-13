<?php
declare(strict_types=1);

namespace App\Entity\Property\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotEmpty extends PropertyValidator {

  public function validate($value): bool {
    return mb_strlen(strval($value)) ? true : $this->fail("Value '{$value}' must not be empty.");
  }
}