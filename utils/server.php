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

// SONGS \\

function getSongs() {
    $db = getDatabaseConnection();
    $songs = $db->spotify->songs;
    $res = $songs->find([]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getSongsByString(string $search) {
    $db = getDatabaseConnection();
    $songs = $db->spotify->songs;
    $res = $songs->find([
        'title' => ['$regex' => $search, '$options' => 'i']
    ]);

    // return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res->toArray();
}

function getSongById(string $id) {
    $db = getDatabaseConnection();
    $songs = $db->spotify->songs;
    $res = $songs->findOne(['_id' => $id]);

    return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

// PLAYLISTS \\

function getPlaylists() {
    $db = getDatabaseConnection();
    $playlists = $db->spotify->playlists;
    $res = $playlists->find([]);

    return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function getPlaylistsByString(string $search) {
    $db = getDatabaseConnection();
    $playlists = $db->spotify->playlists;
    $res = $playlists->find([
        'name' => ['$regex' => $search, '$options' => 'i']
    ]);

    return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function getPlaylistById(string $id) {
    $db = getDatabaseConnection();
    $playlists = $db->spotify->playlists;
    $res = $playlists->findOne(['_id' => $id]);

    return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

// ARTISTS \\

function getArtists() {
    $db = getDatabaseConnection();
    $artists = $db->spotify->artists;
    $res = $artists->find([]);

    return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function getArtistsByString(string $search) {
    $db = getDatabaseConnection();
    $artists = $db->spotify->artists;
    $res = $artists->find([
        'name' => ['$regex' => $search, '$options' => 'i']
    ]);

    return json_encode($res->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function getArtistById(string $id) {
    $db = getDatabaseConnection();
    $artists = $db->spotify->artists;
    $res = $artists->findOne(['_id' => $id]);

    return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

//////////////////////// DISPLAY ////////////////////////
