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


<div class="container mt-4">
    <form method="GET" action="" class="mb-4 d-flex justify-content-center">
        <div class="input-group w-50">
            <input type="text" name="search" class="form-control" placeholder="Rechercher des musiques, playlists ou artistes..." value="<?php echo $search ?>">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Rechercher
            </button>
        </div>
    </form>

    <h2>Musiques</h2>
    <div class="d-flex flex-row flex-nowrap mt-3 gap-3 overflow-x-scroll">

        <?php
        foreach ($songs as $song) {
            displaySongWithPlayButton($song);
        }

        ?>

    </div>
    <h2 class="mt-4">Playlists</h2>
    <div class="d-flex flex-row flex-nowrap mt-3 gap-3 overflow-x-scroll">


        <?php
        foreach ($playlists as $playlist) {
            displayPlaylist($playlist);
        }
        ?>

    </div>

    <h2 class="mt-4">Artistes</h2>
    <div class="d-flex flex-row flex-nowrap mt-3 gap-3 overflow-x-scroll">

        <?php
        foreach ($artists as $artist) {
            displayArtist($artist);
        }
        ?>


    </div>
</div>

<script>

</script>
