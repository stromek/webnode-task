<?php
declare(strict_types=1);
namespace Entity\Property\Validator;

use App\Entity\Property\Validator\EmailAddress;
use PHPUnit\Framework\TestCase;


class EmailAddressTest extends TestCase {

  public function testValidate() {

    $Object = new EmailAddress();
    $this->assertTrue($Object->validate("test@example.com"), "Valid email address");
    $this->assertFalse($Object->validate("test"), "Invalid email address");
  }

}
