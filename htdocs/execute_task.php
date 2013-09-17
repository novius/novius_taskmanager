<?php
define('NOS_ENTRY_POINT', 'task');

// Boot the app
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'novius-os'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'bootstrap.php';

$task = \Input::get('task', '');

$site_key = \Arr::get(\Config::load('crypt', true), 'crypto_key');
$hash = md5($site_key.'_'.$task);

if ($hash == \Input::get('check', '')) {
    $params = \Input::get();
    unset($params['task']);
    unset($params['check']);
    \Package::load('oil');
    \Refine::run($task, $params);
} else {
    echo 'Check key is incorrect';
}