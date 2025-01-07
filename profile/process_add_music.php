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
    $title = htmlspecialchars(trim($_POST['music_title']));
    $audio_file = $_FILES['audio_file'];
    $album_art_file = $_FILES['album_art'];

    // Validation des données
    if (empty($title) || !$audio_file || $audio_file['error'] !== UPLOAD_ERR_OK || !$album_art_file || $album_art_file['error'] !== UPLOAD_ERR_OK) {
        header('Location: add_music.php?error=Tous les champs sont requis et les fichiers audio et image doivent être valides');
        exit();
    }

    // Déplacer le fichier audio vers le dossier de téléchargement
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/music/';
    $audio_filename = uniqid('music_') . '.' . pathinfo($audio_file['name'], PATHINFO_EXTENSION);
    $upload_file = $upload_dir . $audio_filename;

    // Déplacer le fichier de l'image de l'album vers le dossier de téléchargement
    $album_art_filename = uniqid('album_art_') . '.' . pathinfo($album_art_file['name'], PATHINFO_EXTENSION);
    $upload_album_art_file = $upload_dir . $album_art_filename;

    if (move_uploaded_file($audio_file['tmp_name'], $upload_file) && move_uploaded_file($album_art_file['tmp_name'], $upload_album_art_file)) {
        // Insertion dans la base de données
        $songs_collection->insertOne([
            'artist' => $_SESSION['artist_id'],
            'title' => $title,
            'filename' => $audio_filename,
            'album_art' => $album_art_filename,
        ]);

        // Redirection vers le profil
        header('Location: profile.php');
        exit();
    } else {
        header('Location: add_music.php?error=Erreur lors du téléchargement des fichiers');
        exit();
    }
}
