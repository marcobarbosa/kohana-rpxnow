<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('response', 'response')
    ->defaults(array(
        'controller' => 'user',
        'action'     => 'response',
));
