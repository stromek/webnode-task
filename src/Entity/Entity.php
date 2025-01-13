<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Property\Property;
use App\Exception\EntityException;
use App\Exception\EntityPropertyException;


abstract class Entity implements \JsonSerializable, \App\Xml\XMLSerializable {

  /**
   * @var Property[]
   */
  private array $properties;

  /**
   * @throws EntityPropertyException
   * @throws EntityException
   */
  public function __set(string $name, mixed $value): void {
    $this->getProperty($name)->setValue($value);
  }


  /**
   * @throws EntityException
   */
  public function __get(string $name): mixed {
    return $this->getProperty($name)->getValue();
  }


  public function toArray(): array {
    return array_map(function(Property $Property): mixed {
      return $Property->getValueSafe();
    }, $this->getProperties());
  }


  public function mutate(): void {
    foreach($this->getProperties() as $Property) {
      $Property->mutate();
    }
  }

  public function validate(): void {
    foreach($this->getProperties() as $property) {
      $property->validate();
    }
  }


  public function jsonSerialize(): array {
    return array_map(function(mixed $value): mixed {
      if($value instanceof \BackedEnum) {
        return $value->value;
      }

      if($value instanceof \UnitEnum) {
        return $value->name;
      }

      return $value;
    },$this->toArray());
  }


  public function xmlSerialize(): array {
    return $this->jsonSerialize();
  }


  /**
   * @return Property[]
   * @throws EntityException
   */
  public function getProperties(): array {
    if(isset($this->properties)) {
      return $this->properties;
    }
    $this->properties = [];


    $ReflectionClass = new \ReflectionClass($this);
    $pattern = '~@property\s+(?P<type>[^\s]+)\s+\$(?P<name>[^\s]+)~';

    if(!preg_match_all($pattern, $ReflectionClass->getDocComment() ?: "", $matches, PREG_SET_ORDER)) {
      throw new EntityException("No '@property' string found in docs class of ".get_class($this));
    }

    foreach ($matches as $match) {
      $Property = new Property($this, $match['name']);
      $this->properties[$Property->getName()] = $Property;
    }

    return $this->properties;
  }


  /**
   * @throws EntityException
   */
  private function getProperty(string $name): Property {
    $Property = $this->getProperties()[$name] ?? null;

    if(!$Property) {
      throw new EntityException("Property '{$name}' does not exist in ".get_class($this));
    }

    return $Property;
  }
}
