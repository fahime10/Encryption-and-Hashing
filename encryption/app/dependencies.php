<?php

// Register component on container
//use DoctrineSessions\Controllers\HomePageController;
//use DoctrineSessions\Validator;
//use DoctrineSessions\SessionWrapper;

use Slim\Views\Twig;

$container['view'] = function ($container) {
    $view = new Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            'debug' => true // This line should enable debug mode
        ]
    );

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['homePageController'] = function () {
    return new Encryption\HomePageController();
};

$container['homePageView'] = function () {
    return new Encryption\HomePageView();
};

$container['registerUserController'] = function () {
    return new Encryption\RegisterUserController();
};

$container['registerUserModel'] = function () {
    return new Encryption\RegisterUserModel();
};

$container['registerUserView'] = function () {
    return new Encryption\RegisterUserView();
};

$container['loginUserController'] = function() {
    return new Encryption\LoginUserController();
};

$container['loginUserModel'] = function() {
    return new Encryption\LoginUserModel();
};

$container['loginUserView'] = function() {
    return new Encryption\LoginUserView();
};

$container['loginResultController'] = function() {
    return new Encryption\LoginResultController();
};

$container['loginResultModel'] = function() {
    return new Encryption\LoginResultModel();
};

$container['loginResultView'] = function() {
    return new Encryption\LoginResultView();
};

$container['validator'] = function () {
    return new Encryption\Validator();
};

$container['libSodiumWrapper'] = function () {
    return new Encryption\LibSodiumWrapper();
};

$container['base64Wrapper'] = function () {
    return new Encryption\Base64Wrapper();
};

$container['bcryptWrapper'] = function () {
    return new Encryption\BcryptWrapper();
};

$container['doctrineSqlQueries'] = function () {
    return new Encryption\DoctrineSqlQueries();
};

//$container['dbase'] = function ($container) {
//    $db_conf = $container['settings']['pdo'];
//    $host_name = $db_conf['rdbms'] . ':host=' . $db_conf['host'];
//    $port_number = ';port=' . '3306';
//    $user_database = ';dbname=' . $db_conf['db_name'];
//    $host_details = $host_name . $port_number . $user_database;
//    $user_name = $db_conf['user_name'];
//    $user_password = $db_conf['user_password'];
//    $pdo_attributes = $db_conf['options'];
//    $pdo = null;
//    try
//    {
//        $pdo = new PDO($host_details, $user_name, $user_password, $pdo_attributes);
//    }
//    catch (PDOException $exception_object)
//    {
//        trigger_error('error connecting to  database');
//    }
//    return $pdo;
//};

/**
 * Using Doctrine
 * @param $c
 * @return \Doctrine\ORM\EntityManager
 * @throws \Doctrine\ORM\Exception\ORMException
 */

$container['em'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

