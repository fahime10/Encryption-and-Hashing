<?php
/**
 * registeruser.php
 *
 * calculate the result
 *
 * produces a result according to the user entered values and calculation type
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2015
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 */

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\DriverManager;

$app->post(
    '/registeruser',
    function(Request $request, Response $response) use ($app) {
        $registeruser_controller = $app->getContainer()->get('registerUserController');
        $registeruser_controller->createHtmlOutput($app, $request, $response);
    }
);

//        $retrieve_result = testRetrieve($app, $cleaned_parameters);
//
//
//        $this->view->render($response,
//            'register_user_result.html.twig',
//            [
//                'landing_page' => $_SERVER["SCRIPT_NAME"],
//                'css_path' => CSS_PATH,
//                'page_title' => APP_NAME,
//                'page_heading_1' => 'New User Registration',
//                'page_heading_2' => 'New User Registration',
//                'username' => $tainted_parameters['username'],
//                'password' => $tainted_parameters['password'],
//                'email' => $tainted_parameters['email'],
//                'requirements' => $tainted_parameters['requirements'],
//                'sanitised_username' => $cleaned_parameters['sanitised_username'],
//                'cleaned_password' => $cleaned_parameters['password'],
//                'sanitised_email' => $cleaned_parameters['sanitised_email'],
//                'sanitised_requirements' => $cleaned_parameters['sanitised_requirements'],
//                'hashed_password' => $hashed_password,
//                'libsodium_version' => $libsodium_version,
//                'nonce_value_username' => $encrypted['encrypted_username_and_nonce']['nonce'],
//                'encrypted_username' => $encrypted['encrypted_username_and_nonce']['encrypted_string'],
//                'nonce_value_email' => $encrypted['encrypted_username_and_nonce']['nonce'],
//                'encrypted_email' => $encrypted['encrypted_email_and_nonce']['encrypted_string'],
//                'nonce_value_dietary_requirements' => $encrypted['encrypted_username_and_nonce']['nonce'],
//                'encrypted_requirements' => $encrypted['encrypted_dietary_requirements_and_nonce']['encrypted_string'],
//                'encoded_username' => $encoded['encoded_username'],
//                'encoded_email' => $encoded['encoded_email'],
//                'encoded_requirements' => $encoded['encoded_requirements'],
//                'decrypted_username' => $decrypted['username'],
//                'decrypted_email' => $decrypted['email'],
//                'decrypted_dietary_requirements' => $decrypted['dietary_requirements'],
//                'storage_result' => $storage_result,
//            ]);
//
//    });
//

//function encrypt($app, $cleaned_parameters)
//{
//    $libsodium_wrapper = $app->getContainer()->get('libSodiumWrapper');
//
//    $encrypted = [];
//    $encrypted['encrypted_username_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_username']);
//    $encrypted['encrypted_email_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_email']);
//    $encrypted['encrypted_dietary_requirements_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_requirements']);
//
//    return $encrypted;
//}
//
//function encode($app, $encrypted_data)
//{
//    $base64_wrapper = $app->getContainer()->get('base64Wrapper');
//
//    $encoded = [];
//    $encoded['encoded_username'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_username_and_nonce']['nonce_and_encrypted_string']);
//    $encoded['encoded_email'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_email_and_nonce']['nonce_and_encrypted_string']);
//    $encoded['encoded_requirements'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_dietary_requirements_and_nonce']['nonce_and_encrypted_string']);
//    return $encoded;
//}
//
///**
// * Uses the Bcrypt library with constants from settings.php to create hashes of the entered password
// *
// * @param $app
// * @param $password_to_hash
// * @return string
// */
//function hash_password($app, $password_to_hash): string
//{
//    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
//    $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
//    return $hashed_password;
//}
//
///**
// * function both decodes base64 then decrypts the extracted cipher code
// *
// * @param $libsodium_wrapper
// * @param $base64_wrapper
// * @param $encoded
// * @return array
// */
//function decrypt($app, $encoded): array
//{
//    $decrypted_values = [];
//    $base64_wrapper = $app->getContainer()->get('base64Wrapper');
//    $libsodium_wrapper = $app->getContainer()->get('libSodiumWrapper');
//
//    $decrypted_values['username'] = $libsodium_wrapper->decrypt(
//        $base64_wrapper,
//        $encoded['encoded_username']
//    );
//
//    $decrypted_values['email'] = $libsodium_wrapper->decrypt(
//        $base64_wrapper,
//        $encoded['encoded_email']
//    );
//
//    $decrypted_values['dietary_requirements'] = $libsodium_wrapper->decrypt(
//        $base64_wrapper,
//        $encoded['encoded_requirements']
//    );
//
//    return $decrypted_values;
//}
//
///**
// *
// * Uses the Doctrine QueryBuilder API to store the sanitised user data.
// *
// * @param $app
// * @param array $cleaned_parameters
// * @param string $hashed_password
// * @return array
// * @throws \Doctrine\DBAL\DBALException
// */
//function storeUserDetails($app, array $cleaned_parameters, string $hashed_password): string
//{
//    $storage_result = [];
//    $store_result = '';
//    $database_connection_settings = $app->getContainer()->get('doctrine_settings');
//    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
//    $database_connection = DriverManager::getConnection($database_connection_settings);
//
//    $queryBuilder = $database_connection->createQueryBuilder();
//
//    $storage_result = $doctrine_queries::queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password);
//
//    if ($storage_result['outcome'] == 1)
//    {
//        $store_result = 'User data was successfully stored using the SQL query: ' . $storage_result['sql_query'];
//    }
//    else
//    {
//        $store_result = 'There appears to have been a problem when saving your details.  Please try again later.';
//
//    }
//    return $store_result;
//}
//
//function testRetrieve($app, array $cleaned_parameters)
//{
//    $retrieve_result = [];
//
//    $database_connection_settings = $app->getContainer()->get('doctrine_settings');
//    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
//    $database_connection = DriverManager::getConnection($database_connection_settings);
//
//    $queryBuilder = $database_connection->createQueryBuilder();
//    $retrieve_result = $doctrine_queries::queryRetrieveUserData($queryBuilder, $cleaned_parameters);
//
//    return $retrieve_result;
//}