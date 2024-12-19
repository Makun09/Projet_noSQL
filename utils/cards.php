<?php

// Fonction pour afficher les musiques
function displaySongs($songs) {
    echo '<div class="container mt-4"><h2>Musiques</h2><div class="row">';
    foreach ($songs as $song) {
        echo '<div class="col-md-4 mb-4">
            <div class="card">
                <img src="' . ($song['image'] ?? 'path/to/default.jpg') . '" class="card-img-top" alt="' . $song['title'] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $song['title'] . '</h5>
                    <p class="card-text">' . $song['artist'] . '</p>
                </div>
            </div>
        </div>';
    }
    echo '</div></div>';
}

// Fonction pour afficher les playlists
function displayPlaylists($playlists) {
    echo '<div class="container mt-4"><h2>Playlists</h2><div class="row">';
    foreach ($playlists as $playlist) {
        echo '<div class="col-md-4 mb-4">
            <div class="card">
                <img src="' . ($playlist['cover'] ?? 'path/to/default.jpg') . '" class="card-img-top" alt="' . $playlist['name'] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $playlist['name'] . '</h5>
                    <p class="card-text">' . $playlist['description'] . '</p>
                </div>
            </div>
        </div>';
    }
    echo '</div></div>';
}

// Fonction pour afficher les artistes
function displayArtists($artists) {
    echo '<div class="container mt-4"><h2>Artistes</h2><div class="row">';
    foreach ($artists as $artist) {
        echo '<div class="col-md-4 mb-4">
            <div class="card">
                <img src="' . ($artist['photo'] ?? 'path/to/default.jpg') . '" class="card-img-top" alt="' . $artist['name'] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $artist['name'] . '</h5>
                    <p class="card-text">' . $artist['genre'] . '</p>
                </div>
            </div>
        </div>';
    }
    echo '</div></div>';
}
