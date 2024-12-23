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


function createPlaylist($db, string $name, MongoDB\BSON\ObjectId $userId) {
    $collection = $db->spotify->playlists;
    $playlistData = [
        'user_id' => $userId,
        'name' => $name,
        'songs' => [], // Initialement vide
        'image' => '/img/default_playlist.png' // Image par défaut
    ];
    $collection->insertOne($playlistData);
}


function deletePlaylist($db, string $playlistId, MongoDB\BSON\ObjectId $userId) {
    $collection = $db->spotify->playlists;
    $collection->deleteOne([
        '_id' => new MongoDB\BSON\ObjectId($playlistId),
        'user_id' => $userId // Vérifie que la playlist appartient à l'utilisateur
    ]);
}


function updatePlaylist($db, string $playlist_id, array $updateData): bool {
    try {
        $collection = $db->spotify->playlists;
        $updateFields = [];
        if (isset($updateData['name'])) {
            $updateFields['name'] = $updateData['name'];
        }
        if (isset($updateData['songs'])) {
            $updateFields['songs'] = $updateData['songs'];
        }
        if (empty($updateFields)) {
            return false; // Rien à mettre à jour
        }
        $result = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($playlist_id)],
            ['$set' => $updateFields]
        );
        return $result->getModifiedCount() > 0;
    } catch (Exception $e) {
        error_log('Erreur lors de la mise à jour de la playlist: ' . $e->getMessage());
        return false;
    }
}

function getPlaylistsByUserId($db, MongoDB\BSON\ObjectId $userId) {
    $collection = $db->spotify->playlists;
    $playlists = $collection->find(['user_id' => $userId])->toArray();
    return $playlists;
}



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

function getPlaylistById(MongoDB\BSON\ObjectId $playlist_id) {
    $db = getDatabaseConnection();
    $collection = $db->spotify->playlists;
    $res = $collection->findOne(['_id' => $playlist_id]);

    return $res;
}


// Ajouter une musique à une playlist
function addSongToPlaylist($db, $playlistId, $songId) {
    $playlists = $db->spotify->playlists;

    // Ajouter la chanson à la playlist
    $playlists->updateOne(
        ['_id' => $playlistId],
        ['$addToSet' => ['songs' => new MongoDB\BSON\ObjectId($songId)]]
    );
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
    $res = $collection->findOne(['_id' => $artist_id]);


    // return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    return $res;
}

//////////////////////// DISPLAY ////////////////////////
