<?php
declare(strict_types=1);

namespace App\Entity\Factory;



abstract class EntityFactory {

  protected function setAttributes(\App\Entity\Entity $Entity, array $attributes = []): void {
    foreach($attributes as $name => $value) {
      $Entity->{$name} = $value;
    }
  }

}