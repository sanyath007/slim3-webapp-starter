<?php
return [
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    // Template paths
    'twig' => [
        'paths' => [
            realpath(__DIR__ . '/..') . '/resources/views',
        ],
        // Twig environment options
        'options' => [
            // Should be set to true in production
            'cache_enabled' => false,
            'cache_path' => realpath(__DIR__ . '/..') . '/tmp/twig',
        ],
    ]
];