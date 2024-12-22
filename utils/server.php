<?php

function methodIsAllowed(string $action): bool {
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($action) {
        case 'update':
            return $method == 'PATCH';
        case 'create':
            return $method == 'PUT';
        case 'read':
            return $method == 'GET';
        case 'delete':
            return $method == 'DELETE';
        default:
            return false;
    }
}

function returnError(string $message, string $page, int $code): void {
    http_response_code($code);
    header('location:' . $page . '?error=' . $message);
    exit();
}

function validateMandatoryParams(array $data, array $mandatoryParams): bool {
    foreach ($mandatoryParams as $param) {
        if (!isset($data[$param])) {
            return false;
        }
    }
    return true;
}


//////////////////////// GET ////////////////////////

// USERS \\

function getUsers() {
    $db = getDatabaseConnection();
    $collection = $db->spotify->users;
    $res = $collection->find([]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getUserById(string $user_id) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->users;
    $res = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);

    // return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res;
}

function getUserByUsername(string $username) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->users;
    $res = $collection->findOne(['username' => $username]);

    // return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res;
}


// SONGS \\

function getSongs() {
    $db = getDatabaseConnection();
    $collection = $db->spotify->songs;
    $res = $collection->find([]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getSongsByString(string $search) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->songs;
    $res = $collection->find([
        'title' => ['$regex' => $search, '$options' => 'i']
    ]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getSongById(string $song_id) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->songs;
    $res = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($song_id)]);

    // return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res;
}

// PLAYLISTS \\

function getPlaylists() {
    $db = getDatabaseConnection();
    $playlists = $db->spotify->playlists;
    $res = $playlists->find([]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getPlaylistsByString(string $search) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->playlists;
    $res = $collection->find([
        'name' => ['$regex' => $search, '$options' => 'i']
    ]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getPlaylistById(string $playlist_id) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->playlists;
    $res = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($playlist_id)]);


    // return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res;
}

// ARTISTS \\

function getArtists() {
    $db = getDatabaseConnection();
    $collection = $db->spotify->artists;
    $res = $collection->find([]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getArtistsByString(string $search) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->artists;
    $res = $collection->find([
        'name' => ['$regex' => $search, '$options' => 'i']
    ]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getArtistById($artist_id) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->artists;
    $res = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($artist_id)]);


    // return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res;
}

//////////////////////// DISPLAY ////////////////////////
