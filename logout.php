<?php
$serveur = "localhost";
$utilisateur_db = "root";
$mot_de_passe_db = "root";
$nom_db = "test";

$connexion = new PDO("mysql:host=$serveur;dbname=$nom_db", $utilisateur_db, $mot_de_passe_db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_POST['utilisateur_id'];
    $heure_fin_pointage = date("H:i:s");
    $date_pointage = date('Y-m-d');

    $requete = $connexion->prepare("UPDATE historique_pointages SET heure_fin_pointage = :heure_fin WHERE utilisateur_id = :utilisateur_id AND date_pointage = :date_pointage");
    $requete->bindParam(':heure_fin', $heure_fin_pointage);
    $requete->bindParam(':utilisateur_id', $utilisateur_id);
    $requete->bindParam(':date_pointage', $date_pointage);
    $requete->execute();

    echo "Déconnexion réussie. Heure de fin de pointage enregistrée.";

    $connexion = null;

    include "login.php";
}
?>