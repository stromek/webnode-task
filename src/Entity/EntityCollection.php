<?php
declare(strict_types=1);

namespace App\Entity;


/**
 * Pokud by mělo fungovat $Order->items[] = new OrderItemEntity() (chyba Indirect modification of overloaded property)
 * musí __get() vracet referenci a nesmí vrátit samotné pole, neboť by nedošlo ke změně na instanci entity.
 *
 * Lze řešit vrácením objektu simulující pole (EntityCollection) a každou změnu pak zpětně propagovat do entity.
 * U vrácení této třídy by bylo vhodné použít \WeakMap() pro cachovani a zamezení vytváření velkého množství instancí
 * (při opakovaném přidávání do pole, např. v cyklu)
 */
class EntityCollection implements \ArrayAccess, \Countable, \Iterator {

  private array $array = [];

  private int $position = 0;

  private Entity $entity;

  private string $propertyName;

  public function __construct(Entity $Entity, string $propertyName, array $items) {
    $this->entity = $Entity;
    $this->propertyName = $propertyName;
    $this->array = $items;
  }

  public function offsetGet($offset): mixed {
    return $this->array[$offset] ?? null;
  }

  public function offsetSet($offset, $value): void {
    if(is_null($offset)) {
      $this->array[] = $value;
    }else{
      $this->array[$offset] = $value;
    }

    $this->update();
  }

  public function offsetExists($offset): bool {
    return isset($this->array[$offset]);
  }

  public function offsetUnset($offset): void {
    unset($this->array[$offset]);
  }

  public function count(): int {
    return count($this->array);
  }

  public function current(): mixed {
    return $this->array[$this->position];
  }

  public function key(): int {
    return $this->position;
  }

  public function next(): void {
    $this->position++;
  }

  public function valid(): bool {
    return isset($this->array[$this->position]);
  }

  public function rewind(): void {
    $this->position = 0;
  }

  public function toArray(): array {
    return $this->array;
  }

  private function update(): void {
    $this->entity->{$this->propertyName} = $this->array;
  }
}