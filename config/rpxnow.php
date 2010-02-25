<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('response', 'response')
    ->defaults(array(
        'controller' => 'user',
        'action'     => 'response',
    ));

return array
(
    'token_url' => 'Set this to yoursite.com/response',
    'modal' => 'true',
    'language_preference' => 'en',
    'domain' => 'YOUR_DOMAIN',
    'api_key' => 'YOUR_API_KEY'
);
