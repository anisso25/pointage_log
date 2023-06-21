<!DOCTYPE html>
<html>

<head>
    <title>Exportation des données</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <div class="container">
        <h1>Exportation des données</h1>
        <form action="export.php" method="POST">
            <label for="start_date">Date de début :</label>
            <input type="date" id="start_date" name="start_date" required value="<?php echo date("d-m-Y");?>">

            <label for="end_date">Date de fin :</label>
            <input type="date" id="end_date" name="end_date" required value="<?php echo date("d-m-Y");?>">

            <input type="submit" value="Exporter">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];

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

            if ($result->num_rows > 0) {
                // Exporter les données dans un fichier CSV
                $filename = "export.csv";
                $file = fopen($filename, "w");

                // En-têtes du fichier CSV
                $headers = array("ID", "Nom utilisateur", "Date", "Heure début", "Heure fin");
                fputcsv($file, $headers);

                // Lignes de données
                while ($row = $result->fetch_assoc()) {
                    $data = array($row['id'], $row['nom_utilisateur'], $row['date_pointage'], $row['heure_pointage'], $row['heure_fin_pointage']);
                    fputcsv($file, $data);
                }

                fclose($file);

                // Afficher le lien de téléchargement
                echo '<p><a href="' . $filename . '">Télécharger le fichier CSV</a></p>';

                // Afficher le tableau des données
                echo '<div class="table-container">';
                echo '<table>';
                echo '<tr><th>ID</th><th>Nom utilisateur</th><th>Date</th><th>Heure début</th><th>Heure fin</th></tr>';

                $file = fopen($filename, "r");
                $firstLine = true;

                while (($data = fgetcsv($file)) !== false) {
                    if ($firstLine) {
                        $firstLine = false;
                        continue;
                    }

                    echo '<tr>';
                    foreach ($data as $cell) {
                        echo '<td>' . $cell . '</td>';
                    }
                    echo '</tr>';
                }

                fclose($file);

                echo '</table>';
                echo '</div>';

                // Afficher le lien de téléchargement
                echo '<p><a href="' . $filename . '">Télécharger le fichier CSV</a></p>';
            } else {
                echo "<p>Aucune donnée disponible pour l'exportation.</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>

</html>