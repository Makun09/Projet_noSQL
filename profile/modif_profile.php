<?php
$title = "Modifier le profil";

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home');
    exit();
}

// Connexion à MongoDB
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
$db = getDatabaseConnection()->selectDatabase('spotify'); // Remplacez 'spotify' par votre base de données.
$collection = $db->users; // Collection 'users'

// Récupération des informations utilisateur depuis MongoDB
$user_id = $_SESSION['user_id'];
$user = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);

if (!$user) {
    die("Utilisateur introuvable.");
}

// Variables initiales
$username = $user['username'];
$email = $user['email'];
$bio = $user['bio'] ?? "Ajouter une biographie !";
$profile_picture = $user['profile_picture'] ?? "../img/static/default-profile.jpg";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les nouvelles données
    $new_username = htmlspecialchars(trim($_POST['username']));
    $new_bio = htmlspecialchars(trim($_POST['bio']));
    $new_email = htmlspecialchars(trim($_POST['email']));

    // Nouveau fichier image
    $new_profile_picture = $_FILES['profile_picture'];

    $update_data = [];
    $error_message = '';

    // Vérification du nom d'utilisateur
    if (!empty($new_username) && $new_username !== $username) {
        // Vérifier si le nom d'utilisateur est déjà pris
        $username_exists = $collection->findOne(['username' => $new_username]);
        if ($username_exists) {
            $error_message = "Le nom d'utilisateur est déjà pris.";
        } else {
            $update_data['username'] = $new_username;
        }
    }

    // Vérification de l'email
    if (!empty($new_email) && $new_email !== $email) {
        // Vérifier si l'email est déjà pris
        $email_exists = $collection->findOne(['email' => $new_email]);
        if ($email_exists) {
            $error_message = "L'email est déjà pris par un autre utilisateur.";
        } else {
            $update_data['email'] = $new_email;
        }
    }

    // Mise à jour des autres données si modifiées
    if (!empty($new_bio) && $new_bio !== $bio) {
        $update_data['bio'] = $new_bio;
    }

    // Traitement de l'image de profil si fournie
    if ($new_profile_picture && $new_profile_picture['error'] === UPLOAD_ERR_OK) {
        // Nouveau nom de fichier basé sur l'ID de l'utilisateur
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/img/profile/';
        $new_image_name = $user_id . '.png';  // Utilisation de l'ID de l'utilisateur pour le nom de fichier
        $upload_file = $upload_dir . $new_image_name;

        // Déplacer le fichier téléchargé dans le répertoire de destination avec le nouveau nom
        if (move_uploaded_file($new_profile_picture['tmp_name'], $upload_file)) {
            $update_data['profile_picture'] = '/img/profile/' . $new_image_name;
        }
    }

    // Mise à jour dans la base de données
    if (empty($error_message) && !empty($update_data)) {
        $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($user_id)],
            ['$set' => $update_data]
        );

        // Mettre à jour les variables de session
        $_SESSION['username'] = $update_data['username'] ?? $username;
        $_SESSION['bio'] = $update_data['bio'] ?? $bio;
        $_SESSION['profile_picture'] = $update_data['profile_picture'] ?? $profile_picture;
        $_SESSION['email'] = $update_data['email'] ?? $email;

        // Redirection vers la page de profil
        header('Location: profile.php');
        exit();
    }
}

// Suppression du profil
if (isset($_POST['delete'])) {
    // Supprimer le profil de la base de données
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);

    // Détruire la session et rediriger
    session_destroy();
    header('Location: ../home');
    exit();
}
?>

<body class="bg-dark text-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Modifier votre profil</h2>

    <!-- Card pour afficher les informations du profil -->
    <div class="card mx-auto shadow-lg bg-secondary text-light" style="max-width: 500px;">
        <div class="card-body">
            <!-- Formulaire de modification -->
            <form method="POST" enctype="multipart/form-data">
                <!-- Modifier le nom d'utilisateur -->
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?php echo htmlspecialchars($username); ?>" required>
                </div>

                <!-- Modifier l'e-mail -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?php echo htmlspecialchars($email); ?>" required>
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

                <!-- Message d'erreur -->
                <?php
                if (!empty($error_message)) {
                    echo '<div class="alert alert-danger mt-2">' . htmlspecialchars($error_message) . '</div>';
                }
                ?>

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

    <!-- Bouton de suppression du profil -->
    <div class="text-center mt-4">
        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Supprimer mon profil</button>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Êtes-vous sûr ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Vous êtes sur le point de supprimer votre profil. Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST">
                    <button type="submit" name="delete" class="btn btn-danger">Supprimer le profil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
