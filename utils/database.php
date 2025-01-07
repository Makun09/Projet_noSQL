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
    profile_picture
    bio
    liked_songs []
    is_artist
    is_admin
----------------
playlists
    _id
    user_id
    image
    name
    songs []
----------------
songs
    _id
    image
    title
    artist
    filename
    album_id
    album_art
    duration
----------------
albums
    _id
    title
    artist_id
    year
    album_art
----------------
artists
    _id
    name
    image
    bio
liked
    _id
    user_id
    songs []
*/
