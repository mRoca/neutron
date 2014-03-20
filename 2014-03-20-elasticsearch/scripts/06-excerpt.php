<?php

require __DIR__ . '/bootstrap.php';

// resources http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-queries.html

$query = [
    'index' => INDEX_SENSIO,
    'type'  => TYPE_RECORD,
    'body'  => [
        'sort'   => [
            'created_on' => 'desc',
            '_score'     => 'desc',
        ],
        'highlight' => [
            "pre_tags"  => ["<em>"],
            "post_tags" => ["</em>"],
            "fields"    => [
                'mime_type' => new stdClass(),
            ],
        ],
        'query' => [
            "term" => [
                "mime_type" => "image/jpg",
            ],
        ]
    ],
];

//printJson($query);

printJson($client->search($query));
