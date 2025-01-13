<?php
declare(strict_types=1);

namespace App\Enum;


/**
 * Každý typ položky má jiné vlastnosti v objednávce
 *
 * - započítat do celkové ceny pro výpočet doprava zdarma
 * - evidence slev na zákazníka
 * - možnost stornovat zboží
 * - předkontace/členění DPH pro evidenci v účetnictví
 * - určení množství
 * - hmotná/nehmotná položka
 */
enum OrderItemTypeEnum {
  /**
   * Produkt
   */
  case PRODUCT;

  /**
   * Doprava
   */
  case SHIPPING;

  /**
   * Popaltek za platbu
   */
  case PAYMENT;

  /**
   * Sleva
   */
  case DISCOUNT;

  /**
   * Textová položka
   */
  case TEXT;

  /**
   * Rezervace
   */
  case RESERVATION;

}