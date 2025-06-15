<?php

$mode = getenv('MODE') ?: 'local';

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME') ?: 'edufun';

if (!$host) {
    switch ($mode) {
        case 'prod':
            $host = 'edufun-db.internal';
            break;
        case 'staging':
            $host = '127.0.0.1';
            break;
        case 'local':
        default:
            $host = '127.0.0.1';
            break;
    }
}

$user = $user ?: 'root';
$pass = $pass ?: '';

$conn = mysqli_connect($host, $user, $pass, $db) or die('[db-service] MySQL connect error: ' . mysqli_connect_error());
?>


