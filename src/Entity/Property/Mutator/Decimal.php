<?php
declare(strict_types=1);

namespace App\Entity\Property\Mutator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Decimal implements PropertyMutatorInterface {

  private int $decimal;

  private int $roundMode;

  public function __construct(int $decimal, int $roundMode = \PHP_ROUND_HALF_UP) {
    $this->decimal = $decimal;
    $this->roundMode = $roundMode;
  }

  public function mutate($value): mixed {
    return round($value, $this->decimal, $this->roundMode);
  }

}