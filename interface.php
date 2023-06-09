<!DOCTYPE html>
<html>

<head>
    <title>Pointage</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Pointage</h1>
        <?php
        $utilisateur_id = $_GET['utilisateur_id'];
        $nom = $_GET['nom'];
        $date = $_GET['date'];
        $heure = $_GET['heure'];

        echo "<p>$nom, votre pointage a été enregistré avec succès.</p>";

        echo '<form action="logout.php" method="POST">
                <input type="hidden" name="utilisateur_id" value="' . $utilisateur_id . '">
                <input type="submit" value="Déconnexion">
            </form>';

        echo '<div class="user-info">';
        echo "<p>ID de l'utilisateur : " . $utilisateur_id . "</p>";
        echo "<p>Nom de l'utilisateur : " . $nom . "</p>";
        echo "<p>Date de la session : " . $date . "</p>";
        echo "<p>Heure de pointage : " . $heure . "</p>";
        echo '</div>';
        ?>
    </div>
</body>

</html>