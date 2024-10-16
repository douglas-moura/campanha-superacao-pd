<?php

    @require_once __DIR__ . "/env.php";
    $configs = [
        'dev' => [
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => '',
            'dbname' => 'maxx_theraskin',
            'baseUrl' => 'localhost/maxx/theraskin/',
            'assets' => 'localhost/maxx/theraskin/assets/',
            'version' => '0.21',
            'imagePath' => 'https://res.cloudinary.com/maxxpremios/image/upload/q_auto:good/',
            'versionAssets' => '180411',
            'nomeCamp' => 'Maxx TheraSkin 2024',
            'emailCamp' => 'theraskin2024@maxxpremios.com.br',
            'versao' => '2.0802.24'
        ],
        'prod' => [
            'host' => 'localhost',
            'username' => 'gtxcombr_douglas',
            'password' => '@_Dgls_456_@',
            'dbname' => 'gtxcombr_maxxcampanha_theraskin',
            'baseUrl' => 'www.gtx100.com.br/maxx/theraskin24/',
            'assets' => 'www.gtx100.com.br/maxx/theraskin24/assets/',
            'version' => '0.21',
            'imagePath' => 'https://res.cloudinary.com/maxxpremios/image/upload/q_auto:good/',
            'versionAssets' => '180411',
            'nomeCamp' => 'Maxx TheraSkin 2024',
            'emailCamp' => 'theraskin2024@maxxpremios.com.br'
        ]
    ];

    $config = $configs['dev'];

    if (isset($env) && $env === 'dev') {
        $config = $configs['dev'];
    }