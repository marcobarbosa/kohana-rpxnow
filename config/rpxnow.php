<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('participar', 'participar')
    ->defaults(array(
        'controller' => 'user',
        'action'     => 'signup',
    ));

return array
(	
	'token_url' => 'http://localhost/sohker/response',
	'modal' => 'true',
	'language_preference' => 'pt-BR',
	'domain' => 'https://sohker.rpxnow.com/',
	'api_key' => 1209600	
);