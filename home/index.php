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
        <!-- Formulaire de recherche supprimé -->

        <!-- Grande carte en forme de bannière -->
        <div class="d-flex justify-content-center mb-4">
            <div class="card banner-card">
                <img src="/img/banner/img1.png" alt="Banner Image">
            </div>
        </div>

        <h2>Musiques</h2>
        <div class="d-flex justify-content-center padding-right">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-6 custom-card-spacing">
                <?php
                foreach ($songs as $song) {
                    echo '<div class="col">';
                    displaySongWithPlayButton($song);
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div class="d-flex justify-content-center mb-4">
            <div class="card banner-card">
                <img src="/img/banner/img2.png" alt="Banner Image">
            </div>
        </div>

        <h2 class="mt-4">Playlists</h2>
        <div class="d-flex justify-content-center">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-6 custom-card-spacing">
                <?php
                foreach ($playlists as $playlist) {
                    echo '<div class="col">';
                    displayPlaylist($playlist);
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <h2 class="mt-4">Artistes</h2>
        <div class="d-flex justify-content-center">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-6 custom-card-spacing">
                <?php
                foreach ($artists as $artist) {
                    echo '<div class="col">';
                    displayArtist($artist);
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script>

    </script>
</body>
</html>
