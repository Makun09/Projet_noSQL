<?php
// ...existing code...

require 'vendor/autoload.php'; // Assurez-vous que la bibliothèque MongoDB est installée via Composer

function getMongoDBConnection() {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    return $client->admin; // Connexion à la base de données 'admin'
}


// Exemple d'utilisation
$db = getMongoDBConnection();
var_dump($db->listCollections()); // Affiche les collections de la base de données 'admin'

// ...existing code...
?>
