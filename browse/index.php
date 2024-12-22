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




    <!-- <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
            <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;"
                onmouseover="this.classList.add('bg-body-tertiary');
                         this.nextElementSibling.style.opacity='1';"
                onmouseout="this.classList.remove('bg-body-tertiary');
                        this.nextElementSibling.style.opacity='0';">
                <img src="https://picsum.photos/256" class="card-img-top rounded" alt="Album Art">
                <div class="card-body pt-1">
                    <h5 class="card-title" style="font-weight: bold;">Song Title</h5>
                    <p class="card-text text-muted">Artist Name</p>
                </div>
            </a>
            <button class="btn btn-primary btn-sm position-absolute rounded-circle"
                style="opacity: 0; right: 10px; top: 10px; transition: opacity 0.6s ease;"
                onclick="addToPlaylist(songId)">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div> -->
    </div>
    <h2 class="mt-4">Playlists</h2>
    <div class="d-flex flex-row flex-nowrap mt-3 gap-3 overflow-x-scroll">


        <?php
            foreach ($playlists as $playlist) {
                displayPlaylist($playlist);
            }
        ?>





    <!-- <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
            <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;"
                onmouseover="this.classList.add('bg-body-tertiary');
                         this.nextElementSibling.style.opacity='1';"
                onmouseout="this.classList.remove('bg-body-tertiary');
                        this.nextElementSibling.style.opacity='0';">
                <img src="https://picsum.photos/256" class="card-img-top rounded" alt="Album Art">
                <div class="card-body pt-1">
                    <h5 class="card-title" style="font-weight: bold;">Playlist Title</h5>
                    <p class="card-text text-muted">Artist Name</p>
                </div>
            </a>
        </div> -->
    </div>

    <h2 class="mt-4">Artistes</h2>
    <div class="d-flex flex-row flex-nowrap mt-3 gap-3 overflow-x-scroll">

        <?php
            foreach ($artists as $artist) {
                displayArtist($artist);
            }
        ?>




        <!-- <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
            <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;"
                onmouseover="this.classList.add('bg-body-tertiary');
                         this.nextElementSibling.style.opacity='1';"
                onmouseout="this.classList.remove('bg-body-tertiary');
                        this.nextElementSibling.style.opacity='0';">
                <img src="https://picsum.photos/256" class="card-img-top rounded-circle" alt="Album Art">
                <div class="card-body pt-3">
                    <h5 class="card-title" style="font-weight: bold;">Artist Name</h5>
                    <p class="card-text text-muted">Artiste</p>
                </div>
            </a>
        </div> -->
    </div>
</div>

<script>

</script>
