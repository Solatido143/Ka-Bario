<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Auth\Token\Exception\InvalidToken;

$factory = (new Factory)
    ->withServiceAccount('jem4a-4b805-firebase-adminsdk-mg6e1-5d9f183dfb.json')
    ->withDatabaseUri('https://jem4a-4b805-default-rtdb.asia-southeast1.firebasedatabase.app/')
    ->withProjectId('jem4a-4b805');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

date_default_timezone_set('Asia/Manila');
$ref_req_tbl = 'request';
$ref_user_tbl = 'users';
$ref_logs_tbl = 'logs';
?>