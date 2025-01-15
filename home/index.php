<?php
$title = 'Browse';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/player.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/cards.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';

$db = getDatabaseConnection();

$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

$songs = getSongsByString($search);
$playlists = getPlaylistsByString($search);
$artists = getArtistsByString($search);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- head.php est déjà inclus, mais au besoin, réassurez-vous que Bootstrap 5 est chargé -->
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- ...existing code... -->
    <style>
        .card {
            width: 15rem; /* Ajustez la largeur de la carte selon vos besoins */
            height: auto; /* Ajustez la hauteur de la carte selon vos besoins */

        }
        .custom-card-spacing > .col {
            margin-bottom: 8px; /* Ajustez selon votre préférence */
        }
        .custom-card-spacing.row {
            --bs-gutter-x: 15.25rem; /* Réduire l'espace horizontal entre les colonnes */
            --bs-gutter-y: 0.25rem; /* Réduire l'espace vertical entre les lignes */
        }
        .banner-card {
            width: 100%; /* Ajustez la largeur de la bannière selon vos besoins */
            border-radius: 15px;
            overflow: hidden;
        }
        .banner-card img {
            width: 100%;
            height: 100%;
        }
        .padding-right {
            padding-right: 20px; /* Ajustez le padding selon vos besoins */
        }
        .btn-register {
            background-color: #007bff; /* Utilisez la même couleur que le bouton Login */
            color: white;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <!-- Grande carte en forme de bannière -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <div class="card banner-card">
                    <img src="/img/banner/img1.png" alt="Banner Image">
                </div>
            </div>
        </div>

        <h2 class="text-center">Musiques</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php foreach ($songs as $song): ?>
                <div class="col">
                    <?php displaySongWithPlayButton($song); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row justify-content-center mb-4 mt-4">
            <div class="col-auto">
                <div class="card banner-card">
                    <img src="/img/banner/img2.png" alt="Banner Image">
                </div>
            </div>
        </div>

        <h2 class="text-center">Playlists</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php foreach ($playlists as $playlist): ?>
                <div class="col">
                    <?php displayPlaylist($playlist); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <h2 class="text-center mt-4">Artistes</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php foreach ($artists as $artist): ?>
                <div class="col">
                    <?php displayArtist($artist); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
