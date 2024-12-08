<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

function getDatabaseConnection(): MongoDB\Client {
    try {
        return new MongoDB\Client('mongodb://localhost:27017');
    } catch (Exception $e) {
        returnError(500, 'Database Connection Error', 'Could not connect to the database. ' . $e->getMessage());
        die();
    }
}

// Tables de la BDD
/*
users
    _id
    username
    email
    password
----------------
playlists
    _id
    user_id
    image
    name
    ???
----------------
songs
    _id
    image
    playlist_id
    name
    artist
    album
    duration
----------------

*/
