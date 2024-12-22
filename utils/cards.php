<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';

// Fonction pour afficher une musique
function displaySong($song)
{ ?>
    <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;"
        onmouseover="this.querySelector('.card').classList.add('bg-body-tertiary');
                     this.querySelector('button').style.opacity='1';"
        onmouseout="this.querySelector('.card').classList.remove('bg-body-tertiary');
                    this.querySelector('button').style.opacity='0';">
        <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;">
            <img src="https://picsum.photos/256" class="card-img-top rounded" alt="Album Art">
            <div class="card-body pt-1">
                <h5 class="card-title" style="font-weight: bold;"><?php echo $song['title']; ?></h5>
                <p class="card-text text-muted"><?php echo getArtistById($song['artist'])['name']; ?></p>
            </div>
        </a>
        <button class="btn btn-primary btn-sm position-absolute rounded-circle"
            style="opacity: 0; right: 10px; top: 10px; transition: opacity 0.6s ease;"
            onclick="player.playSong('/uploads/music/<?= $song['filename'] ?>','<?= $song['title']; ?>','<?= getArtistById($song['artist'])['name']; ?>',document.getElementById('<?php echo $song['album_art']; ?>').src)">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

<?php }

// Fonction pour afficher une musique avec un bouton de lecture
function displaySongWithPlayButton($song)
{ ?>
    <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
        <div class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;">
            <div class="position-relative">
                <img src="https://picsum.photos/256" class="card-img-top rounded" alt="Album Art" id="img-<?php echo $song['_id']; ?>">
                <button class="btn btn-success btn-sm position-absolute bottom-0 end-0 m-2 rounded-circle" onclick="player.playSong(
                    '/uploads/music/<?php echo $song['filename']; ?>',
                    '<?php echo $song['title']; ?>',
                    '<?php echo getArtistById($song['artist'])['name']; ?>',
                    document.getElementById('img-<?php echo $song['_id']; ?>').src
                )">
                    <i class="bi bi-play-fill"></i>
                </button>
            </div>
            <div class="card-body pt-1">
                <h5 class="card-title" style="font-weight: bold;"><?php echo $song['title']; ?></h5>
                <p class="card-text text-muted"><?php echo getArtistById($song['artist'])['name']; ?></p>
            </div>
        </div>
    </div>
<?php }

// Fonction pour afficher une playlist
function displayPlaylist($playlist)
{ ?>
    <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
        <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;"
            onmouseover="this.classList.add('bg-body-tertiary');
                         this.nextElementSibling.style.opacity='1';"
            onmouseout="this.classList.remove('bg-body-tertiary');
                        this.nextElementSibling.style.opacity='0';">
            <img src="https://picsum.photos/256" class="card-img-top rounded" alt="Album Art">
            <div class="card-body pt-1">
                <h5 class="card-title" style="font-weight: bold;"><?= $playlist['name'] ?></h5>
                <p class="card-text text-muted"><?php echo getUserById($playlist['user_id'])['username'] ?></p>
            </div>
        </a>
    </div>


<?php }

// Fonction pour afficher un artiste
function displayArtist($artist)
{ ?>
    <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
        <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;"
            onmouseover="this.classList.add('bg-body-tertiary');
                         this.nextElementSibling.style.opacity='1';"
            onmouseout="this.classList.remove('bg-body-tertiary');
                        this.nextElementSibling.style.opacity='0';">
            <img src="https://picsum.photos/256" class="card-img-top rounded-circle" alt="Album Art">
            <div class="card-body pt-3">
                <h5 class="card-title" style="font-weight: bold;"><?php echo getArtistById($artist['_id'])['name']; ?></h5>
            </div>
        </a>
    </div>
<?php } ?>
