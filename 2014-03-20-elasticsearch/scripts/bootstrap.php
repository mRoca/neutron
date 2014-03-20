<?php

require __DIR__ . '/../vendor/autoload.php';

define('INDEX_SENSIO', 'sensiolabs');
define('TYPE_RECORD', 'record');

function printJson($data) {
    print(json_encode($data, JSON_PRETTY_PRINT));
}

$options = [
    'host'  => '127.0.0.1',
    'port'  => '9200',
    'index' => INDEX_SENSIO,
];

return $client = new Elasticsearch\Client(['hosts' => [sprintf('%s:%s', $options['host'], $options['port'])]]);
