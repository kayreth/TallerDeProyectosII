<?php
require_once 'environments.php';
require_once 'database.php';
$database = new Database($DB_HOST, $DB_NAME, $DB_USER, $DB_PASSWORD, $DB_PORT);
$database->connect();
?>