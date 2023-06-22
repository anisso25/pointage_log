<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Récupérer les paramètres de la requête
    $start_date = $_GET["start_date"];
    $end_date = $_GET["end_date"];

    // Connexion à la base de données
    require_once 'config.php';

    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Construction de la requête SQL en fonction des dates
    $selectQuery = "SELECT hp.id, u.nom AS nom_utilisateur, hp.date_pointage, hp.heure_pointage, hp.heure_fin_pointage
                    FROM historique_pointages hp
                    JOIN utilisateurs u ON hp.utilisateur_id = u.id
                    WHERE hp.date_pointage BETWEEN '$start_date' AND '$end_date' ORDER BY hp.date_pointage";

    $result = $conn->query($selectQuery);

    $exportData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $start_time = strtotime($row['heure_pointage']);
            $end_time = strtotime($row['heure_fin_pointage']);
            $duration = gmdate('H:i:s', $end_time - $start_time); // Calcul de la durée en heures

            $exportData[] = array(
                'id' => $row['id'],
                'nom_utilisateur' => $row['nom_utilisateur'],
                'date_pointage' => $row['date_pointage'],
                'heure_pointage' => $row['heure_pointage'],
                'heure_fin_pointage' => $row['heure_fin_pointage'],
                'duree' => $duration
            );
        }
    }

    $conn->close();

    // Renvoyer les données exportées au format JSON
    header('Content-Type: application/json');
    echo json_encode($exportData);
}
?>