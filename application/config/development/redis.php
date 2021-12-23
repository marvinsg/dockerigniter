<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Redis settings
| -------------------------------------------------------------------------
| Your Redis servers can be specified below.
|
|	See: https://codeigniter.com/user_guide/libraries/caching.html#redis-caching
|
*/

$config['socket_type'] = 'tcp'; //`tcp` or `unix`
$config['socket'] = '/var/run/redis.sock'; // in case of `unix` socket type
$config['host'] = $_ENV['REDIS_HOST'];
$config['password'] = $_ENV['REDIS_PASSWORD'];
$config['port'] = $_ENV['REDIS_PORT'];
$config['timeout'] = 0;
