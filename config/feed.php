<?php

return [

    'glorf' => [
        'id' => 'glorf',
        'source' => [
            'format' => 'json',
            'file' => 'feed-exports/glorf.json',
        ],
        'target.db' => 'mysql',
    ],

    'flub' => [
        'id' => 'flub',
        'source' => [
            'format' => 'yaml',
            'file' => 'feed-exports/flub.yaml',
        ],
        'target.db' => 'mysql',
    ],

];