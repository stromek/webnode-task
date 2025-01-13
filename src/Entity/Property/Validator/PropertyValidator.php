<?php
declare(strict_types=1);

namespace App\Entity\Property\Validator;

abstract class PropertyValidator implements PropertyValidatorInterface {

  protected ?string $lastErrorMessage = null;

  /**
   * @TODO dořešit kontext validace. Např. PSČ/Tel. číslo nelze správně validovat bez znalosti země
   */
  public function validate($value): bool {
    return true;
  }


  public function getLastErrorMessage(): ?string {
    return $this->lastErrorMessage;
  }


  protected function setLastErrorMessage(?string $lastErrorMessage): void {
    $this->lastErrorMessage = $lastErrorMessage;
  }


  protected function fail(string $errorMessage): false {
    $this->setLastErrorMessage($errorMessage);

    return false;
  }
}