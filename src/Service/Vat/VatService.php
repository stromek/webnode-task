<?php
declare(strict_types=1);

namespace App\Service\Vat;

use App\Enum\CountryEnum;
use App\Enum\VatTypeEnum;


class VatService {

  private CountryEnum $country;

  public function __construct(CountryEnum $Country) {
    $this->country = $Country;
  }
  

  /**
   * @TODO Získat data z DB/číselníku a zohlednit i datum, ke kterému získáváme výšši DPH
   */
  public function getVatRate(VatTypeEnum $VatType, \DateTimeInterface $Date = null): float {
    $Date ??= new \DateTime();

    $data = [
      CountryEnum::CZ->name => [
        VatTypeEnum::STANDARD->value => 21,
        VatTypeEnum::REDUCED->value => 12,
        VatTypeEnum::REDUCED2->value => 12,
      ],
      CountryEnum::SK->name => [
        VatTypeEnum::STANDARD->value => 23,
        VatTypeEnum::REDUCED->value => 19,
        VatTypeEnum::REDUCED2->value => 5,
      ]
    ];


    return $data[$this->country->name][$VatType->value] ?? 0.0;
  }

}