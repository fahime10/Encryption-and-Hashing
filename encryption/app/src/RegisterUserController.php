<?php

namespace Encryption;

class RegisterUserController
{

    public function createHtmlOutput($app, $request, $response)
    {
        $tainted_parameters = $request->getParsedBody();

        $view = $app->getContainer()->get('view');
        $validator = $app->getContainer()->get('validator');
        $libsodium_wrapper = $app->getContainer()->get('libSodiumWrapper');
        $base64_wrapper = $app->getContainer()->get('base64Wrapper');
        $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');

        $registeruser_model = $app->getContainer()->get('registerUserModel');
        $registeruser_view = $app->getContainer()->get('registerUserView');

        $database_connection_settings = $app->getContainer()->get('doctrine_settings');
        $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');

        //returns the cleaned_parameters array
        $cleaned_parameters = $registeruser_model->cleanupParameters($validator, $tainted_parameters);

        $encrypted = $registeruser_model->encrypt($libsodium_wrapper, $cleaned_parameters);
        $encoded = $registeruser_model->encode($base64_wrapper, $encrypted);
        $hashed_password = $registeruser_model->hash_password($bcrypt_wrapper, $cleaned_parameters['password']);
        $decrypted = $registeruser_model->decrypt($libsodium_wrapper, $base64_wrapper, $encoded);

        $storage_result = $registeruser_model->storeUserDetails($database_connection_settings, $doctrine_queries, $cleaned_parameters, $hashed_password);
        $registeruser_view->createRegisterUserView($view, $response, $tainted_parameters, $cleaned_parameters,
                                                   $encrypted, $encoded, $decrypted, $hashed_password,
                                                   $storage_result);
    }
}