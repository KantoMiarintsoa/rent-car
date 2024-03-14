<?php

require('database.php');

$con = connect();


$file = file_get_contents(getcwd() . '/migrations/create-tables.sql');
$con->exec($file);

$add_user = readline("Default admin username: ");
$password = readline("Password: ");

$cursor = $con->prepare("insert into User (username, password) values (:username, :password)");
$cursor->execute([
    ":username" => $add_user,
    ":password" => md5($password)
]);

$seed = strtolower(readline('Do you want to seed with dummy data[Y/N]: '));
if ($seed == "y") {
    $populate = file_get_contents(getcwd() . '/migrations/populate-tables.sql');
    $con->exec($populate);
}
