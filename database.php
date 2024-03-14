<?php

function connect()
{

    $env = parse_ini_file('.env');

    $server = $env['SERVER'];
    $database = $env['DATABASE'];
    $user = $env['USER'];
    $password = $env['PASSWORD'];
    return new PDO("mysql:host=$server;dbname=$database", $user, $password);
}
