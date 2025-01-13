<?php
declare(strict_types=1);
namespace Entity\Property\Validator;

use App\Entity\Property\Validator\NotEmpty;
use PHPUnit\Framework\TestCase;


class NotEmptyTest extends TestCase {

  public function testValidate() {

    $Object = new NotEmpty();
    $this->assertTrue($Object->validate("string"));
    $this->assertTrue($Object->validate(true));

    $this->assertFalse($Object->validate(""));
    $this->assertFalse($Object->validate(null));
    $this->assertFalse($Object->validate(false));
  }
}
