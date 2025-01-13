<?php
declare(strict_types=1);

namespace App\Enum;

enum VatTypeEnum: int {

  /**
   * Základní sazba
   */
  case STANDARD = 1;

  /**
   * Snížená sazba
   */
  case REDUCED = 2;

  /**
   * Druhá snížená sazba
   */
  case REDUCED2 = 3;

  /**
   * Supersnížená sazba
   */
  case SUPER_REDUCED = 4;

  /**
   * Nulová sazba
   */
  case ZERO = 5;

  /**
   * Parkovací sazba
   */
  case PARKING = 6;

}