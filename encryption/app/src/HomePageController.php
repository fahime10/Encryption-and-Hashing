<?php

namespace Encryption;

class HomePageController
{

    public function createHtmlOutput($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $homepage_view = $app->getContainer()->get('homePageView');

        $homepage_view->createHomePageView($view, $response);
    }
}