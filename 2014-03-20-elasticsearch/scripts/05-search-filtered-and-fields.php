<?php

require __DIR__ . '/bootstrap.php';

// resources http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-filtered-query.html#query-dsl-filtered-query

$query = [
    'index' => INDEX_SENSIO,
    'type'  => TYPE_RECORD,
    'from' => 0,
    'size' => 5,
    'body'  => [
        'fields' => ['record_id'],
        'sort'   => [
            'created_on' => 'desc',
            '_score'     => 'desc',
        ],
        'query' => [
            'filtered' => [
                'query' => [
                    "term" => [
                        "mime_type" => "image/jpg"
                    ],
                ],
                'filter' => [
                    'and' => [
                        [
                            "range" => [
                                "technical_informations.width" => [
                                    "from" => "400",
                                    "to" => "8000"
                                ]
                            ]
                        ],
                        [
                            "range" => [
                                "technical_informations.height" => [
                                    "from" => "40",
                                    "to" => "8000"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
];

//printJson($query);

printJson($client->search($query));
