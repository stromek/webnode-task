<?php
declare(strict_types=1);

namespace App\Factory;

use DI\Container;


abstract class ContainerFactory {

  /**
   * @TODO možná přesunout jinam
   */
  private const DEFINTION_FILE = CONFIG_DIR."/di.definitions.php";


  public static function create(): Container {
    $Builder = new \DI\ContainerBuilder();
    $Builder->useAttributes(true);
    $Builder->addDefinitions(self::getDefinitions());

    return $Builder->build();
  }


  private static function getDefinitions(): array {
    if(!file_exists(self::DEFINTION_FILE)) {
      throw new \RuntimeException("DI definitions file '".self::DEFINTION_FILE."' not found");
    }

    return require(self::DEFINTION_FILE);
  }

}