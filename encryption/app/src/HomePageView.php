<?php

namespace Encryption;

class HomePageView
{
    public function __construct(){}

    public function __destruct(){}

    public function createHomePageView($view, $response): void
    {
        $view->render(
            $response,
            'homepageform.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'action' => 'registeruser',
                'method' => 'post',
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'New User Registration'
            ]);
    }
}