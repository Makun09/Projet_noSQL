<?php

// Fonction pour afficher une musique
function displaySong($song)
{ ?>
    <div class="position-relative flex-shrink-0 mb-3" style="width: 11rem; min-width: 11rem;">
        <a class="card text-start text-decoration-none p-2" href="" style="border: none; transition: background-color 0.3s ease;"
            onmouseover="this.classList.add('bg-body-tertiary');
                         this.nextElementSibling.style.opacity='1';"
            onmouseout="this.classList.remove('bg-body-tertiary');
                        this.nextElementSibling.style.opacity='0';">
            <img src="https://picsum.photos/256" class="card-img-top rounded" alt="Album Art">
            <div class="card-body pt-1">
                <h5 class="card-title" style="font-weight: bold;"><?php echo $song['title']; ?></h5>
                <p class="card-text text-muted"><?php echo $song['artist']; ?></p>
            </div>
        </a>
        <button class="btn btn-primary btn-sm position-absolute rounded-circle"
            style="opacity: 0; right: 10px; top: 10px; transition: opacity 0.6s ease;"
            onclick="addToPlaylist(<?php echo $song['_id']; ?>)">
            <i class="bi bi-plus-lg"></i>
        </button>
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
                <h5 class="card-title" style="font-weight: bold;">Playlist Title</h5>
                <p class="card-text text-muted">Artist Name</p>
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
                <h5 class="card-title" style="font-weight: bold;">Artist Name</h5>
                <p class="card-text text-muted">Artiste</p>
            </div>
        </a>
    </div>
<?php } ?>
