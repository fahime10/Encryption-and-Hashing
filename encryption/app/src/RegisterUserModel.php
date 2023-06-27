<?php

namespace Encryption;

use Doctrine\DBAL\DriverManager;

class RegisterUserModel
{

    public function __construct(){}

    public function __destruct() { }


    function cleanupParameters($validator, $tainted_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_username = $tainted_parameters['username'];
        $tainted_email = $tainted_parameters['email'];
        $tainted_requirements = $tainted_parameters['requirements'];

        $cleaned_parameters['password'] = $tainted_parameters['password'];
        $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
        $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);
        $cleaned_parameters['sanitised_requirements'] = $validator->sanitiseString($tainted_requirements);
        return $cleaned_parameters;
    }


    function encrypt($libsodium_wrapper, $cleaned_parameters)
    {
        $encrypted = [];
        $encrypted['encrypted_username_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_username']);
        $encrypted['encrypted_email_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_email']);
        $encrypted['encrypted_dietary_requirements_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_requirements']);

        return $encrypted;
    }

    function encode($base64_wrapper, $encrypted_data)
    {
        $encoded = [];
        $encoded['encoded_username'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_username_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_email'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_email_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_requirements'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_dietary_requirements_and_nonce']['nonce_and_encrypted_string']);
        return $encoded;
    }

    /**
     * Uses the Bcrypt library with constants from settings.php to create hashes of the entered password
     *
     * @param $app
     * @param $password_to_hash
     * @return string
     */
    function hash_password($bcrypt_wrapper, $password_to_hash): string
    {
        $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
        return $hashed_password;
    }

    /**
     * function both decodes base64 then decrypts the extracted cipher code
     *
     * @param $libsodium_wrapper
     * @param $base64_wrapper
     * @param $encoded
     * @return array
     */
    function decrypt($libsodium_wrapper, $base64_wrapper, $encoded): array
    {
        $decrypted_values = [];

        $decrypted_values['username'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_username']
        );

        $decrypted_values['email'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_email']
        );

        $decrypted_values['dietary_requirements'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_requirements']
        );

        return $decrypted_values;
    }

    /**
     *
     * Uses the Doctrine QueryBuilder API to store the sanitised user data.
     *
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    function storeUserDetails($database_connection_settings, $doctrine_queries, array $cleaned_parameters, string $hashed_password): string
    {
        $storage_result = [];
        $store_result = '';

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();

        $storage_result = $doctrine_queries::queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password);

        if ($storage_result['outcome'] == 1)
        {
            $store_result = 'User data was successfully stored using the SQL query: ' . $storage_result['sql_query'];
        }
        else
        {
            $store_result = 'There appears to have been a problem when saving your details.  Please try again later.';

        }
        return $store_result;
    }

    function testRetrieve($app, array $cleaned_parameters)
{
    $retrieve_result = [];

    $database_connection_settings = $app->getContainer()->get('doctrine_settings');
    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
    $database_connection = DriverManager::getConnection($database_connection_settings);

    $queryBuilder = $database_connection->createQueryBuilder();
    $retrieve_result = $doctrine_queries::queryRetrieveUserData($queryBuilder, $cleaned_parameters);

    return $retrieve_result;
}

}
