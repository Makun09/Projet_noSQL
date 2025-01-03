<?php
$title = "Profile";

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/player.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/cards.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../home');
    exit();
}

// Récupérer les informations de l'utilisateur
$default_profile_picture = "../img/static/default-profile.jpg";
$default_bio = "ajouter une biographie!";

// Vérification de l'image de profil de l'utilisateur
$profile_picture = !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : $default_profile_picture;
$bio = !empty($_SESSION['bio']) ? $_SESSION['bio'] : $default_bio;
$is_artist = !empty($_SESSION['is_artist']) ? $_SESSION['is_artist'] : false;

// Connexion à la base de données pour récupérer les musiques de l'utilisateur
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
$db = getDatabaseConnection();
$music_collection = $db->spotify->songs;

// Récupérer les musiques de l'utilisateur
$musics = $music_collection->find(['artist' => $_SESSION['artist_id']]);


// Si l'utilisateur est un artiste, ajouter le bouton pour ajouter une musique
?>

<div class="container mt-5">
    <div class="card mx-auto shadow-lg" style="max-width: 500px;">
        <div class="text-center p-4">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>"
                class="rounded-circle border img-fluid"
                alt="Photo de profil"
                style="width: 150px; height: 150px; object-fit: cover;">
        </div>
        <div class="card-body">
            <h5 class="card-title text-center mb-4"><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
            <p class="card-text text-center">
                <strong>EMAIL</strong> <?php echo htmlspecialchars($_SESSION['email']); ?><br>
            </p>
            <p class="card-text text-center">
                <strong>BIO</strong> <?php echo htmlspecialchars($bio); ?><br>
            </p>
        </div>
    </div>

    <!-- Afficher les musiques de l'utilisateur -->
    <?php if ($is_artist): ?>
        <h4 class="text-center mt-5">Mes Musiques</h4>
        <div class="mt-5">
            <?php if ($musics->isDead()): ?>
                <p class="text-center">Vous n'avez pas encore ajouté de musique.</p>
            <?php else: ?>
                <div class="d-flex  gap-3">
                    <?php foreach ($musics as $music): ?>
                        <?php displaySongWithPlayButton($music); ?>
                    <?php endforeach; ?>
                </div>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Bouton Modifier le profil -->
<div class="text-center mt-5">
    <a href="modif_profile.php" class="btn btn-lg" style="background-color: #6f42c1; color: white; border-color: #6f42c1;">Modifier le profil</a>
</div>

<!-- Bouton Ajouter une musique -->
<?php if ($is_artist): ?>
    <div class="text-center mt-4">
        <a href="add_music.php" class="btn btn-lg" style="background-color: #6f42c1; color: white; border-color: #6f42c1;">Ajouter une musique</a>
    </div>
<?php endif; ?>
