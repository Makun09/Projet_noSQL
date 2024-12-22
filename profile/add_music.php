<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_artist']) || $_SESSION['is_artist'] !== true) {
    header('Location: profile.php');
    exit();
}
?>

<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Ajouter une musique</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulaire d'ajout de musique -->
    <form action="process_add_music.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="music_title" class="form-label">Titre de la musique</label>
            <input type="text" class="form-control" id="music_title" name="music_title" required>
        </div>

        <div class="mb-3">
            <label for="audio_file" class="form-label">Fichier audio</label>
            <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio/*" required>
        </div>

        <div class="mb-3">
            <label for="album_art" class="form-label">Pochette de l'album</label>
            <input type="file" class="form-control" id="album_art" name="album_art" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-3">Ajouter la musique</button>
    </form>
</div>
</body>
</html>
