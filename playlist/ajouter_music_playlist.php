<?php
$title = 'Ajouter Musique à la Playlist';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/cards.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /home');
    exit();
}

$db = getDatabaseConnection();
$userId = $_SESSION['user_id']; // ID de l'utilisateur connecté
$mongoUserId = new MongoDB\BSON\ObjectId($userId);

// Récupérer l'ID de la playlist passé dans l'URL
if (isset($_GET['playlist_id'])) {
    $playlistId = $_GET['playlist_id'];
    try {
        // Convertir l'ID en ObjectId
        $mongoPlaylistId = new MongoDB\BSON\ObjectId($playlistId);
    } catch (MongoDB\Driver\Exception\InvalidArgumentException $e) {
        // Si l'ID n'est pas valide, redirigez vers la page des playlists
        header('Location: /playlist/index.php');
        exit();
    }

    // Vérifier si la playlist appartient à l'utilisateur connecté
    $playlist = getPlaylistById($mongoPlaylistId);
    if (!$playlist || (string)$playlist['user_id'] !== (string)$mongoUserId) {
        // Si la playlist n'existe pas ou n'appartient pas à l'utilisateur
        header('Location: /playlist/index.php');
        exit();
    }
} else {
    // Si aucun ID de playlist n'est passé dans l'URL
    header('Location: /playlist/index.php');
    exit();
}


// Gestion de l'ajout de musique à la playlist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['song_id'])) {
        $songId = $_POST['song_id'];
        addSongToPlaylist($db, $mongoPlaylistId, $songId);
    }
}

// Récupérer les musiques disponibles
$songs = getSongs($db);
?>

<div class="container mt-4">
    <h1>Ajouter une Musique à la Playlist : <?php echo htmlspecialchars($playlist['name']); ?></h1>

    <!-- Formulaire d'ajout de musique -->
    <form method="POST" class="mb-4">
        <div class="input-group">
            <select name="song_id" class="form-control" required>
                <option value="" disabled selected>Choisir une musique</option>
                <?php foreach ($songs as $song) { ?>
                    <option value="<?php echo (string) $song['_id']; ?>">
                        <?php echo htmlspecialchars($song['title']); ?> - <?php echo htmlspecialchars($song['artist']); ?>
                    </option>
                <?php } ?>
            </select>
            <button class="btn btn-success" type="submit">
                <i class="bi bi-plus-lg"></i> Ajouter à la Playlist
            </button>
        </div>
    </form>

    <a href="index.php" class="btn btn-secondary">Retour aux Playlists</a>
</div>
