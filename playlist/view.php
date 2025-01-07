<?php
ob_start(); // Ajout de mise en mémoire tampon
$title = 'Voir Playlist';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/player.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/cards.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /home/');
    exit();
}

$userId = $_SESSION['user_id']; // ID de l'utilisateur connecté
$mongoUserId = new MongoDB\BSON\ObjectId($userId);

// Vérifier si l'ID de la playlist est passé dans l'URL
if (isset($_GET['playlist_id'])) {
    $playlistId = $_GET['playlist_id'];
    try {
        $mongoPlaylistId = new MongoDB\BSON\ObjectId($playlistId);
    } catch (MongoDB\Driver\Exception\InvalidArgumentException $e) {
        // Si l'ID n'est pas valide, rediriger avec un message d'erreur
        header('Location: /playlist/index.php?error=ID de playlist invalide');
        exit();
    }

    // Récupérer la playlist
    $playlist = getPlaylistById($mongoPlaylistId);
    if (!$playlist || (string)$playlist['user_id'] !== (string)$mongoUserId) {
        header('Location: /playlist/index.php?error=Playlist non trouvée ou non autorisée');
        exit();
    }
} else {
    header('Location: /playlist/index.php?error=Aucune playlist spécifiée');
    exit();
}
ob_end_flush(); // Fin de la mise en mémoire tampon

?>

<div class="container mt-4">
    <h1>Détails de la Playlist</h1>

    <div class="card mb-4">
        <img src="<?php echo htmlspecialchars($playlist['image']); ?>" class="card-img-top" alt="Image de la playlist">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($playlist['name']); ?></h5>
            
            <p class="card-text"><?php echo count($playlist['songs']) . ' musiques'; ?></p>
        </div>
    </div>

    <h3>Liste des Musiques</h3>
    <?php if (!empty($playlist['songs'])) { ?>
        <div class="list-group">
            <?php
            // Récupérer les informations des musiques dans la playlist
            foreach ($playlist['songs'] as $songId) {
                $song = getSongById($songId);
                if ($song) {
                    ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo htmlspecialchars($song['title']); ?></span>
                        
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    <?php } else { ?>
        <p>Aucune musique dans cette playlist.</p>
    <?php } ?>

    <h3 class="mt-4">Ajouter une musique</h3>
    <form action="ajouter_music_playlist.php" method="POST">
        <input type="hidden" name="playlist_id" value="<?php echo (string)$playlist['_id']; ?>">
        <div class="mb-3">
            <label for="song" class="form-label">Sélectionner une musique</label>
            <select class="form-select" id="song" name="song_id" required>
                <option value="">Sélectionner une musique</option>
                <?php
                $songs = getSongs();
                foreach ($songs as $song) {
                    ?>
                    <option value="<?php echo (string)$song['_id']; ?>"><?php echo htmlspecialchars($song['title']); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Ajouter à la playlist</button>
    </form>
</div>
