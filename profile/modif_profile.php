<?php
$title = "Modifier le profil";

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../home');
    exit();
}

// Variables de session pour l'utilisateur actuel
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$bio = !empty($_SESSION['bio']) ? $_SESSION['bio'] : "Ajouter une biographie !";
$profile_picture = !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : "../img/static/img_default.jpg";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les nouvelles données
    $new_username = htmlspecialchars(trim($_POST['username']));
    $new_bio = htmlspecialchars(trim($_POST['bio']));
    $new_profile_picture = $_FILES['profile_picture'];

    // Validation des données (exemple simple)
    if (!empty($new_username)) {
        $_SESSION['username'] = $new_username;
    }

    if (!empty($new_bio)) {
        $_SESSION['bio'] = $new_bio;
    }

    // Traitement de l'image de profil si fournie
    if ($new_profile_picture && $new_profile_picture['error'] === UPLOAD_ERR_OK) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/img/uploads/';
        $upload_file = $upload_dir . basename($new_profile_picture['name']);
        if (move_uploaded_file($new_profile_picture['tmp_name'], $upload_file)) {
            $_SESSION['profile_picture'] = '/img/uploads/' . basename($new_profile_picture['name']);
        }
    }

    // Redirection vers le profil après modification
    header('Location: profile.php');
    exit();
}
?>

<body class="bg-dark text-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Modifier le profil</h2>
    <div class="card mx-auto shadow-lg bg-secondary text-light" style="max-width: 500px;">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <!-- Modifier le nom d'utilisateur -->
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?php echo htmlspecialchars($username); ?>" required>
                </div>

                <!-- Modifier l'e-mail (lecture seule pour cet exemple) -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" 
                           value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>

                <!-- Modifier la biographie -->
                <div class="mb-3">
                    <label for="bio" class="form-label">Biographie</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($bio); ?></textarea>
                </div>

                <!-- Modifier l'image de profil -->
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Photo de profil</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                    <small class="text-light">Laissez vide pour conserver l'image actuelle.</small>
                </div>

                <!-- Bouton de validation -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; border-color: #6f42c1;">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="text-center mt-4">
        <a href="profile.php" class="btn btn-outline-light">Retour au profil</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

