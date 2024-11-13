<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opiskelijan kurssikirjautumiset</title>
</head>
<body>
    <li><a href="opiskelijat.php">Takaisin opiskelijalistaukseen</a></li>
    <h1>Opiskelijan kurssikirjautumiset</h1>

    <?php
    include 'yhteys.php';

    // Tarkista, että opiskelijanumero-parametri on määritelty
    if (isset($_GET['id'])) {
        $opiskelijaId = $_GET['id'];

        // Hae opiskelijan tiedot opiskelijanumerolla
        $stmt = $pdo->prepare("SELECT * FROM opiskelijat WHERE opiskelijanumero = :opiskelijanumero");
        $stmt->execute(['opiskelijanumero' => $opiskelijaId]);
        $opiskelija = $stmt->fetch();

        if (!$opiskelija) {
            echo "Opiskelijaa ei löytynyt.";
            exit;
        }

        echo "<h2>Opiskelija: " . htmlspecialchars($opiskelija['etunimi']) . " " . htmlspecialchars($opiskelija['sukunimi']) . " (Vuosikurssi: " . htmlspecialchars($opiskelija['vuosikurssi']) . ")</h2>";

        // Hae kurssikirjautumiset
        $query = $pdo->prepare("
            SELECT kurssit.nimi, kurssit.alkupaiva, kurssit.loppupaiva 
            FROM kurssikirjautumiset
            JOIN kurssit ON kurssikirjautumiset.kurssi_id = kurssit.tunnus
            WHERE kurssikirjautumiset.opiskelija_id = :opiskelija_id
        ");
        $query->execute(['opiskelija_id' => $opiskelijaId]);
        $kurssit = $query->fetchAll();

        if ($kurssit) {
            echo "<table border='1'><tr><th>Kurssin nimi</th><th>Aloituspäivämäärä</th><th>Loppupäivämäärä</th></tr>";
            foreach ($kurssit as $kurssi) {
                echo "<tr><td>{$kurssi['nimi']}</td><td>{$kurssi['alkupaiva']}</td><td>{$kurssi['loppupaiva']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Opiskelijalla ei ole kurssikirjautumisia.</p>";
        }

        // "Lisää kurssille" -lomake
        echo "<h3>Lisää opiskelija kurssille</h3>";
        echo "<form action='' method='post'>";
        echo "<label>Valitse kurssi: ";
        echo "<select name='kurssi_id'>";

        // Hae kaikki kurssit lomakkeen valikkoa varten
        $kurssitStmt = $pdo->query("SELECT * FROM kurssit");
        while ($kurssi = $kurssitStmt->fetch()) {
            echo "<option value='{$kurssi['tunnus']}'>{$kurssi['nimi']}</option>";
        }

        echo "</select></label>";
        echo "<input type='submit' name='lisaa_kurssille' value='Lisää kurssille'>";
        echo "</form>";

        // Käsittele lomakkeen lähetys
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lisaa_kurssille'])) {
            $kurssiId = $_POST['kurssi_id'];

            // Lisää opiskelijan kurssille kurssikirjautumiset-tauluun
            $insertStmt = $pdo->prepare("INSERT INTO kurssikirjautumiset (opiskelija_id, kurssi_id, kirjautumispaiva) VALUES (:opiskelija_id, :kurssi_id, NOW())");
            $insertStmt->execute(['opiskelija_id' => $opiskelijaId, 'kurssi_id' => $kurssiId]);

            echo "<p>Opiskelija lisätty kurssille onnistuneesti!</p>";
            // Päivitä sivu näyttämään uusi kurssikirjautuminen
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }
    } else {
        echo "Opiskelijanumero puuttuu!";
        exit;
    }
    ?>

</body>
</html>
