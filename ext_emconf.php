<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Trusted URL Parameters',
    'description' => 'Adds a safe-guard to only generate links with trusted URL parameters from routing',
    'category' => 'fe',
    'author' => 'b13 GmbH',
    'author_email' => 'typo3@b13.com',
    'state' => 'stable',
    'version' => '1.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.16-12.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
