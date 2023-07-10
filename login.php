<?php
session_start();

require_once 'config.php';

// Connexion à la base de données
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Vérifier si la connexion à la base de données a réussi
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupération des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Vérification des informations de connexion
    $selectQuery = "SELECT * FROM utilisateurs WHERE username = '$username' AND password = '$password' LIMIT 1";
    $result = $conn->query($selectQuery);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Informations d'identification correctes
        $utilisateur_id = $row['id'];
        $nom = $row['nom'];
        $date = date("Y-m-d");
        $heure = date("H:i:s", time()); // Utilisation de l'heure du serveur

        // Enregistrement du pointage dans la table "historique_pointages"
        $insertHistoriqueQuery = "INSERT INTO historique_pointages (utilisateur_id, date_pointage, heure_pointage) VALUES ('$utilisateur_id', '$date', '$heure')";

        if ($conn->query($insertHistoriqueQuery) === TRUE) {
            // Redirection vers la page interface.php avec les variables utilisateur_id et nom
            header("Location: interface.php?utilisateur_id=" . $utilisateur_id . "&nom=" . urlencode($nom) . "&date=" . urlencode($date) . "&heure=" . urlencode($heure));
            exit();
        } else {
            $error = "Erreur lors de l'enregistrement du pointage dans la table 'historique_pointages' : " . $conn->error;
            $_SESSION['error_message'] = $error;
            header("Location: login.php");
            exit();
        }
    } else {
        // Informations d'identification incorrectes
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
        $_SESSION['error_message'] = $error;
        header("Location: login.php");
        exit();
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>