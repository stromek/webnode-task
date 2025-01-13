<?php
declare(strict_types=1);

namespace App\Entity\Property\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class EmailAddress extends PropertyValidator {

  public function validate($value): bool {
    return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : $this->fail("E-mail address is not valid");
  }
}