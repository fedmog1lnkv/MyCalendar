<?php

const DB_HOST = 'localhost';
const DB_NAME = 'my_calendar';
const DB_USER = 'root';
const DB_PASSWORD = '***';

try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($db->connect_errno) {
        throw new Exception("Unable to connect to database: ".$db->connect_error);
    }
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}