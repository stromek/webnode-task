<?php
declare(strict_types=1);
namespace Entity;

use App\Entity\Entity;
use App\Entity\Property\Mutator\Decimal;
use App\Entity\Property\Validator\NotEmpty;
use PHPUnit\Framework\TestCase;


class EntityTest extends TestCase {

  public function testProperty() {
    $Entity = $this->createEntity();
    $Entity->id = 1;
    $this->assertEquals(1, $Entity->id);
  }


  public function testGetter() {
    $Entity = $this->createEntity();

    $Entity->getterModificationID = 10;
    $this->assertEquals(20, $Entity->getterModificationID);
  }


  public function testSetter() {
    $Entity = $this->createEntity();

    $Entity->setterModificationID = 10;
    $this->assertEquals(20, $Entity->setterModificationID);
  }


  public function testPropertyNotEmpty() {
    $Entity = $this->createEntity();

    $this->expectException(\App\Exception\EntityPropertyException::class);
    $Entity->name = "";
  }

  public function testPropertyMutator() {
    $Entity = $this->createEntity();
    $Entity->decimal = 1.1234;

    $this->assertEquals(1.12, $Entity->decimal);
  }


  private function createEntity(): Entity {
    /**
     * @property int $id
     * @property int $getterModificationID
     * @property int $setterModificationID
     * @property string $name
     * @property float $decimal
     */
    return new class extends Entity {
      private int $id;

      private int $getterModificationID;

      private int $setterModificationID;

      #[NotEmpty]
      private string $name = "name";

      #[Decimal(2)]
      private float $decimal;

      public function getGetterModificationID(): int {
        return $this->getterModificationID * 2;
      }

      public function setSetterModificationID(int $setterModificationID): void {
        $this->setterModificationID = $setterModificationID * 2;
      }
    };
  }


}
