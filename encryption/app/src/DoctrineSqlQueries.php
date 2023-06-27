<?php
/**
 * DoctrineSqlQueries.php
 * class to contain all database access using Doctrine's QueryBuilder
 *
 * A QueryBuilder provides an API that is designed for conditionally constructing a DQL
 * query in several steps.
 *
 * It provides a set of framework and methods that is able to programmatically build queries,
 * and also provides a fluent API.
 *
 * This means that you can change between one methodology to the other as you want,
 * or just pick a preferred one.
 *
 * From https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 */

namespace Encryption;

class DoctrineSqlQueries
{
    public function __construct(){}

    public function __destruct(){}

    public static function queryStoreUserData($queryBuilder, array $cleaned_parameters, string $hashed_password)
    {
        $store_result = [];
        $username = $cleaned_parameters['sanitised_username'];
        $email = $cleaned_parameters['sanitised_email'];
        $dietary_requirements = $cleaned_parameters['sanitised_requirements'];

        $queryBuilder = $queryBuilder->insert('user_data')
            ->values([
                'user_name' => ':name',
                'email' => ':email',
                'dietary' => ':diet',
                'password' => ':password',
            ])
            ->setParameters([
                'name' => $username,
                'email' => $email,
                'diet' => $dietary_requirements,
                'password' => $hashed_password
            ]);

        $store_result['outcome'] = $queryBuilder->execute();
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }

    public static function queryRetrieveUserData($queryBuilder, array $cleaned_parameters)
    {
        $retrieve_result = [];
        $username = $cleaned_parameters['sanitised_username'];

        $queryBuilder
            ->select('password', 'email')
            ->from('user_data', 'u')
            ->where('user_name = ' .  $queryBuilder->createNamedParameter($username));

        $query = $queryBuilder->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public static function validateExistence($queryBuilder, array $cleaned_parameters, $hashed_password)
    {
        $result = "";

        $username = $cleaned_parameters['sanitised_username'];

        $queryBuilder
            ->select('username', 'password')
            ->from('user_data', 'u')
            ->where('user_name = ' . $queryBuilder->createNamedParameter($username) .
            'and password = '. $queryBuilder->createNamedParameter($hashed_password));

        // i am stuck here
        $query = $queryBuilder->execute();

    }
}
