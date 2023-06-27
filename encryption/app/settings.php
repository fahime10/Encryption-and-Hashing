<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 13/10/17
 * Time: 12:33
 */

const DIRSEP = DIRECTORY_SEPARATOR;
const APP_NAME = 'Encryption And Hashing';
const BCRYPT_ALGO = PASSWORD_DEFAULT;
const BCRYPT_COST = 12;

$url_root = $css_path = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
$css_path = $url_root . '/css/standard.css';
define('CSS_PATH', $css_path);
define('LANDING_PAGE', $_SERVER['SCRIPT_NAME']);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true,
            ]],
    ],
    'doctrine_settings' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'registered_users_db',
        'port' => '3306',
        'user' => 'registered_user',
        'password' => 'registered_user_pass',
        'charset' => 'utf8mb4'
    ],
];

return $settings;
