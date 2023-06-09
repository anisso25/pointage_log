<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <div id="message-container">
    </div>
    <form action="login.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Se connecter">
    </form>
</body>

</html>
<?php
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
            header("Location: interface.php?utilisateur_id=" . $utilisateur_id . "&nom=" . urlencode($nom) . "&date=" . urlencode($date). "&heure=" . urlencode($heure));
            exit();
        } else {
            echo "Erreur lors de l'enregistrement du pointage dans la table 'historique_pointages' : " . $conn->error;
        }
    } else {
        // Informations d'identification incorrectes
        echo "Nom d'utilisateur ou mot de passe incorrect.";

    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>