<?php

require __DIR__ . '/bootstrap.php';

$query = [
    'index' => INDEX_SENSIO,
    'type'  => TYPE_RECORD,
    'body'  => [
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
                                    "from" => "1000",
                                    "to" => "8000"
                                ]
                            ]
                        ],
                        [
                            "range" => [
                                "technical_informations.height" => [
                                    "from" => "1000",
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
