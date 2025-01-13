<?php
declare(strict_types=1);

namespace App\Entity\Property;

use App\Entity\Entity;
use App\Entity\OrderItemEntity;
use App\Entity\Property\Mutator\PropertyMutatorInterface;
use App\Entity\Property\Validator\PropertyValidatorInterface;
use App\Exception\EntityPropertyException;


/**
 * Entity property, responsible for the GET/SET, validation and mutation
 */
class Property {

  private string $name;

  private \ReflectionProperty $reflection;

  private Entity $entity;

  public function __construct(Entity $Entity, string $name) {
    $this->entity = $Entity;
    $this->name = $name;
    $this->reflection = new \ReflectionProperty($Entity, $name);
  }


  public function getName(): string {
    return $this->name;
  }


  public function getType(): \ReflectionIntersectionType|\ReflectionNamedType|\ReflectionUnionType|null {
    return $this->reflection->getType();
  }


  /**
   * @throws EntityPropertyException
   */
  public function setValue(mixed $value): void {
    $method = "set".ucfirst($this->name);
    if(method_exists($this->entity, $method)) {
      $this->entity->$method($value);
      $this->validateValue($this->getValueSafe());
      return;
    }

    $value = $this->mutateValue($value);
    $this->validateValue($value);
    $this->reflection->setValue($this->entity, $value);
  }


  /**
   * @throws EntityPropertyException
   */
  public function getValue(): mixed {
    $method = "get".ucfirst($this->name);
    if(method_exists($this->entity, $method)) {
      return $this->entity->$method();
    }

    if(!$this->reflection->isInitialized($this->entity)) {
      throw new EntityPropertyException(sprintf("Typed property '%s' must not be accessed before initialization", get_class($this->entity)."::".$this->name), EntityPropertyException::NOT_INITIALIZED);
    }

    return $this->reflection->getValue($this->entity);
  }


  /**
   * Ignore uninitialized property. In this case the null is returned
   * @throws EntityPropertyException
   */
  public function getValueSafe(): mixed {
    try {
      return $this->getValue();
    }catch(EntityPropertyException $e) {
      if($e->getCode() === $e::NOT_INITIALIZED) {
        return null;
      }

      throw $e;
    }
  }


  public function isValueValid(mixed $value): bool {
    try {
      $this->validateValue($value);
      return true;
    }catch(EntityPropertyException $e) {
      return false;
    }
  }

  public function validate(): void {
    $this->validateValue($this->getValue());
  }

  public function mutate(): mixed {
    return $this->setValue($this->mutateValue($this->getValue()));
  }


  private function mutateValue(mixed $value): mixed {
    $newValue = $value;
    foreach ($this->reflection->getAttributes(PropertyMutatorInterface::class, \ReflectionAttribute::IS_INSTANCEOF) as $Attribute) {
      if(!class_exists($Attribute->getName())) {
        throw new EntityPropertyException(sprintf("Class property mutator '%s' does not exist. Class '%s'", $Attribute->getName(), get_class($this->entity)));
      }

      $newValue = $Attribute->newInstance()->mutate($value, $this->entity);
    }

    return $newValue;
  }

  /**
   * @throws EntityPropertyException
   */
  private function validateValue(mixed $value): void {
    foreach ($this->reflection->getAttributes(PropertyValidatorInterface::class, \ReflectionAttribute::IS_INSTANCEOF) as $Attribute) {
      if(!class_exists($Attribute->getName())) {
        throw new EntityPropertyException(sprintf("Class property validator '%s' does not exist. Class '%s'", $Attribute->getName(), get_class($this->entity)));
      }

      $Property = $Attribute->newInstance();
      if(!$Property->validate($value, $this->entity)) {
        throw new EntityPropertyException($Property->getLastErrorMessage());
      }
    }
  }

}