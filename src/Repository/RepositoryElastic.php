<?php
declare(strict_types=1);

namespace App\Repository;

use App\Repository\Enum\RepositorySourceEnum;
use Elastic\Elasticsearch\Client;


abstract class RepositoryElastic implements RepositoryInterface {

  protected Client $client;

  public function __construct(Client $client) {
    $this->client = $client;
  }
  

  public function getSource(): RepositorySourceEnum {
    return RepositorySourceEnum::ELASTIC;
  }

}