<?php
declare(strict_types=1);

namespace App\Mapper;


abstract class MapperMySQL implements MapperInterface {


  protected function entityToDibiArray(\App\Entity\Entity $Entity): array {
    $result = [];

    foreach($Entity->getProperties() as $Property) {
      $Modifier = $this->getPropertyModifier($Property);

      if($Modifier) {
        $result[$Property->getName()] = [$Modifier, $this->getPropertyValue($Property)];
      }
    }

    return $result;
  }


  protected function getPropertyModifier(\App\Entity\Property\Property $Property): ?string {
    // @TODO Dome smth with ReflectionIntersectionType|\ReflectionNamedType|\ReflectionUnionType
    // - vrátit modifikátory podle typu property
    return match($Property->getType()) {
      default => "%s"
    };
  }


  protected function getPropertyValue(\App\Entity\Property\Property $Property): mixed {
    return $Property->getValueSafe();
  }

}