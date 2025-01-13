<?php
declare(strict_types=1);

namespace App\Entity\Property\Mutator;

interface PropertyMutatorInterface {

  public function mutate($value): mixed;

}