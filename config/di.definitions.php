<?php
declare(strict_types=1);

return [
  ...require('di.definitions.storage.php'),
  ...require('di.definitions.http.php'),
  ...require('di.definitions.repository.php'),
];