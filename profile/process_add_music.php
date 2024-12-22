<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_artist']) || $_SESSION['is_artist'] != true) {
    header('Location: ../home');
    exit();
}

// Connexion à la base de données
$db = getDatabaseConnection();
$songs_collection = $db->spotify->songs;

// Vérification du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $music_title = htmlspecialchars(trim($_POST['music_title']));
    $category = htmlspecialchars(trim($_POST['category']));
    $audio_file = $_FILES['audio_file'];

    // Validation des données
    if (empty($music_title) || empty($category) || !$audio_file || $audio_file['error'] !== UPLOAD_ERR_OK) {
        header('Location: add_music.php?error=Tous les champs sont requis et le fichier audio doit être valide');
        exit();
    }

    // Déplacer le fichier audio vers le dossier de téléchargement
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/music/';
    $audio_filename = uniqid('music_') . '.' . pathinfo($audio_file['name'], PATHINFO_EXTENSION);
    $upload_file = $upload_dir . $audio_filename;

    if (move_uploaded_file($audio_file['tmp_name'], $upload_file)) {
        // Insertion dans la base de données
        $songs_collection->insertOne([
            'user_id' => new MongoDB\BSON\ObjectId($_SESSION['user_id']),
            'music_title' => $music_title,
            'category' => $category,
            'audio_file' => '/uploads/music/' . $audio_filename,
            'artist_name' => $_SESSION['username'], // Le nom de l'artiste est celui de l'utilisateur
        ]);

        // Redirection vers le profil
        header('Location: profile.php');
        exit();
    } else {
        header('Location: add_music.php?error=Erreur lors du téléchargement du fichier audio');
        exit();
    }
}
