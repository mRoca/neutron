<?php

$client = require __DIR__ . '/bootstrap.php';

function isResultOk(array $ret) {
    if (isset($ret['acknowledged']) && $ret['acknowledged']) {
        return true;
    }
    if (isset($ret['ok']) && $ret['ok']) {
        return true;
    }

    return false;
}

// resources http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/mapping-core-types.html

$index = [
    'index' => INDEX_SENSIO,
    'body'  => [
        'settings' => [
            'number_of_shards'   => 2,
            'number_of_replicas' => 0,
            'analysis' => [
                'analyzer' => [
                    'french' => [
                        'type'      => 'custom',
                        'tokenizer' => 'letter',
                        'filter'    => ["asciifolding", "lowercase", "french_stem", "stop_fr"]
                    ]
                ],
                'filter' => [
                    'stop_fr' => [
                        'type' => 'stop',
                        'stopwords' => ['l', 'm', 't', 'qu', 'n', 's', 'j', 'd'],
                    ]
                ],
            ],
        ],
        'mappings' => [
            TYPE_RECORD => [
                '_source' => [
                    'enabled' => true
                ],
                '_all' => [
                    'analyzer' => 'french',
                ],
                'properties' => [
                    'record_id' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed',
                    ],
                    'mime_type' => [
                        'type' => 'string',
                        'index' => 'not_analyzed',
                    ],
                    'title' => [
                        'type'           => 'string',
                        'include_in_all' => true,
                        'analyzer'       => 'french',
                    ],
                    'caption' => [
                        'type'           => 'string',
                        'include_in_all' => true,
                        'analyzer'       => 'french',
                    ],
                    'business-tracker' => [
                        'type'           => 'string',
                        'include_in_all' => false,
                        'index'          => 'not_analyzed',
                    ],
                    "technical_informations" => [
                        'properties' => [
                            'width' => [
                                'type' => 'integer',
                                'include_in_all' => false,
                                'index'          => 'not_analyzed',
                            ],
                            'height' => [
                                'type' => 'integer'
                            ],
                            'iso' => [
                                'type' => 'integer'
                            ],
                            'longitude' => [
                                'type' => 'float'
                            ],
                            'latitude' => [
                                'type' => 'float'
                            ],
                        ],
                    ],
                    "created_on" => [
                        'type' => 'date',
                        'index' => 'not_analyzed',
                    ],
                    "updated_on" => [
                        'type' => 'date',
                        'index' => 'not_analyzed',
                    ],
                ],
            ],
        ],
    ],
];


if ($client->indices()->exists(['index' => INDEX_SENSIO])) {
    $client->indices()->delete(['index' => INDEX_SENSIO]);
}

if (!isResultOk($client->indices()->create($index))) {
    throw new \RuntimeException('Unable to create index');
}
