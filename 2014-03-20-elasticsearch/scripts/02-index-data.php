<?php

require __DIR__ . '/bootstrap.php';

$mimeTypes = ['image/jpg', 'image/png', 'image/gif'];
$faker = Faker\Factory::create();

function indexRecord(\Elasticsearch\Client $client, array $record) {
    $ret = $client->index([
        'body' => $record,
        'index' => INDEX_SENSIO,
        'type'  => TYPE_RECORD,
        'id'    => $record['record_id'],
    ]);

    if (isset($ret['error'])) {
        throw new RuntimeException('Unable to execute method index');
    }
}

for ($i = 1; $i <= 200; $i++) {
    shuffle($mimeTypes);
    $record = [
        'record_id'        => $i,
        'mime_type' => current($mimeTypes),
        'title'     => $faker->name,
        'caption'   => 'lorem ipsum dolor pouet pouet '.$faker->name,
        'business-tracker' => $faker->sha1,
        'technical_informations' => [
            'width' => mt_rand(40, 200) * 10,
            'height' => mt_rand(40, 200) * 10,
            'iso' => mt_rand(1, 12) * 100,
            'longitude' => mt_rand(-18000, 18000) / 100,
            'latitude' => mt_rand(-9000, 9000) / 100,
        ],
        'created_on' => $faker->iso8601,
        'updated_on' => $faker->iso8601,
    ];

    indexRecord($client, $record);
    echo '. ';
}

echo "\n";
