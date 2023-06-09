<?php

$utilisateur_id = $_GET['utilisateur_id'];
$nom = $_GET['nom'];
$date = $_GET['date'];
$heure = $_GET['heure'];

echo "$nom, votre pointage a été enregistré avec succès.";

echo '<form action="logout.php" method="POST">
        <input type="hidden" name="utilisateur_id" value="' . $utilisateur_id . '">
        <input type="submit" value="Déconnexion">
    </form>';

echo "ID de l'utilisateur : " . $utilisateur_id . "<br>";
echo "Nom de l'utilisateur : " . $nom . "<br>";
echo "Date de la session : " . $date . "<br>";
echo "Heure de pointage : " . $heure . "<br>";
?>