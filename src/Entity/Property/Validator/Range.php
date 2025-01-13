<?php
declare(strict_types=1);

namespace App\Entity\Property\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Range extends PropertyValidator {

  private null|int|float $min;

  private null|int|float $max;


  public function __construct(null|int|float $min, null|int|float $max) {
    $this->min = $min;
    $this->max = $max;

    if(is_null($min) AND is_null($max)) {
      throw new \InvalidArgumentException('At least one value (min/max) must be a number or float');
    }
  }
  

  public function validate($value): bool {
    if((!is_null($this->min) AND $value < $this->min) OR (!is_null($this->max) AND $value > $this->max)) {
      return $this->fail("The value '{$value}' must be between {$this->min} and {$this->max}.");
    }

    return true;
  }
}