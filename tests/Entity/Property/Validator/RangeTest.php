<?php
declare(strict_types=1);
namespace Entity\Property\Validator;

use App\Entity\Property\Validator\Range;
use PHPUnit\Framework\TestCase;


class RangeTest extends TestCase {

  public function testValidate() {

    $Object = new Range(1, 100);
    $this->assertTrue($Object->validate(1));
    $this->assertTrue($Object->validate(100));
  }


  public function testValidateNoEdge() {
    $Object = new Range(1, null);
    $this->assertTrue($Object->validate(1));
    $this->assertTrue($Object->validate(100));

    $Object = new Range(null, 10);
    $this->assertTrue($Object->validate(1));
    $this->assertTrue($Object->validate(-10));
  }


  public function testValidateFail() {
    $Object = new Range(20, 30);
    $this->assertFalse($Object->validate(19));
    $this->assertFalse($Object->validate(31));

    $Object = new Range(20, null);
    $this->assertFalse($Object->validate(19));
  }

}
