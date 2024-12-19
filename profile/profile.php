<?php
$title = "profile";

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../home');
    exit();
}

// Image de profil par défaut
$default_profile_picture = "../img/static/default-profile.jpg";
$default_bio="ajouter une biographie!";

// Vérification de l'image de profil de l'utilisateur
$profile_picture = !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : $default_profile_picture;
$bio = !empty($_SESSION['bio']) ? $_SESSION['bio'] : $default_bio;
?>

<body>
<div class="container mt-5">
    <div class="card mx-auto shadow-lg" style="max-width: 500px;">
        <!-- Ajout de marges et centrer l'image -->
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

    <!-- Bouton en bas avec espace supplémentaire -->
    <div class="text-center mt-5">
    <a href="modif_profile.php" class="btn btn-lg" style="background-color: #6f42c1; color: white; border-color: #6f42c1;">Modifier le profil</a>
    </div>
</div>

</body>
