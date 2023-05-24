<?php

const DB_HOST = 'mycalendar_db';
const DB_NAME = 'my_calendar';
const DB_USER = 'my-calendar-user';
const DB_PASSWORD = '1234';

try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($db->connect_errno) {
        throw new Exception("Unable to connect to database: ".$db->connect_error);
    }
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}