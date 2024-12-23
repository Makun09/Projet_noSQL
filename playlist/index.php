<?php
ob_start(); // Ajout de mise en mémoire tampon


$title = 'Playlists';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/player.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/cards.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /home/');
    exit();
}

$db = getDatabaseConnection();
$userId = $_SESSION['user_id']; // ID de l'utilisateur connecté
$mongoUserId = new MongoDB\BSON\ObjectId($userId);

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create' && isset($_POST['name'])) {
            $name = htmlspecialchars($_POST['name']);
            createPlaylist($db, $name, $mongoUserId);
        } elseif ($action === 'delete' && isset($_POST['playlist_id'])) {
            $playlistId = $_POST['playlist_id'];
            deletePlaylist($db, $playlistId, $mongoUserId);
        }
    }
}

$playlists = getPlaylistsByUserId($db, $mongoUserId);
ob_end_flush(); // Fin de la mise en mémoire tampon
?>



<div class="container mt-4">
    <h1>Gérer les Playlists</h1>

    <!-- Formulaire de création de playlist -->
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Nom de la playlist" required>
            <button class="btn btn-success" type="submit" name="action" value="create">
                <i class="bi bi-plus-lg"></i> Créer
            </button>
        </div>
    </form>

    <!-- Liste des playlists -->
    <h2>Vos Playlists</h2>
    <div class="d-flex flex-row flex-wrap gap-3">
        <?php if (!empty($playlists)) { ?>
            <?php foreach ($playlists as $playlist) { ?>
                <div class="card text-start" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($playlist['name']); ?></h5>
                        <p class="card-text"><?php echo count($playlist['songs']) . ' musiques'; ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="/playlist/view.php?playlist_id=<?php echo (string)$playlist['_id']; ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            <!-- Lien vers ajouter une musique à la playlist -->
                            <a href="ajouter_music_playlist.php?playlist_id=<?php echo (string) $playlist['_id']; ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Ajouter de la musique
                            </a>
                            <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette playlist ?');">
                                <input type="hidden" name="playlist_id" value="<?php echo (string) $playlist['_id']; ?>">
                                <button class="btn btn-danger btn-sm" type="submit" name="action" value="delete">
                                    <i class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucune playlist trouvée.</p>
        <?php } ?>
    </div>
</div>
