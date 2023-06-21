<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs des champs du formulaire
    $username = $_POST["username"];
    $password = $_POST["password"];
    $nom = $_POST["nom"];

    // Connexion à la base de données
    require_once 'config.php';

    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

    // Vérifier si la connexion à la base de données a réussi
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Préparer la requête d'insertion
    $sql = "INSERT INTO utilisateurs (username, password, nom) VALUES ('$username', '$password', '$nom')";

    // Exécuter la requête d'insertion
    if ($conn->query($sql) === TRUE) {
        echo "L'utilisateur a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un utilisateur</title>
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 960px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        font-weight: bold;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="password"] {
        padding: 5px;
        margin-bottom: 10px;
        width: 300px;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #4caf50;
        color: white;
        border: none;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Ajouter un utilisateur</h2>

        <form method="POST" action="ajouter.php">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required><br>

            <input type="submit" value="Ajouter">
        </form>
    </div>
</body>

</html>