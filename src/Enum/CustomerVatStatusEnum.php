<?php
declare(strict_types=1);

namespace App\Enum;


enum CustomerVatStatusEnum {

  case UNKNOWN;

  // VAT payer
  case PAYER;

  // not a VAT payer
  case NONPAYER;

  // Payer in their own country, not for foreign transactions
  case SUBJECT;

}