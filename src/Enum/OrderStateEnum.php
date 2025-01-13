<?php
declare(strict_types=1);

namespace App\Enum;

enum OrderStateEnum: int {
  /**
   * Nová
   */
  case NEW = 1;

  /**
   * Zpracovává se
   */
  case PROCESSING = 2;

  /**
   * Potvrzeno
   */
  case CONFIRMED = 3;

  /**
   * K dokončení (k expedici/prodeji)
   */
  case COMPLETION = 4;

  /**
   * Dokončeno
   */
  case COMPLETED = 5;

  /**
   * Storno
   */
  case CANCELLED = 6;


  public function isFinalState(): bool {
    return in_array($this, [self::COMPLETED, self::CANCELLED]);
  }
}