<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Property\Validator\NotEmpty;
use App\Entity\Property\Mutator\Decimal;
use App\Enum\OrderItemTypeEnum;
use App\Enum\VatTypeEnum;


/**
 * Další možné atributy:
 *  - ID produktu, vazba na sklad
 *  - kod zboží, pro expedici a čtečky - buď vzít ze skladu nebo textově pro textové položky (můžeme expedovat zboží které nevlastníme)
 *  - množství (float)
 *  - výše slevy (nejen pro analytiku ale i marketing)
 *  - typ slevy (odkud pochozí, kdo ji dal..)
 *
 * Další entity a vlastnosti:
 *  - evidence jednotlivých kusů
 *  - v případě speciálního typu (OrderItemTypeEnum) navázat 1:1 další entity
 *  -- doprava
 *  -- platba
 *  -- svoz zboží z jiné objednávky
 *  -- svoz zboží do jiné objednávky
 *  - dle typu položky rozlišovat zda je možné změnit počet apod.
 *
 * @property int $id
 * @property int $order_id
 * @property string $name
 * @property float $priceBase
 * @property float $priceVat
 * @property float $priceTotal
 * @property float $vatRate
 * @property VatTypeEnum $vatType
 * @property OrderItemTypeEnum $orderItemType
 */
class OrderItemEntity extends Entity {

  private int $id;

  private int $order_id;

  #[NotEmpty]
  private string $name;

  private VatTypeEnum $vatType = VatTypeEnum::STANDARD;

  #[Decimal(2)]
  private float $priceBase;

  #[Decimal(2)]
  private float $priceVat;

  #[Decimal(2)]
  private float $priceTotal;

  #[Decimal(2)]
  private float $vatRate;

  private OrderItemTypeEnum $orderItemType = OrderItemTypeEnum::PRODUCT;

}