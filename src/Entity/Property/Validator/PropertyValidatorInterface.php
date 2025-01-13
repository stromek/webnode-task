<?php
declare(strict_types=1);

namespace App\Entity\Property\Validator;

interface PropertyValidatorInterface {

  
  public function validate($value): bool;


  public function getLastErrorMessage(): ?string;
}