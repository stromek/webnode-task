<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Property\Mutator\Decimal;
use App\Entity\Property\Validator\EmailAddress;
use App\Entity\Property\Validator\NotEmpty;
use App\Entity\Property\Validator\Range;
use App\Enum\CountryEnum;
use App\Enum\CurrencyEnum;
use App\Enum\OrderStateEnum;


/**
 * Další možné atributy:
 *  - zákazník entita Customer
 *  - dodací adresa entita Address (může být ze zákazníka nebo odběrné místo/box)
 *  - nadřazená objednávka
 *  - kód objednávky (pokud se liší od ID)
 *  - rozšíření stavu (state) ještě dalším pod-stavem pro lepší práci
 *  - typ objednávky (obecně se nemusí jedna o objednávky k fakturaci, ale například expedice zboží - vratka reklamace apod.)
 *  - zdroj objednávky (pro analytiku, web, partner a jaky, zaměstnanec...)
 *  - způsob expedice (osobní odběr, odeslání, rozpad, odpis..)
 *  - partner v případě affiliate
 *  - obchodník zákazníka v případě VO
 *  - cenová skupina v případě více ceníků
 *  - kurz
 *  - viditelnost/blokace zboží v objednávce (někdy můžeme chtít zboží viditelné i když je v obj.)
 *  - viditelnost objednávky pro zákazníka (ne všechny objednávky zákazník musí vidět)
 *  - datum vytvoření VS datum přijetí (v případě duplikací objednávky může být rozdílné)
 *
 * Další entity a vlastnosti (většinou 1:N):
 *  - způsoby platby (dělené platby, dobírka, hotově, kartou, zálohou, převodem...)
 *  - evidence vystavených dokladů k obj
 *  - splátkový prodej a stavy splátek
 *  - objednané zboží (co objedná zákazník může být rozdílné s tím, co se nakonec prodá)
 *  - expedice zboží (vč. validace a kontroly)
 *  - historie stavů a události co se s obj. vůbec dějě
 *  - evidované balíky
 *  - poznámky (zákazníka, zaměstnance, na doklad, pro expedici, interní..)
 *
 * @property int $id
 * @property string $name
 * @property string $emailAddress
 * @property CurrencyEnum $currency
 * @property OrderStateEnum $state
 * @property CountryEnum $country
 * @property CountryEnum $countryVat
 * @property float $priceBase
 * @property float $priceVat
 * @property float $priceTotal
 * @property OrderItemEntity[] $items
 * @property \DateTime $receivedDateTime
 */
class OrderEntity extends Entity {

  #[Range(1, 100)]
  private int $id;

  #[NotEmpty]
  private string $name;

  #[EmailAddress]
  private string $emailAddress;

  private CurrencyEnum $currency = CurrencyEnum::CZK;

  private OrderStateEnum $state = OrderStateEnum::NEW;

  private CountryEnum $country = CountryEnum::CZ;

  /**
   * Země pro uplatnění DPH (pro případ OSS)
   */
  private ?CountryEnum $countryVat;

  #[Decimal(2)]
  private float $priceBase = 0;

  #[Decimal(2)]
  private float $priceVat = 0;

  #[Decimal(2)]
  private float $priceTotal = 0;

  /**
   * v případě, že se bude pracovat v různých časových zónách, je lepší INT timestamp
   */
  private \DateTime $receivedDateTime;

  /**
   * @var OrderItemEntity[]
   */
  private array $items = [];

  public function __construct() {
    // @TODO řešit přes attribut, aby nebylo nutné vždy řešit v konstruktoru
    $this->receivedDateTime = new \DateTime();

    $this->priceTotal = 4839.1431423;
  }


  public function addItem(OrderItemEntity $Item): void {
    $this->items[] = $Item;
    $this->calculate();
  }

  /**
   * @return OrderItemEntity[]
   */
  public function getItems(): array {
    return $this->items;
  }

  public function getCountryVat(): CountryEnum {
    return $this->countryVat ?? $this->country;
  }

  private function calculate(): void {
    // @TODO není optimální
    $this->priceBase = 0;
    $this->priceVat = 0;
    $this->priceTotal = 0;

    foreach ($this->getItems() as $Item) {
      $this->priceBase += $Item->priceBase;
      $this->priceVat += $Item->priceVat;
      $this->priceTotal += $Item->priceTotal;
    }

    $this->mutate();
  }

}