<?php

    @require_once __DIR__ . "/env.php";
    $configs = [
        'dev' => [
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => '',
            'dbname' => 'superacao_prati',
            'baseUrl' => 'localhost/superacaopd/',
            'assets' => 'localhost/superacaopd/assets/',
            'version' => '0.21',
            'imagePath' => 'https://res.cloudinary.com/maxxpremios/image/upload/q_auto:good/',
            'versionAssets' => '180411',
            'nomeCamp' => 'Campanha Superação - Prati-Donaduzzi 2025',
            'emailCamp' => 'superacao-pd@gtx100.com.br',
            'versao' => '2.0802.24'
        ],
        'prod' => [
            'host' => 'localhost',
            'username' => 'gtxcombr_douglas',
            'password' => '@_Dgls_456_@',
            'dbname' => 'gtxcombr_superacao_prati',
            'baseUrl' => 'www.superacaopd.gtx100.com.br/',
            'assets' => 'www.superacaopd.gtx100.com.br/assets/',
            'version' => '0.21',
            'imagePath' => 'https://res.cloudinary.com/maxxpremios/image/upload/q_auto:good/',
            'versionAssets' => '180411',
            'nomeCamp' => 'Campanha Superação - Prati-Donaduzzi 2025',
            'emailCamp' => 'superacao-pd@gtx100.com.br'
        ]
    ];

    $config = $configs['dev'];

    if (isset($env) && $env === 'dev') {
        $config = $configs['dev'];
    }