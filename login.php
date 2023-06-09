<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
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
        $heure = date("H:i:s");

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

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Login</h1>
    <div id="login-form">
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
            unset($_SESSION['error_message']); // Supprimer le message d'erreur après l'avoir affiché
        }

        // Afficher le message de déconnexion s'il est présent
        if (isset($_SESSION['logout_message'])) {
            echo '<p>' . $_SESSION['logout_message'] . '</p>';
            unset($_SESSION['logout_message']); // Supprimer le message de session après l'avoir affiché
        }
        
        ?>
        <form action="login.php" method="POST">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>

</html>